# php-sepa

PHP class to creating SEPA files (XML) for credit transfers and direct debits in accordance with version 3.7 of the specification for remote data transmission between customer and bank according to the DFÜ agreement for the German banking industry.

The versions of the standard followed are:

* _pain.001.001.09_GBIC_4.xsd_  for credit transfers
* _pain.008.001.08_GBIC_4.xsd_  for direct debits

Always verify the generated files at your bank before using them in production!

License: BSD 2-Clause License

## Example of using SEPA Credit Transfer

```php
$validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();

$sepa = new \ufozone\phpsepa\Sepa\CreditTransfer($validatorFactory);
$sepa->setInitiator('Max Mustermann'); // Einreicher
//$sepa->setId($msgId); // Nachrichtenreferenz

$payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
$payment->setPriority('HIGH'); // Prioritaet NORM oder HIGH
//$payment->setScope('INST'); // Echtzeitueberweisung
$payment->setAccount('Max Mustermann', 'DE02370501980001802057', 'COLSDE33'); // Auftraggaber
//$payment->setAccountCurrency($currency); // Kontowaehrung
//$payment->disableBatchBooking(); // deaktiviere Sammelbuchung
//$payment->setDate($date); // Faelligkeitsdatum

$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
$transaction->setEndToEndId('R2017742-1')   // Transaktions-ID (End-to-End)
    ->setName('Karl Kümmel')                // Name des Zahlungspflichtigen
    ->setIban('DE02300209000106531065')     // IBAN des Zahlungspflichtigen
    ->setBic('CMCIDEDD')                    // BIC des Zahlungspflichtigen
    ->setAmount(123.45)                     // abzubuchender Betrag
    ->setPurpose('SALA')                    // (optional) Zahlungstyp
    ->setReference('Rechnung R2017742 vom 17.06.2017'); // Verwendungszweck (eine Zeile, max. 140 Zeichen))
$payment->addTransaction($transaction);

$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
$transaction->setEndToEndId('R2017742-1')
    ->setName('Doris Dose')
    ->setIban('DE02500105170137075030')
    ->setAmount(234.56)
    ->setPurpose('SALA')
    ->setReference('Kinderfahrrad');
$payment->addTransaction($transaction);

$sepa->addPayment($payment);

$xml = new \ufozone\phpsepa\Sepa\Xml($sepa);
$xml->download('sepa.xml');
```

## Example of using SEPA Direct Debit

```php
$validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();

$sepa = new \ufozone\phpsepa\Sepa\DirectDebit($validatorFactory);
$sepa->setInitiator('Max Mustermann'); // Einreicher
//$sepa->setId($msgId); // Nachrichtenreferenz

$payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
//$payment->setScope('CORE'); // Lastschriftart (CORE oder B2B)
$payment->setAccount('Max Mustermann', 'DE02370501980001802057', 'COLSDE33'); // Auftraggaber
//$payment->setAccountCurrency($currency); // Kontowaehrung
$payment->setCreditorId('DE98ZZZ09999999999'); // Glaeubigeridentifikationsnummer
//$payment->disableBatchBooking(); // deaktiviere Sammelbuchung
//$payment->setDate($date); // Gewuenschter Ausfuehrungstermin

$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
$transaction->setEndToEndId('R2017742-1')   // Transaktions-ID (End-to-End)
    ->setName('Karl Kümmel')                // Name des Zahlungspflichtigen
    ->setIban('DE02300209000106531065')     // IBAN des Zahlungspflichtigen
    ->setBic('CMCIDEDD')                    // BIC des Zahlungspflichtigen
    ->setAmount(123.45)                     // abzubuchender Betrag
    ->setPurpose('SALA')                    // (optional) Zahlungstyp
    ->setMandateId('M20170704-200')         // Mandatsreferenz
    ->setMandateDate('2017-07-04')          // Mandatsdatum
    ->setReference('Rechnung R2017742 vom 17.06.2017'); // Verwendungszweck (eine Zeile, max. 140 Zeichen))
$payment->addTransaction($transaction);

$sepa->addPayment($payment);

$xml = new \ufozone\phpsepa\Sepa\Xml($sepa);
$xml->download('sepa.xml');
```

## External Resources

* [German specification for remote data transfer between customer and bank according to the DFÜ agreement "Specification of Data Formats"](https://www.ebics.de/de/datenformate)
* [ECB SEPA gateway page](https://www.ecb.europa.eu/paym/integration/retail/sepa/html/index.en.html)
* [ISO20022 Message Catalog](https://www.iso20022.org/full_catalogue.page)
