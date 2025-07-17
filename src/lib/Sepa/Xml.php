<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa;
use \ufozone\phpsepa\Sepa\Xml\Exception as XmlException;

/**
 * XML Class
 * 
 * @author Markus
 * @since      2017-06-08
 */
class Xml
{
	/**
	 * Format XML without indentation and extra space
	 * @var bool
	 */
	private $compression = false;
	
	/**
	 * Temp file
	 * @var string
	 */
	private $tmpFile = null;
	
	/**
	 * Final file
	 * @var string
	 */
	private $fnlFile = null;
	
	/**
	 * SEPA instance
	 * @var Sepa
	 */
	private $sepa = null;
	
	/**
	 * Create XML instance
	 * 
	 * @param Sepa $sepa
	 */
	public function __construct(Sepa $sepa)
	{
		$this->sepa = $sepa;
	}
	
	/**
	 * Delete temp file
	 */
	public function __destruct()
	{
		$this->cleanup();
	}
	
	/**
	 * To string
	 * 
	 * @return string
	 */
	public function __toString() : string
	{
		return $this->get();
	}
	
	/**
	 * Disable nicely formats output with indentation and extra space
	 * 
	 * @return Xml
	 */
	public function compress() : Xml
	{
		$this->compression = true;
		
		return $this;
	}
	
	/**
	 * Get XML
	 * 
	 * @return string
	 */
	public function get() : string
	{
		if ($this->tmpFile === null)
		{
			$this->create();
		}
		return file_get_contents($this->tmpFile);
	}
	
	/**
	 * Save XML to file
	 * 
	 * @param string $filename
	 * @return bool
	 */
	public function save(string $filename) : bool
	{
		// check that target does not exist
		if (is_readable($filename))
		{
			return false;
		}
		// create directory if not exist
		$dir = dirname($filename);
		if (!is_dir($dir))
		{
			if (!@mkdir($dir, 0777, true))
			{
				return false;
			}
			@chmod($dir, 0777);
		}
		// copy if final file is set
		if ($this->fnlFile !== null)
		{
			@copy($this->fnlFile, $filename);
			
			// failed to copy the whole content of source to target
			if (($sourceSize = filesize($this->fnlFile)) !== ($targetSize = filesize($filename)))
			{
				@unlink($filename);
				return false;
			}
			return true;
		}
		if ($this->tmpFile === null)
		{
			$this->create();
		}
		if (!@rename($this->tmpFile, $filename))
		{
			return false;
		}
		$this->tmpFile = null;
		$this->fnlFile = $filename;
		
		return true;
	}
	
	/**
	 * Download XML
	 *
	 * @param string $filename
	 * @return void
	 */
	public function download(string $filename = '') : void
	{
		if (!$filename = trim($filename))
		{
			$filename = 'sepa.xml';
		}
		header('Content-Type: text/xml');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		
		echo $this->get();
		exit;
	}
	
	/**
	 * Generate the XML file
	 * 
	 * @throws XmlException
	 * @return Xml
	 */
	public function create() : Xml
	{
		// validate
		$this->sepa->validate();
		
		// cleanup
		$this->cleanup();
		
		// create temporary file
		if (!$this->tmpFile = tempnam('/tmp', 'php.sepa.'))
		{
			throw new XmlException('Cannot open tmp file', XmlException::CANNOT_OPEN_TMP_FILE);
		}
		// initialize XMLWriter
		$xml = new \XMLWriter();
		$xml->openURI($this->tmpFile);
		
		// start generating
		$this->generateDocument($xml);
		
		// last chance to check if XML generation failed
		if (!$xml->endDocument())
		{
			throw new XmlException('Cannot create XML', XmlException::CANNOT_CREATE_XML);
		}
		return $this;
	}
	
	/**
	 * Validate XML
	 * 
	 * @throws XmlException
	 * @return bool
	 */
	public function validate() : bool
	{
		libxml_use_internal_errors(true);
		
		$xsdFile = $this->getSchemaFile();
		if ($this->tmpFile === null)
		{
			$this->create();
		}
		$xml = new \XMLReader();
		$xml->open($this->tmpFile);
		$xml->setSchema($xsdFile);
		while ($xml->read());
		
		return $xml->isValid();
	}
	
