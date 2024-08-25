<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Integrationstests
 * @author Markus
 */
class SepaTest extends PHPUnit\Framework\TestCase
{
	public function testSepaObject()
	{
		$exception = false;
		try
		{
			$sepa = $this->getSepaObject();
		}
		catch (\Exception $e)
		{
			$exception = true;
		}
		$this->assertTrue($exception);
	}
	
	public function testValidateXmlFile()
	{
		$sepa = $this->getSepaObject();
		$xml = $this->getSepaXmlObject($sepa);
		
		$this->assertTrue($xml->validate());
	}
	
	public function testValidateXmlFileDom()
	{
		$sepa = $this->getSepaObject();
		$xml = $this->getSepaXmlObject($sepa);
		
		$dom = new \DOMDocument();
		$dom->loadXML($xml->get());
		
		$this->assertTrue($dom->schemaValidate(__DIR__ . '/../vendor/schema/pain.001.001.09.xsd'));
	}
	
	public function testValidateXmlFileXmlReader()
	{
		$sepa = $this->getSepaObject();
		$xml = $this->getSepaXmlObject($sepa);
		
		$xmlReader = new \XMLReader();
		$xmlReader->xml($xml->get());
		$xmlReader->setSchema(__DIR__ . '/../vendor/schema/pain.001.001.09.xsd');
		while ($xmlReader->read());
		
		$this->assertTrue($xmlReader->isValid());
	}
	
	private function getSepaObject($validatorFactoryMock = false)
	{
		if ($validatorFactoryMock)
		{
			$validatorFactory = $this->getValidatorFactoryMock();
		}
		else
		{
			$validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
		}
		$sepa = new \ufozone\phpsepa\Sepa\CreditTransfer($validatorFactory);
		$sepa->setInitiator("Markus Görnhardt");
		
		$payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
		$payment->setAccount("Markus Görnhardt", "DE89840500001565003795", "HELADEF1RRS");
		
		// first transaction
		$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
		$transaction->setName("Karl Kümmel")
			->setIban("DE87200500001234567890")
			->setBic("BANKDEZZXXX")
			->setAmount(123.45)
			->setReference("Rechnung R2017742 vom 17.06.2017");
		$payment->addTransaction($transaction);
		
		// second transaction
		$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
		$transaction->setName("Doris Dose")
			->setIban("DE87200500001234567890")
			->setAmount(234.56)
			->setReference("Kinderfahrrad");
		$payment->addTransaction($transaction);
		
		$sepa->addPayment($payment);
		
		return $sepa;
	}
	
	private function getSepaXmlObject($sepa)
	{
		$xml = new \ufozone\phpsepa\Sepa\Xml($sepa);
		
		return $xml;
	}
	
	private function getValidatorFactoryMock()
	{
		return new class
		{
			public function getValidator(string $type) : \ufozone\phpsepa\Sepa\Validator
			{
				return new \ufozone\phpsepa\Sepa\Validator\Mock();
			}
		};
	}
}