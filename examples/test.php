<?php
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../src/autoload.php';

try
{
	$validatorFactory = new \MG\Sepa\Validator\Factory();
	
	$sepa = new \MG\Sepa\CreditTransfer($validatorFactory);
	$sepa->setInitiator('Markus Görnhardt');
	$sepa->setId('BA-TEST');
	
	$payment = new \MG\Sepa\Payment($validatorFactory);
	$payment->setAccount('Markus Görnhardt', 'DE19840500001565123880');
	//$payment->disableBatchBooking();
	
	$transaction = new \MG\Sepa\Transaction($validatorFactory);
	$transaction->setEndToEndId('BA-TEST-001')
		->setName('Markus Görnhardt')
		->setIban('DE73500502011243909755')
		->setAmount(1)
		->setReference('Test Bachelorarbeit');
	$payment->addTransaction($transaction);
	
	$transaction = new \MG\Sepa\Transaction($validatorFactory);
	$transaction->setEndToEndId('BA-TEST-002')
		->setName('Stefanie Dierich')
		->setIban('DE43500502011244204690')
		->setAmount(1)
		->setReference('Test Bachelorarbeit');
	$payment->addTransaction($transaction);
	
	$sepa->addPayment($payment);
	
	header("Content-Type: text/xml");
	header("Content-Disposition: attachment; filename=\"sepa.xml\"");
	header("Pragma: no-cache");
	
	$xml = new \MG\Sepa\Xml($sepa);
	echo $xml->get();
}
catch (\MG\Exception $e)
{
	print_r($e);
	exit;
}
