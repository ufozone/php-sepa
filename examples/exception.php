<?php
require "lib/src/autoload.php";

try
{
	$validatorFactory = new \MG\Sepa\Validator\Factory();
	$sepa = new \MG\Sepa\CreditTransfer($validatorFactory);
	$payment = new \MG\Sepa\Payment($validatorFactory);
	$transaction = new \MG\Sepa\Transaction($validatorFactory);
}
catch (\MG\Sepa\Payment\Exception $e)
{
	// Payment-Fehler
}
catch (\MG\Sepa\Transaction\Exception $e)
{
	// Transaction-Fehler
}
catch (\MG\Exception $e)
{
	// Sonstiger Fehler
}
