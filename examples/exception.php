<?php
require __DIR__ . '/../vendor/autoload.php';

try
{
	$validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
	$sepa = new \ufozone\phpsepa\Sepa\CreditTransfer($validatorFactory);
	$payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
	$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
}
catch (\ufozone\phpsepa\Sepa\Payment\Exception $e)
{
	// Payment-Fehler
}
catch (\ufozone\phpsepa\Sepa\Transaction\Exception $e)
{
	// Transaction-Fehler
}
catch (\ufozone\phpsepa\Sepa\Exception $e)
{
	// Sonstiger Fehler
}
