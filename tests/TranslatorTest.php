<?php

use \ufozone\phpsepa\Sepa\Exception as SepaException;
use \ufozone\phpsepa\Sepa\Payment\Exception as PaymentException;
use \ufozone\phpsepa\Sepa\Transaction\Exception as TransactionException;

/**
 * Tests for the optional exception translation layer.
 * Translations are global state on Sepa\Exception, so each test resets them.
 *
 * @author  MichaelP08
 * @since   2026-05-11
 */
class TranslatorTest extends PHPUnit\Framework\TestCase
{
    protected function setUp() : void
    {
        SepaException::clearTranslations();
    }

    protected function tearDown() : void
    {
        SepaException::clearTranslations();
    }

    public function testGetMessageStaysEnglishWithoutTranslations()
    {
        $e = new TransactionException('IBAN ({iban}) invalid', TransactionException::IBAN_INVALID, null, ['iban' => 'XX']);

        $this->assertSame('IBAN (XX) invalid', $e->getMessage());
        $this->assertSame('IBAN (XX) invalid', $e->getLocalizedMessage());
        $this->assertSame(['iban' => 'XX'], $e->getContext());
    }

    public function testSetTranslationsAcceptsBundledLocaleCode()
    {
        SepaException::setTranslations('de_DE');

        $e = new TransactionException('IBAN ({iban}) invalid', TransactionException::IBAN_INVALID, null, ['iban' => 'XX']);

        // English message is untouched — important for logs and stack traces.
        $this->assertSame('IBAN (XX) invalid', $e->getMessage());
        // Localized message comes from the map, with the same placeholder filled in.
        $this->assertSame('IBAN (XX) ungültig', $e->getLocalizedMessage());
    }

    public function testSetTranslationsAcceptsFilePath()
    {
        SepaException::setTranslations(__DIR__ . '/../src/lang/de_DE.php');

        $e = new TransactionException('IBAN ({iban}) invalid', TransactionException::IBAN_INVALID, null, ['iban' => 'XX']);

        $this->assertSame('IBAN (XX) ungültig', $e->getLocalizedMessage());
    }

    public function testTranslationsSharedAcrossSubclasses()
    {
        SepaException::setTranslations('de_DE');

        $sepaException        = new SepaException('Initiator empty', SepaException::INITIATOR_EMPTY);
        $paymentException     = new PaymentException('Sequence ({sequence}) invalid', PaymentException::SEQUENCE_INVALID, null, ['sequence' => 'XYZ']);
        $transactionException = new TransactionException('Amount ({amount}) invalid', TransactionException::AMOUNT_INVALID, null, ['amount' => -1.0]);

        $this->assertSame('Einreicher leer', $sepaException->getLocalizedMessage());
        $this->assertSame('Sequenztyp (XYZ) ungültig', $paymentException->getLocalizedMessage());
        $this->assertSame('Betrag (-1) ungültig', $transactionException->getLocalizedMessage());
    }

    public function testThrowFromValidationFlowCarriesContext()
    {
        SepaException::setTranslations('de_DE');

        $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
        $payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);

        try
        {
            $payment->setAccountIban('XX');
            $this->fail('Expected PaymentException was not thrown');
        }
        catch (PaymentException $e)
        {
            $this->assertSame(PaymentException::ACCOUNT_IBAN_INVALID, $e->getCode());
            $this->assertSame(['iban' => 'XX'], $e->getContext());
            $this->assertSame('Debtor or Creditor IBAN (XX) invalid', $e->getMessage());
            $this->assertSame('IBAN des Auftraggebers (XX) ungültig', $e->getLocalizedMessage());
        }
    }

    public function testClearTranslationsRestoresEnglishFallback()
    {
        SepaException::setTranslations('de_DE');
        SepaException::clearTranslations();

        $e = new TransactionException('IBAN ({iban}) invalid', TransactionException::IBAN_INVALID, null, ['iban' => 'XX']);

        $this->assertSame([], SepaException::getTranslations());
        $this->assertSame('IBAN (XX) invalid', $e->getLocalizedMessage());
    }

    public function testSetTranslationsThrowsOnUnknownLocale()
    {
        // 'xx_XX' is syntactically a valid locale code, just no bundled file.
        $this->expectException(\InvalidArgumentException::class);
        SepaException::setTranslations('xx_XX');
    }

    public function testSetTranslationsThrowsOnMissingFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        SepaException::setTranslations(__DIR__ . '/does-not-exist.php');
    }

    /**
     * Locale-mode input must be a strict locale code — anything else is
     * rejected before we touch the filesystem, so path-traversal style
     * inputs cannot reach require().
     */
    public function testSetTranslationsRejectsMalformedLocale()
    {
        $this->expectException(\InvalidArgumentException::class);
        SepaException::setTranslations('not a locale');
    }

    public function testSetTranslationsRejectsLocaleWithDigits()
    {
        $this->expectException(\InvalidArgumentException::class);
        SepaException::setTranslations('de_1');
    }
}
