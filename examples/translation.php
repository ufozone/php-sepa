<?php
/**
 * Example: localized SEPA exception messages.
 *
 * @author  MichaelP08
 * @since   2026-05-11
 */
require __DIR__ . '/../vendor/autoload.php';

use \ufozone\phpsepa\Sepa\Exception as SepaException;

// Without translations: getMessage() returns the English default.
try
{
    $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
    $payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
    $payment->setAccountIban('XX');
}
catch (SepaException $e)
{
    echo 'Code:    ' . $e->getCode() . PHP_EOL;
    echo 'Message: ' . $e->getMessage() . PHP_EOL;          // "Debtor or Creditor IBAN (XX) invalid"
    echo 'Locale:  ' . $e->getLocalizedMessage() . PHP_EOL; // identical, no translations set
    echo 'Context: ' . json_encode($e->getContext()) . PHP_EOL;
    echo PHP_EOL;
}

// Register translations once — afterwards every Sepa\Exception (and subclass)
// can render a localized message via getLocalizedMessage(). getMessage() stays
// English so logs and stack traces remain stable.
//
// setTranslations() accepts two input forms:
//   SepaException::setTranslations('de_DE');                              // bundled locale
//   SepaException::setTranslations(__DIR__ . '/../src/lang/de_DE.php');   // explicit file path
//
// Use SepaException::clearTranslations() to reset.
SepaException::setTranslations('de_DE');

try
{
    $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
    $payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
    $payment->setAccountIban('XX');
}
catch (SepaException $e)
{
    error_log($e->getMessage());                            // log in English
    echo 'Message: ' . $e->getMessage() . PHP_EOL;           // "Debtor or Creditor IBAN (XX) invalid"
    echo 'Locale:  ' . $e->getLocalizedMessage() . PHP_EOL;  // "IBAN des Auftraggebers (XX) ungültig"
}
