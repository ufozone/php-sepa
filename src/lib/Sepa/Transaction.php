<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa\Transaction\Exception as TransactionException;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Transaction Class
 * 
 * @author Markus
 * @since      2017-06-08
 */
class Transaction
{
	/**
	 * Instruction Identifier
	 * @var string
	 */
	private $id = '';
	
	/**
	 * End-to-End Identifier
	 * @var string
	 */
	private $endToEndId = '';
	
	/**
	 * Debtor/Creditor Name
	 * @var string
	 */
	private $name = '';
	
	/**
	 * IBAN
	 * @var string
	 */
	private $iban = '';
	
	/**
	 * BIC
	 * @var string
	 */
	private $bic = '';
	
	/**
	 * Amount
	 * @var integer
	 */
	private $amount = 0;
	
	/**
	 * Currency
	 * @var string
	 */
	private $currency = 'EUR';
	
	/**
	 * Ultimate Debtor or Creditor
	 * @var string
	 */
	private $ultimateName = '';
	
	/**
	 * Purpose Code
	 * @var string
	 */
	private $purpose = '';
	
	/**
	 * Unstructured Reference Text
	 * @var string
	 */
	private $reference = '';
	
	/**
	 * Mandate Identifier
	 * @var string
	 */
	private $mandateId = '';
	
	/**
	 * Mandate Date
	 * @var string
	 */
	private $mandateDate = '';
	
	/**
	 * Mandate Changed
	 * @var bool
	 */
	private $mandateChanged = false;
	
	/**
	 * Original Mandate ID
	 * @var string
	 */
	private $originalMandateId = '';
	
	/**
	 * Original Mandate IBAN
	 * @var string
	 */
	private $originalMandateIban = '';
	
	/**
	 * Original Mandate BIC
	 * @var string
	 */
	private $originalMandateBic = '';
	
	/**
	 * @var ValidatorFactory
	 */
	private $validatorFactory;
	
	/**
	 * Constructor
	 * 
	 * @param ValidatorFactory $validatorFactory
	 */
	public function __construct(ValidatorFactory $validatorFactory)
	{
		$this->validatorFactory = $validatorFactory;
	}
	
	/**
	 * Set instruction identifier
	 * 
	 * @param string $id
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setId(string $id) : Transaction
	{
		if (!$id = trim($id))
		{
			throw new TransactionException('Instruction Identifier empty', TransactionException::INSTRUCTION_ID_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Id1")->isValid($id))
		{
			throw new TransactionException('Instruction Identifier (' . $id . ') invalid', TransactionException::INSTRUCTION_ID_INVALID);
		}
		$this->id = $id;
		
		return $this;
	}
	
	/**
	 * Get instruction identifier
	 * 
	 * @return string
	 */
	public function getId() : string
	{
		return $this->id;
	}
	
	/**
	 * Set end-to-end identifier
	 * 
	 * @param string $endToEndId
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setEndToEndId(string $endToEndId) : Transaction
	{
		if (!$endToEndId = trim($endToEndId))
		{
			throw new TransactionException('End-to-End Identifier empty', TransactionException::END2END_ID_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Id1")->isValid($endToEndId))
		{
			throw new TransactionException('End-to-End Identifier (' . $endToEndId . ') invalid', TransactionException::END2END_ID_INVALID);
		}
		$this->endToEndId = $endToEndId;
		
		return $this;
	}
	
	/**
	 * Get end-to-end identifier
	 * 
	 * @return string
	 */
	public function getEndToEndId() : string
	{
		return $this->endToEndId;
	}
	
	/**
	 * Set debtor/creditor name
	 * 
	 * @param string $name
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setName(string $name) : Transaction
	{
		if (!$name = trim($name))
		{
			throw new TransactionException('Name empty', TransactionException::NAME_EMPTY);
		}
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * Get debtor/creditor name
	 * 
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}
	
	/**
	 * Set IBAN
	 * 
	 * @param string $iban
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setIban(string $iban) : Transaction
	{
		if (!$iban = trim($iban))
		{
			throw new TransactionException('IBAN empty', TransactionException::IBAN_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Iban")->isValid($iban))
		{
			throw new TransactionException('IBAN (' . $iban . ') invalid', TransactionException::IBAN_INVALID);
		}
		$this->iban = $iban;
		
		return $this;
	}
	
	/**
	 * Get IBAN
	 * 
	 * @return string
	 */
	public function getIban() : string
	{
		return $this->iban;
	}
	
