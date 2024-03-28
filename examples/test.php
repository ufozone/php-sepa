<?php
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../vendor/autoload.php';

function libxml_display_error($error)
{
	$return = "<br/>\n";
	switch ($error->level) {
		case LIBXML_ERR_WARNING:
			$return .= "<b>Warning $error->code</b>: ";
			break;
		case LIBXML_ERR_ERROR:
			$return .= "<b>Error $error->code</b>: ";
			break;
		case LIBXML_ERR_FATAL:
			$return .= "<b>Fatal Error $error->code</b>: ";
			break;
	}
	$return .= trim($error->message);
	if ($error->file) {
		$return .=    " in <b>$error->file</b>";
	}
	$return .= " on line <b>$error->line</b>\n";
	
	return $return;
}

function libxml_display_errors() {
	$errors = libxml_get_errors();
	foreach ($errors as $error) {
		print libxml_display_error($error);
	}
	libxml_clear_errors();
}

// Enable user error handling
libxml_use_internal_errors(true);

try
{
	$validatorFactory = new \MG\Sepa\Validator\Factory();
	
	$sepa = new \MG\Sepa\CreditTransfer($validatorFactory);
	$sepa->setInitiator('Max Mustermann'); // Einreicher
	//$sepa->setId($msgId); // Nachrichtenreferenz
	
	$payment = new \MG\Sepa\Payment($validatorFactory);
	$payment->setPriority('HIGH'); // Prioritaet NORM oder HIGH
	$payment->setAccount('Max Mustermann', 'DE02370501980001802057', 'COLSDE33'); // Auftraggaber
	$payment->setScope('INST');
	//$payment->setAccountCurrency($currency); // Kontowaehrung
	//$payment->disableBatchBooking(); // deaktiviere Sammelbuchung
	//$payment->setDate($date); // Faelligkeitsdatum
	
	$transaction = new \MG\Sepa\Transaction($validatorFactory);
	$transaction->setEndToEndId('R2017742-1')	// Transaktions-ID (End-to-End)
		->setName('Karl Kümmel')				// Name des Zahlungspflichtigen
		->setIban('DE02300209000106531065')		// IBAN des Zahlungspflichtigen
		->setBic('CMCIDEDD')					// BIC des Zahlungspflichtigen
		->setAmount(123.45)						// abzubuchender Betrag
		->setPurpose('SALA')					// (optional) Zahlungstyp
		->setReference('Rechnung R2017742 vom 17.06.2017'); // Verwendungszweck (eine Zeile, max. 140 Zeichen))
	$payment->addTransaction($transaction);
	
	$transaction = new \MG\Sepa\Transaction($validatorFactory);
	$transaction->setEndToEndId('R2017742-1')
		->setName('Doris Dose')
		->setIban('DE02500105170137075030')
		->setAmount(234.56)
		->setPurpose('SALA')
		->setReference('Kinderfahrrad');
	$payment->addTransaction($transaction);
	
	$sepa->addPayment($payment);
	
	
	
	$xml = new \MG\Sepa\Xml($sepa);
	var_dump($xml->validate());
	
	
	$dom = new \DOMDocument();
	$dom->loadXML($xml->get());
	var_dump($dom->schemaValidate(__DIR__ . '/../vendor/schema/pain.001.001.09.xsd'));
	
	
	$xmlReader = new \XMLReader();
	$xmlReader->xml($xml->get());
	$xmlReader->setSchema(__DIR__ . '/../vendor/schema/pain.001.001.09.xsd');
	while ($xmlReader->read());
	
	var_dump($xmlReader->isValid());
	
	#libxml_display_errors();
	echo $xml->get();
}
catch (\MG\Exception $e)
{
	print_r($e);
	exit;
}
