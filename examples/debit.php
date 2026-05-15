<?php
require __DIR__ . '/../src/autoload_legacy.php';
require __DIR__ . '/bootstrap.php';

try
{
    $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
    $executionDate = new \DateTimeImmutable('+5 day');

    $sepa = new \ufozone\phpsepa\Sepa\DirectDebit($validatorFactory);
    $sepa->setInitiator('Max Mustermann');                   // Einreicher
    $sepa->setId('MSG-20240224-1');                          // Nachrichtenreferenz

    $payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
    //$payment->setScope('CORE');                              // Lastschriftart (CORE oder B2B)
    $payment->setSequence('OOFF');                           // Sequenztyp (FRST, RCUR, OOFF, FNAL)
    $payment->setAccountName('Max Mustermann');              // Auftraggeber (Creditor)
    $payment->setAccountIban('DE02200505501015871393');      // Auftraggeber IBAN
    $payment->setAccountBic('HASPDEHHXXX');                  // Auftraggeber BIC
    $payment->setCreditorId('DE98ZZZ09999999999');           // Glaeubigeridentifikationsnummer
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
        ->setName('Karl Kümmel')                             // Name des Zahlungspflichtigen (Debitor)
        ->setPostalAddress($transactionPostalAddress)        // Adresse des Zahlungspflichtigen
        ->setIban('DE02700100800030876808')                  // IBAN des Zahlungspflichtigen
        ->setBic('PBNKDEFFXXX')                              // BIC des Zahlungspflichtigen
        ->setAmount(123.45)                                  // Abzubuchender Betrag
        ->setPurpose('SCVE')                                 // (optional) Zahlungstyp
        ->setMandateId('M20170704-200')                      // Mandatsreferenz
        ->setMandateDate('2017-07-04')                       // Datum Mandatserteilung (YYYY-MM-DD)
        ->setReference('Rechnung R2017742 vom 17.06.2017');  // Verwendungszweck (eine Zeile, max. 140 Zeichen)

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