	/**
	 * Get schema file
	 * 
	 * @return string
	 */
	public function getSchemaFile() : string
	{
		$xsdFile = __DIR__ . '/../../schema/' . $this->sepa->getPain() . '.xsd';
		if (!is_file($xsdFile))
		{
			throw new XmlException('Schema file ' . $this->sepa->getPain() . '.xsd not found', XmlException::SCHEMA_FILE_NOT_FOUND);
		}
		return $xsdFile;
	}
	
	/**
	 * Get errors
	 * 
	 * @return array
	 */
	public function getErrors() : array
	{
		$errors = libxml_get_errors();
		foreach ($errors as &$error)
		{
			$error->message = preg_replace("(\{urn:iso[^\}]+\})", '', $error->message);
		}
		return $errors;
	}
	
	/**
	 * Get last error
	 * 
	 * @return Exception
	 */
	public function getLastError() : Exception
	{
		if ($lastError = libxml_get_last_error())
		{
			$lastError->message = preg_replace("(\{urn:iso[^\}]+\})", '', $lastError->message);
			return new Exception($lastError->message, $lastError->code);
		}
		return new Exception('Unknown Error');
	}
	
	/**
	 * Destroy temp file
	 */
	private function cleanup()
	{
		if ($this->tmpFile !== null)
		{
			@unlink($this->tmpFile);
		}
		$this->fnlFile = null;
	}
	
	/**
	 * Generate document root and group header
	 * 
	 * @param \XMLWriter $xml
	 */
	private function generateDocument(\XMLWriter $xml)
	{
		$isCreditTransfer = ($this->sepa->getType() === Sepa::CREDIT_TRANSFER);
		$ns = 'urn:iso:std:iso:20022:tech:xsd:' . $this->sepa->getPain();
		$messageId = $this->sepa->getId();
		$creationDateTime = (new \DateTime('now', new \DateTimeZone('Etc/UTC')))->format('Y-m-d\TH:i:s\Z');
		$numberOfTransactions = $this->sepa->getNumberOfTransactions();
		$controlSum = $this->sepa->getControlSum();
		$xmlType = ($isCreditTransfer) ? 'CstmrCdtTrfInitn' : 'CstmrDrctDbtInitn';
		
		$xml->startDocument('1.0', 'UTF-8');
		$xml->setIndent(!$this->compression);
		$xml->setIndentString('  ');
		
		// Document
		$xml->startElement('Document');
		$xml->writeAttribute('xmlns', $ns);
		$xml->writeAttributeNS('xsi', 'schemaLocation', 'http://www.w3.org/2001/XMLSchema-instance', 'urn:iso:std:iso:20022:tech:xsd:' . $this->sepa->getPain() . ' ' . $this->sepa->getPain() . '.xsd');
		
		// Content
		$xml->startElement($xmlType);
		
		// Build Header
		// GrpHdr
		$xml->startElement('GrpHdr');
		$xml->writeElement('MsgId', $messageId);
		$xml->writeElement('CreDtTm', $creationDateTime);
		$xml->writeElement('NbOfTxs', (string)$numberOfTransactions);
		$xml->writeElement('CtrlSum', $this->formatAmount($controlSum));
		// InitgPty
		$xml->startElement('InitgPty');
		$xml->writeElement('Nm', $this->formatString($this->sepa->getInitiator(), 70));
		$xml->endElement(); // InitgPty
		$xml->endElement(); // GrpHdr
		
		// Payment Collections
		$count = 0;
		foreach ($this->sepa->getPayments() as $payment)
		{
			// ignore empty payment collections
			if ($payment->getNumberOfTransactions() === 0)
			{
				continue;
			}
			$this->generatePayment($payment, $xml, ++$count);
		}
		$xml->endElement(); // Content
		$xml->endElement(); // Document
	}
	