	/**
	 * Set BIC
	 * 
	 * @param string $bic
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setBic(string $bic) : Transaction
	{
		if (!$bic = trim($bic))
		{
			throw new TransactionException('BIC empty', TransactionException::BIC_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Bic")->isValid($bic))
		{
			throw new TransactionException('BIC (' . $bic . ') invalid', TransactionException::BIC_INVALID);
		}
		$this->bic = str_pad($bic, 11, 'X');
		
		return $this;
	}
	
	/**
	 * Get BIC
	 * 
	 * @return string
	 */
	public function getBic() : string
	{
		return $this->bic;
	}
	
	/**
	 * Set amount
	 * 
	 * @param float $amount
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setAmount(float $amount) : Transaction
	{
		if (!$this->validatorFactory->getValidator("Amount")->isValid($amount))
		{
			throw new TransactionException('Amount (' . $amount . ') invalid', TransactionException::AMOUNT_INVALID);
		}
		$this->amount = round($amount * 100); // get amount as cents
		
		return $this;
	}
	
	/**
	 * Get amount
	 * 
	 * @return int
	 */
	public function getAmount() : int
	{
		return (int) $this->amount;
	}
	
	/**
	 * Set currency
	 * 
	 * @param string $currency
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setCurrency(string $currency) : Transaction
	{
		$currency = strtoupper($currency);
		if (!$currency = trim($currency))
		{
			throw new TransactionException('Currency empty', TransactionException::CURRENCT_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Currency")->isValid($currency))
		{
			throw new TransactionException('Currency (' . $currency . ') invalid', TransactionException::CURRENCY_INVALID);
		}
		$this->currency = $currency;
		
		return $this;
	}
	
	/**
	 * Get currency
	 * 
	 * @return string
	 */
	public function getCurrency() : string
	{
		return $this->currency;
	}
	
	/**
	 * Set ultimate debtor or creditor
	 * 
	 * @param string $ultimateName
	 * @return Transaction
	 */
	public function setUltimateName(string $ultimateName) : Transaction
	{
		$this->ultimateName = trim($ultimateName);
		
		return $this;
	}
	
	/**
	 * Get ultimate debtor or creditor
	 * 
	 * @return string
	 */
	public function getUltimateName() : string
	{
		return $this->ultimateName;
	}
	
	/**
	 * Set purpose code
	 * 
	 * @param string $purpose
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setPurpose(string $purpose) : Transaction
	{
		$purpose = strtoupper($purpose);
		if (!$purpose = trim($purpose))
		{
			throw new TransactionException('Purpose empty', TransactionException::PURPOSE_CODE_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Purpose")->isValid($purpose))
		{
			throw new TransactionException('Purpose Code (' . $purpose . ') invalid', TransactionException::PURPOSE_CODE_INVALID);
		}
		$this->purpose = $purpose;
		
		return $this;
	}
	
	/**
	 * Get purpose code
	 * 
	 * @return string
	 */
	public function getPurpose() : string
	{
		return $this->purpose;
	}
	
	/**
	 * Set unstructured reference text
	 * 
	 * @param string $reference
	 * @return Transaction
	 */
	public function setReference(string $reference) : Transaction
	{
		$this->reference = trim($reference);
		
		return $this;
	}
	
	/**
	 * Get unstructured reference text
	 * 
	 * @return string
	 */
	public function getReference() : string
	{
		return $this->reference;
	}
	
	/**
	 * Set mandate identifier
	 * 
	 * @param string $mandateId
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setMandateId(string $mandateId) : Transaction
	{
		if (!$mandateId = trim($mandateId))
		{
			throw new TransactionException('Mandate Identifier empty', TransactionException::MANDATE_ID_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Id2")->isValid($mandateId))
		{
			throw new TransactionException('Mandate Identifier (' . $mandateId . ') invalid', TransactionException::MANDATE_ID_INVALID);
		}
		$this->mandateId = $mandateId;
		
		return $this;
	}
	
	/**
	 * Get mandate identifier
	 * 
	 * @return string
	 */
	public function getMandateId() : string
	{
		return $this->mandateId;
	}
	
