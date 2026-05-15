<?php
/**
 * German translations for SEPA exception codes.
 *
 * Usage:
 *   \ufozone\phpsepa\Sepa\Exception::setTranslations(require __DIR__ . '/path/to/de.php');
 *
 * Templates use {placeholder} tokens that are filled from the exception's context
 * by Sepa\Exception::getLocalizedMessage(). Copy this file and translate the
 * values to add another language.
 *
 * @author  MichaelP08
 * @since   2026-05-11
 */

use \ufozone\phpsepa\Sepa\Exception as SepaException;
use \ufozone\phpsepa\Sepa\Payment\Exception as PaymentException;
use \ufozone\phpsepa\Sepa\Transaction\Exception as TransactionException;
use \ufozone\phpsepa\Sepa\PostalAddress\Exception as PostalAddressException;
use \ufozone\phpsepa\Sepa\Validator\Exception as ValidatorException;
use \ufozone\phpsepa\Sepa\Xml\Exception as XmlException;

return [
    // Sepa\Exception (1xxx)
    SepaException::MESSAGE_ID_EMTPY                        => 'Nachrichtenreferenz leer',
    SepaException::MESSAGE_ID_INVALID                      => 'Nachrichtenreferenz ungültig ({id})',
    SepaException::INITIATOR_MISSING                       => 'Einreicher fehlt',
    SepaException::INITIATOR_EMPTY                         => 'Einreicher leer',
    SepaException::NO_TRANSACTIONS_PROVIDED                => 'Keine Transaktionen vorhanden',

    // Sepa\Payment\Exception (2xxx)
    PaymentException::PAYMENT_INFORMATION_ID_EMPTY         => 'Payment Information Identifier leer',
    PaymentException::PAYMENT_INFORMATION_ID_INVALID       => 'Payment Information Identifier ungültig ({id})',
    PaymentException::DATE_EMPTY                           => 'Datum leer',
    PaymentException::DATE_INVALID                         => 'Datum ({date}) ungültig, erwartet wird YYYY-MM-DD',
    PaymentException::DATE_PAST                            => 'Ausführungsdatum ({date}) in der Vergangenheit, erwartet wird heute oder in der Zukunft',
    PaymentException::ACCOUNT_NAME_MISSING                 => 'Name des Auftraggebers fehlt',
    PaymentException::ACCOUNT_NAME_EMPTY                   => 'Name des Auftraggebers leer',
    PaymentException::ACCOUNT_IBAN_MISSING                 => 'IBAN des Auftraggebers fehlt',
    PaymentException::ACCOUNT_IBAN_EMPTY                   => 'IBAN des Auftraggebers leer',
    PaymentException::ACCOUNT_IBAN_INVALID                 => 'IBAN des Auftraggebers ({iban}) ungültig',
    PaymentException::ACCOUNT_BIC_EMPTY                    => 'BIC des Auftraggebers leer',
    PaymentException::ACCOUNT_BIC_INVALID                  => 'BIC des Auftraggebers ({bic}) ungültig',
    PaymentException::ACCOUNT_CURRENCY_EMPTY               => 'Kontowährung des Auftraggebers leer',
    PaymentException::ACCOUNT_CURRENCY_INVALID             => 'Kontowährung des Auftraggebers ({currency}) ungültig',
    PaymentException::PRIORITY_EMPTY                       => 'Priorität leer',
    PaymentException::PRIORITY_INVALID                     => 'Priorität ({priority}) ungültig, erwartet wird NORM oder HIGH',
    PaymentException::SCOPE_EMPTY                          => 'Lastschriftart leer',
    PaymentException::SCOPE_INVALID                        => 'Lastschriftart ({scope}) ungültig',
    PaymentException::SEQUENCE_EMPTY                       => 'Sequenztyp leer',
    PaymentException::SEQUENCE_INVALID                     => 'Sequenztyp ({sequence}) ungültig',
    PaymentException::CREDITOR_ID_MISSING                  => 'Gläubigeridentifikationsnummer fehlt',
    PaymentException::CREDITOR_ID_EMPTY                    => 'Gläubigeridentifikationsnummer leer',
    PaymentException::CREDITOR_ID_INVALID                  => 'Gläubigeridentifikationsnummer ({creditorId}) ungültig',

    // Sepa\Transaction\Exception (3xxx)
    TransactionException::INSTRUCTION_ID_EMPTY             => 'Instruction Identifier leer',
    TransactionException::INSTRUCTION_ID_INVALID           => 'Instruction Identifier ({id}) ungültig',
    TransactionException::END2END_ID_EMPTY                 => 'End-to-End Identifier leer',
    TransactionException::END2END_ID_INVALID               => 'End-to-End Identifier ({endToEndId}) ungültig',
    TransactionException::NAME_MISSING                     => 'Name fehlt',
    TransactionException::NAME_EMPTY                       => 'Name leer',
    TransactionException::IBAN_MISSING                     => 'IBAN fehlt',
    TransactionException::IBAN_EMPTY                       => 'IBAN leer',
    TransactionException::IBAN_INVALID                     => 'IBAN ({iban}) ungültig',
    TransactionException::BIC_EMPTY                        => 'BIC leer',
    TransactionException::BIC_INVALID                      => 'BIC ({bic}) ungültig',
    TransactionException::AMOUNT_MISSING                   => 'Betrag fehlt',
    TransactionException::AMOUNT_INVALID                   => 'Betrag ({amount}) ungültig',
    TransactionException::CURRENCT_EMPTY                   => 'Währung leer',
    TransactionException::CURRENCY_INVALID                 => 'Währung ({currency}) ungültig',
    TransactionException::PURPOSE_CODE_EMPTY               => 'Zahlungstyp leer',
    TransactionException::PURPOSE_CODE_INVALID             => 'Zahlungstyp ({purpose}) ungültig',
    TransactionException::MANDATE_ID_MISSING               => 'Mandatsreferenz fehlt',
    TransactionException::MANDATE_ID_EMPTY                 => 'Mandatsreferenz leer',
    TransactionException::MANDATE_ID_INVALID               => 'Mandatsreferenz ({mandateId}) ungültig',
    TransactionException::MANDATE_DATE_MISSING             => 'Datum der Mandatserteilung fehlt',
    TransactionException::MANDATE_DATE_EMPTY               => 'Datum der Mandatserteilung leer',
    TransactionException::MANDATE_DATE_INVALID             => 'Datum der Mandatserteilung ({mandateDate}) ungültig',
    TransactionException::ORIGINAL_MANDATE_ID_EMPTY        => 'Ursprüngliche Mandatsreferenz leer',
    TransactionException::ORIGINAL_MANDATE_ID_INVALID      => 'Ursprüngliche Mandatsreferenz ({originalMandateId}) ungültig',
    TransactionException::ORIGINAL_MANDATE_IBAN_EMPTY      => 'Ursprüngliche Mandats-IBAN leer',
    TransactionException::ORIGINAL_MANDATE_IBAN_INVALID    => 'Ursprüngliche Mandats-IBAN ({originalMandateIban}) ungültig',
    TransactionException::ORIGINAL_MANDATE_BIC_EMPTY       => 'Ursprüngliche Mandats-BIC leer',
    TransactionException::ORIGINAL_MANDATE_BIC_INVALID     => 'Ursprüngliche Mandats-BIC ({originalMandateBic}) ungültig',

    // Sepa\Validator\Exception (4000)
    ValidatorException::NO_VALID_VALIDATOR                 => 'Unbekannter Validator-Typ: {type}',

    // Sepa\PostalAddress\Exception (4xxx)
    PostalAddressException::TOWN_NAME_MISSING              => 'Stadt fehlt',
    PostalAddressException::TOWN_NAME_EMPTY                => 'Stadt leer',
    PostalAddressException::COUNTRY_MISSING                => 'Land fehlt',
    PostalAddressException::COUNTRY_EMPTY                  => 'Land leer',
    PostalAddressException::COUNTRY_INVALID                => 'Land ({country}) ungültig',
    PostalAddressException::ADDRESS_LINES_EXCEED_MAXIMUM   => 'Maximale Anzahl von 2 Adresszeilen überschritten',

    // Sepa\Xml\Exception (5xxx)
    XmlException::CANNOT_OPEN_TMP_FILE                     => 'Temporäre Datei kann nicht geöffnet werden',
    XmlException::CANNOT_CREATE_XML                        => 'XML kann nicht erzeugt werden',
    XmlException::SCHEMA_FILE_NOT_FOUND                    => 'Schema-Datei {file}.xsd nicht gefunden',
];