	/**
	 * Generate payment information
	 * 
	 * @param Payment $payment
	 * @param \XMLWriter $xml
	 * @param int $count
	 */
	private function generatePayment(Payment $payment, \XMLWriter $xml, int $count)
	{
		$isCreditTransfer = ($this->sepa->getType() === Sepa::CREDIT_TRANSFER);
		$isDirectDebit = ($this->sepa->getType() === Sepa::DIRECT_DEBIT);
		$pmtInfId = $payment->getId() ?: ($this->sepa->getId() . '-' . $count);
		$numberOfTransactions = $payment->getNumberOfTransactions();
		$controlSum = $payment->getControlSum();
		$pmtClnt = ($isCreditTransfer) ? 'Dbtr' : 'Cdtr';
		$pmtScope = $payment->getScope() ?: $this->sepa->getDefaultScope();
		$pmtSequence = $payment->getSequence() ?: $this->sepa->getDefaultSequence();
		
		// PmtInf
		$xml->startElement('PmtInf');
		$xml->writeElement('PmtInfId', $pmtInfId);
		$xml->writeElement('PmtMtd', ($isCreditTransfer) ? 'TRF' : 'DD');
		$xml->writeElement('BtchBookg', $payment->isBatchBooking() ? 'true' : 'false');
		$xml->writeElement('NbOfTxs', (string)$numberOfTransactions);
		$xml->writeElement('CtrlSum', $this->formatAmount($controlSum));
		// PmtTpInf
		$xml->startElement('PmtTpInf');
		if ($isCreditTransfer && $priority = $payment->getPriority())
		{
			$xml->writeElement('InstrPrty', $priority);
		}
		// SvcLvl
		$xml->startElement('SvcLvl');
		$xml->writeElement('Cd', 'SEPA');
		$xml->endElement(); // SvcLvl
		if ($pmtScope)
		{
			// LclInstrm
			$xml->startElement('LclInstrm');
			$xml->writeElement('Cd', $pmtScope);
			$xml->endElement(); // LclInstrm
		}
		if ($isDirectDebit)
		{
			$xml->writeElement('SeqTp', $pmtSequence);
		}
		$xml->endElement(); // PmtTpInf
		
		if ($isDirectDebit)
		{
			$xml->writeElement('ReqdColltnDt', $payment->getDate());
		}
		else
		{
			// ReqdExctnDt
			$xml->startElement('ReqdExctnDt');
			$xml->writeElement('Dt', $payment->getDate());
			$xml->endElement(); // ReqdExctnDt
		}
		// Dbtr/Cdtr
		$xml->startElement($pmtClnt);
		$xml->writeElement('Nm', $this->formatString($payment->getAccountName(), 70));
		$xml->endElement(); // Dbtr/Cdtr
		
		// DbtrAcct/CdtrAcct
		$xml->startElement($pmtClnt . 'Acct');
		$xml->startElement('Id');
		$xml->writeElement('IBAN', $payment->getAccounIban());
		$xml->endElement(); // Id
		if ($accountCurrency = $payment->getAccountCurrency())
		{
			$xml->writeElement('Ccy', $accountCurrency);
		}
		$xml->endElement(); // DbtrAcct/CdtrAcct
		
		// DbtrAgt/CdtrAgt
		$xml->startElement($pmtClnt . 'Agt');
		$xml->startElement('FinInstnId');
		if ($accountBic = $payment->getAccountBic())
		{
			$xml->writeElement('BICFI', $accountBic);
		}
		else
		{
			$xml->startElement('Othr');
			$xml->writeElement('Id', 'NOTPROVIDED');
			$xml->endElement(); // Othr
		}
		$xml->endElement(); // FinInstnId
		$xml->endElement(); // DbtrAgt/CdtrAgt
		
		// Ultimate Debtor or Creditor
		if ($ultimateName = $payment->getUltimateName())
		{
			$xml->startElement('Ultmt' . $pmtClnt);
			$xml->writeElement('Nm', $this->formatString($ultimateName, 70));
			$xml->endElement(); // UltmtDbtr/UltmtCdtr
		}
		
		// Charge Bearer
		$xml->writeElement('ChrgBr', 'SLEV');
		if ($isDirectDebit)
		{
			$xml->startElement('CdtrSchmeId');
			$xml->startElement('Id');
			$xml->startElement('PrvtId');
			$xml->startElement('Othr');
			$xml->writeElement('Id', $payment->getCreditorId());
			$xml->startElement('SchmeNm');
			$xml->writeElement('Prtry', 'SEPA');
			$xml->endElement(); // SchmeNm
			$xml->endElement(); // Othr
			$xml->endElement(); // PrvtId
			$xml->endElement(); // Id
			$xml->endElement(); // CdtrSchmeId
		}
		// Transaktionen
		$count = 0;
		foreach ($payment->getTransactions() as $transaction)
		{
			$this->generateTransaction($transaction, $xml);
			
			// flush XML from memory to file every 1000 iterations
			if (($count++ % 1000) === 0)
			{
				$xml->flush(true);
			}
		}
		$xml->endElement(); // PmtInf
	}
	