	/**
	 * Set mandate date
	 * 
	 * @param string $mandateDate
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setMandateDate(string $mandateDate) : Transaction
	{
		if (!$mandateDate = trim($mandateDate))
		{
			throw new TransactionException('Date of Signature empty', TransactionException::MANDATE_DATE_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Date")->isValid($mandateDate))
		{
			throw new TransactionException('Date of Signature (' . $mandateDate . ') invalid', TransactionException::MANDATE_DATE_INVALID);
		}
		$this->mandateDate = $mandateDate;
		
		return $this;
	}
	
	/**
	 * Get mandate date
	 * 
	 * @return string
	 */
	public function getMandateDate() : string
	{
		return $this->mandateDate;
	}
	
	/**
	 * Set mandate changed
	 * 
	 * @return Transaction
	 */
	public function setMandateChanged() : Transaction
	{
		$this->mandateChanged = true;
		
		return $this;
	}
	
	/**
	 * Get mandate changed
	 * 
	 * @return bool
	 */
	public function hasMandateChanged() : bool
	{
		return ($this->mandateChanged !== false);
	}
	
	/**
	 * Set original mandate identifier
	 * 
	 * @param string $originalMandateId
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setOriginalMandateId(string $originalMandateId) : Transaction
	{
		if (!$originalMandateId = trim($originalMandateId))
		{
			throw new TransactionException('Original Mandate Identifier empty', TransactionException::ORIGINAL_MANDATE_ID_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Id2")->isValid($originalMandateId))
		{
			throw new TransactionException('Original Mandate Identifier (' . $originalMandateId . ') invalid', TransactionException::ORIGINAL_MANDATE_ID_INVALID);
		}
		$this->originalMandateId = $originalMandateId;
		
		return $this;
	}
	
	/**
	 * Get original mandate identifier
	 * 
	 * @return string
	 */
	public function getOriginalMandateId() : string
	{
		return $this->originalMandateId;
	}
	
	/**
	 * Set original mandate IBAN
	 * 
	 * @param string $originalMandateIban
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setOriginalMandateIban(string $originalMandateIban) : Transaction
	{
		if (!$originalMandateIban = trim($originalMandateIban))
		{
			throw new TransactionException('Original Mandate IBAN empty', TransactionException::ORIGINAL_MANDATE_IBAN_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Iban")->isValid($originalMandateIban))
		{
			throw new TransactionException('Original Mandate IBAN (' . $originalMandateIban . ') invalid', TransactionException::ORIGINAL_MANDATE_IBAN_INVALID);
		}
		$this->originalMandateIban = $originalMandateIban;
		
		return $this;
	}
	
	/**
	 * Get original mandate IBAN
	 * 
	 * @return string
	 */
	public function getOriginalMandateIban() : string
	{
		return $this->originalMandateIban;
	}
	
	/**
	 * Set original mandate BIC
	 * 
	 * @param string $originalMandateBic
	 * @throws TransactionException
	 * @return Transaction
	 */
	public function setOriginalMandateBic(string $originalMandateBic) : Transaction
	{
		if (!$originalMandateBic = trim($originalMandateBic))
		{
			throw new TransactionException('Original Mandate BIC empty', TransactionException::ORIGINAL_MANDATE_BIC_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Bic")->isValid($originalMandateBic))
		{
			throw new TransactionException('Original Mandate BIC (' . $originalMandateBic . ') invalid', TransactionException::ORIGINAL_MANDATE_BIC_INVALID);
		}
		$this->originalMandateBic = $originalMandateBic;
		
		return $this;
	}
	
	/**
	 * Get original mandate BIC
	 * 
	 * @return string
	 */
	public function getOriginalMandateBic() : string
	{
		return $this->originalMandateBic;
	}
	
	/**
	 * Check necessary transaction data
	 * 
	 * @param bool $isDirectDebit
	 * @throws TransactionException
	 * @return bool
	 */
	public function validate(bool $isDirectDebit) : bool
	{
		if ($this->name === '')
		{
			throw new TransactionException('Name missing', TransactionException::NAME_MISSING);
		}
		if ($this->iban === '')
		{
			throw new TransactionException('IBAN missing', TransactionException::IBAN_MISSING);
		}
		if ($this->amount === 0)
		{
			throw new TransactionException('Amount missing', TransactionException::AMOUNT_MISSING);
		}
		if ($isDirectDebit)
		{
			if ($this->mandateId === '')
			{
				throw new TransactionException('Mandate Identifier missing', TransactionException::MANDATE_ID_MISSING);
			}
			if ($this->mandateDate === '')
			{
				throw new TransactionException('Date of Signature missing', TransactionException::MANDATE_DATE_MISSING);
			}
		}
		return true;
	}
}