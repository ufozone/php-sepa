<?php
require __DIR__ . '/../src/autoload_legacy.php';
require __DIR__ . '/bootstrap.php';

try
{
    $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
    
    $sepa = new \ufozone\phpsepa\Sepa\DirectDebit($validatorFactory);
    $sepa->setInitiator('Max Mustermann');                  // Einreicher
    //$sepa->setId($msgId);                                   // Nachrichtenreferenz
    
    $payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
    //$payment->setScope('CORE');                             // Lastschriftart (CORE oder B2B)
    $payment->setAccountName('Max Mustermann');             // Auftraggaber
    $payment->setAccountIban('DE02370501980001802057');     // Auftraggaber IBAN
    $payment->setAccountBic('COLSDE33');                    // Auftraggaber BIC
    //$payment->setAccountCurrency($currency);                // Kontowaehrung
    $payment->setCreditorId('DE98ZZZ09999999999');          // Glaeubigeridentifikationsnummer
    //$payment->disableBatchBooking();                        // deaktiviere Sammelbuchung
    //$payment->setDate($date);                               // Gewuenschter Ausfuehrungstermin

    $transactionPostalAddress = new \ufozone\phpsepa\Sepa\PostalAddress($validatorFactory);
    $transactionPostalAddress->setStreetName('Musterstraße 12a')
        ->setPostBox('12345')
        ->setTownName('Musterstadt')
        ->setPostCode('12345')
        ->setCountry('DE');
    
    $transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
    $transaction->setEndToEndId('R2017742-1')               // Transaktions-ID (End-to-End)
        ->setName('Karl Kümmel')                            // Name des Zahlungspflichtigen
        ->setPostalAddress($transactionPostalAddress)       // Adresse des Zahlungspflichtigen
        ->setIban('DE02300209000106531065')                 // IBAN des Zahlungspflichtigen
        ->setBic('CMCIDEDD')                                // BIC des Zahlungspflichtigen
        ->setAmount(123.45)                                 // abzubuchender Betrag
        ->setPurpose('SALA')                                // (optional) Zahlungstyp
        ->setMandateId('M20170704-200')                     // Mandatsreferenz
        ->setMandateDate('2017-07-04')                      // Mandatsdatum
        ->setReference('Rechnung R2017742 vom 17.06.2017'); // Verwendungszweck (eine Zeile, max. 140 Zeichen))
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
