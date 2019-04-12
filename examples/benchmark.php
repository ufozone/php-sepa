<?php
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/../src/autoload.php';

$transactions = 100000;
$filename = '/tmp/sepa.xml';
#$filename = false; // XML als String zurueckgeben

try
{
	$startTime = microtime(true);
	
	$validatorFactory = new \MG\Sepa\Validator\Factory();
	
	$sepa = new \MG\Sepa\CreditTransfer($validatorFactory);
	$sepa->setInitiator('Markus Görnhardt');
	
	$payment = new \MG\Sepa\Payment($validatorFactory);
	$payment->setAccount('Markus Görnhardt', 'DE89840500001565003795', 'HELADEF1RRS');
	
	for ($i = 0; $i < $transactions; $i++)
	{
		$transaction = new \MG\Sepa\Transaction($validatorFactory);
		$transaction->setEndToEndId('R2017742-1')
			->setName('Karl Kümmel')
			->setIban('DE87200500001234567890')
			->setBic('BANKDEZZXXX')
			->setAmount(123.45)
			->setReference('Rechnung R2017742 vom 17.06.2017');
		
		$payment->addTransaction($transaction);
	}
	$sepa->addPayment($payment);
	
	$xml = new \MG\Sepa\Xml($sepa);
	
	if ($filename)
	{
		$xml->save($filename);
	}
	else
	{
		$output = $xml->get();
	}
	$endTime = microtime(true);
	if ($filename)
	{
		$size = filesize($filename);
	}
	else
	{
		$size = strlen($output);
	}
	$memoryPeak = memory_get_peak_usage();
	$duration = $endTime - $startTime;

	print "<pre>";
	print "Transactions: ";
	print $transactions;
	print PHP_EOL;
	
	print "Size: ";
	print formatFilesize($size);
	print PHP_EOL;
	
	print "Runtime: ";
	print round($duration, 4);
	print " sec";
	print PHP_EOL;
	
	print "Average: ";
	print round(($transactions / $duration), 4);
	print " transactions/sec";
	print PHP_EOL;
	
	print "Memory: ";
	print formatFilesize($memoryPeak);
	print PHP_EOL;
	
	@unlink($filename);
}
catch (\MG\Exception $e)
{
	print_r($e);
	exit;
}
