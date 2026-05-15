<?php
require __DIR__ . '/../src/autoload_legacy.php';
require __DIR__ . '/bootstrap.php';

try
{
    $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
    $executionDate = new \DateTimeImmutable('+2 day');

    $sepa = new \ufozone\phpsepa\Sepa\CreditTransfer($validatorFactory);
    $sepa->setInitiator('Max Mustermann');                   // Einreicher
    $sepa->setId('MSG-20240224-1');                          // Nachrichtenreferenz

    $payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
    //$payment->setPriority('HIGH');                           // Prioritaet: NORM oder HIGH
    $payment->setAccountName('Max Mustermann');              // Auftraggeber (Debitor)
    $payment->setAccountIban('DE02370502990000684712');      // Auftraggeber IBAN
    $payment->setAccountBic('COKSDE33');                     // Auftraggeber BIC
    //$payment->setAccountCurrency('EUR');                     // Kontowaehrung
    //$payment->disableBatchBooking();                         // Sammelbuchung deaktivieren
    $payment->setExecutionDate($executionDate);              // Gewuenschter Ausfuehrungstermin

    $transactionPostalAddress = new \ufozone\phpsepa\Sepa\PostalAddress($validatorFactory);
    $transactionPostalAddress->setStreetName('Musterstraße 12a')
        ->setPostBox('12345')
        ->setTownName('Musterstadt')
        ->setPostCode('12345')
        ->setCountry('DE');

    $transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
    $transaction->setEndToEndId('R2017742-1')                // Transaktions-ID (eindeutig)
        ->setName('Karl Kümmel')                             // Name des Zahlungsempfaengers (Creditor)
        ->setPostalAddress($transactionPostalAddress)        // Adresse des Zahlungsempfaengers
        ->setIban('DE02300209000106531065')                  // IBAN des Zahlungsempfaengers
        ->setBic('CMCIDEDD')                                 // BIC des Zahlungsempfaengers
        ->setAmount(123.45)                                  // Betrag
        ->setPurpose('SALA')                                 // (optional) Zahlungstyp
        ->setReference('Lohn/Gehalt Januar 2026');           // Verwendungszweck (eine Zeile, max. 140 Zeichen)

    $payment->addTransaction($transaction);

    $transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
    $transaction->setEndToEndId('R2017742-2')
        ->setName('Doris Dose')
        ->setIban('DE02500105170137075030')
        ->setBic('INGDDEFFXXX')
        ->setAmount(234.56)
        ->setReference('Kleinanzeigen Kinderfahrrad');

    $payment->addTransaction($transaction);

    $sepa->addPayment($payment);

    $xml = new \ufozone\phpsepa\Sepa\Xml($sepa);
    if (!$xml->validate())
    {
        print_r($xml->getErrors());
        exit;
    }
    $xml->download();
}
catch (Exception $e)
{
    print_r($e);
    exit;
}