	/**
	 * Generate transaction information
	 * 
	 * @param Transaction $transaction
	 * @param \XMLWriter $xml
	 */
	private function generateTransaction(Transaction $transaction, \XMLWriter $xml)
	{
		$isCreditTransfer = ($this->sepa->getType() === Sepa::CREDIT_TRANSFER);
		$isDirectDebit = ($this->sepa->getType() === Sepa::DIRECT_DEBIT);
		$txClnt = ($isCreditTransfer) ? 'Cdtr' : 'Dbtr';
		
		// CdtTrfTxInf/DrctDbtTxInf
		$xml->startElement(($isCreditTransfer) ? 'CdtTrfTxInf' : 'DrctDbtTxInf');
		// PmtId
		$xml->startElement('PmtId');
		if ($instrId = $transaction->getId())
		{
			$xml->writeElement('InstrId', $instrId); // Instruction ID
		}
		$xml->writeElement('EndToEndId', $transaction->getEndToEndId() ?: 'NOTPROVIDED'); // End2End
		$xml->endElement(); // PmtId
		if ($isCreditTransfer)
		{
			$xml->startElement('Amt');
			$xml->startElement('InstdAmt');
			$xml->writeAttribute('Ccy', $transaction->getCurrency());
			$xml->text($this->formatAmount($transaction->getAmount()));
			$xml->endElement(); // InstdAmt
			$xml->endElement(); // Amt
		}
		else
		{
			//InstdAmt
			$xml->startElement('InstdAmt');
			$xml->writeAttribute('Ccy', $transaction->getCurrency());
			$xml->text($this->formatAmount($transaction->getAmount()));
			$xml->endElement(); // InstdAmt
			
			// DrctDbtTx
			$xml->startElement('DrctDbtTx');
			// MndtRltdInf
			$xml->startElement('MndtRltdInf');
			$xml->writeElement('MndtId', $transaction->getMandateId());
			$xml->writeElement('DtOfSgntr', $transaction->getMandateDate());
			if ($transaction->hasMandateChanged()) // Mandate changed
			{
				$xml->writeElement('AmdmntInd', 'true');
				$xml->startElement('AmdmntInfDtls');
				if ($originalMandateId = $transaction->getOriginalMandateId())
				{
					$xml->writeElement('OrgnlMndtId', $originalMandateId);
				}
				$xml->startElement('OrgnlDbtrAcct');
				$xml->startElement('Id');
				$xml->startElement('Othr');
				$xml->writeElement('Id', 'SMNDA');
				$xml->endElement(); // Othr
				$xml->endElement(); // Id
				$xml->endElement(); // OrgnlDbtrAcct
				$xml->endElement(); // AmdmntInfDtls
			}
			$xml->endElement(); // MndtRltdInf
			$xml->endElement(); // DrctDbtTx
		}
		if ($bic = $transaction->getBic())
		{
			// CdtrAgt/DbtrAgt
			$xml->startElement($txClnt . 'Agt');
			$xml->startElement('FinInstnId');
			$xml->writeElement('BICFI', $bic);
			$xml->endElement(); // FinInstnId
			$xml->endElement(); // CdtrAgt/DbtrAgt
		}
		elseif ($isDirectDebit)
		{
			// CdtrAgt/DbtrAgt
			$xml->startElement($txClnt . 'Agt');
			$xml->startElement('FinInstnId');
			$xml->startElement('Othr');
			$xml->writeElement('Id', 'NOTPROVIDED');
			$xml->endElement(); // Othr
			$xml->endElement(); // FinInstnId
			$xml->endElement(); // CdtrAgt/DbtrAgt
		}
		// Cdtr/Dbtr
		$xml->startElement($txClnt);
		$xml->writeElement('Nm', $this->formatString($transaction->getName(), 70));
		$xml->endElement(); // Cdtr/Dbtr
		
		// CdtrAcct/DbtrAcct
		$xml->startElement($txClnt . 'Acct');
		$xml->startElement('Id');
		$xml->writeElement('IBAN', $transaction->getIban());
		$xml->endElement(); // Id
		$xml->endElement(); // CdtrAcct/DbtrAcct
		if ($ultimateName = $transaction->getUltimateName()) // Ultimate Debtor or Creditor
		{
			$xml->startElement('Ultmt' . $txClnt);
			$xml->writeElement('Nm', $this->formatString($ultimateName, 70));
			$xml->endElement(); // UltmtCdtr/UltmtDbtr
		}
		if ($purpose = $transaction->getPurpose()) // Purpose Code
		{
			$xml->startElement('Purp');
			$xml->writeElement('Cd', $purpose);
			$xml->endElement(); // Purp
		}
		if ($reference = $transaction->getReference())
		{
			$xml->startElement('RmtInf');
			$xml->writeElement('Ustrd', $this->formatString($reference, 140));
			$xml->endElement(); // RmtInf
		}
		$xml->endElement(); // Transaction
	}
	
	/**
	 * Convert string into epc conform
	 * 
	 * @param string $string
	 * @param int $maxlen
	 * @return string
	 */
	private function formatString(string $string, int $maxlen = 0) : string
	{
		// EPC 2009 allowed:
		// [A-Za-z0-9\+\?\/\-:\(\)\.,' ]
		$map = [
			'Ä' => 'Ae', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Å' => 'A', 'Ă' => 'A', 'Æ' => 'A',
			'Þ' => 'B', 'Ç' => 'C', 'Ĉ' => 'C', 'Ð' => 'Dj',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ĕ' => 'E',
			'Ġ' => 'G', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			'Ñ' => 'N', 'Ń' => 'N',
			'Ö' => 'Oe', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ø' => 'O',
			'Ŝ' => 'S', 'Š' => 'S', 'Ș' => 'S', 'Ț' => 'T',
			'Ü' => 'Ue', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ý' => 'Y',
			'ä' => 'ae', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'å' => 'a', 'ă' => 'a', 'æ' => 'a',
			'þ' => 'b', 'ç' => 'c', 'ĉ' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ĕ' => 'e', 'ƒ' => 'f',
			'ġ' => 'g', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'ñ' => 'n', 'ń' => 'n', 'ö' => 'oe', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ø' => 'o', 'ð' => 'o',
			'ŝ' => 's', 'ș' => 's', 'š' => 's', 'ț' => 't',
			'ü' => 'ue', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ÿ' => 'y',
			'Ž' => 'Z', 'ž' => 'z', 'ß' => 'ss',
		];
		
		$string = preg_replace("/[^A-Za-z0-9\+\?\/\-:\(\)\.,' ]/", ' ', strtr($string, $map));
		if ($maxlen > 0) // max length given, cut string
		{
			$string = substr($string, 0, $maxlen);
		}
		return $string;
	}
	
	/**
	 * Format amount
	 * 
	 * @param int $amount
	 * @return string
	 */
	private function formatAmount(int $amount) : string
	{
		return sprintf("%d.%02d", ($amount / 100), ($amount % 100));
	}
}