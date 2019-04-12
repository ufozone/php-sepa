<?php
require __DIR__ . '/../src/autoload.php';

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
		
		$this->assertTrue($dom->schemaValidate(__DIR__ . '/../src/schema/pain.001.001.03.xsd'));
	}
	
	public function testValidateXmlFileXmlReader()
	{
		$sepa = $this->getSepaObject();
		$xml = $this->getSepaXmlObject($sepa);
		
		$xml = new \XMLReader();
		$xml->xml($xml->get());
		$xml->setSchema(__DIR__ . '/../src/schema/pain.001.001.03.xsd');
		while ($xml->read());
		
		$this->assertTrue($xml->isValid());
	}
	
	private function getSepaObject($validatorFactoryMock = false)
	{
		if ($validatorFactoryMock)
		{
			$validatorFactory = $this->getValidatorFactoryMock();
		}
		else
		{
			$validatorFactory = new \MG\Sepa\Validator\Factory();
		}
		$sepa = new \MG\Sepa\CreditTransfer($validatorFactory);
		$sepa->setInitiator("Markus Görnhardt");
		
		$payment = new \MG\Sepa\Payment($validatorFactory);
		$payment->setAccount("Markus Görnhardt", "DE89840500001565003795", "HELADEF1RRS");
		
		// first transaction
		$transaction = new \MG\Sepa\Transaction($validatorFactory);
		$transaction->setName("Karl Kümmel")
			->setIban("DE87200500001234567890")
			->setBic("BANKDEZZXXX")
			->setAmount(123.45)
			->setReference("Rechnung R2017742 vom 17.06.2017");
		$payment->addTransaction($transaction);
		
		// second transaction
		$transaction = new \MG\Sepa\Transaction($validatorFactory);
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
		$xml = new \MG\Sepa\Xml($sepa);
		
		return $xml;
	}
	
	private function getValidatorFactoryMock()
	{
		return new class
		{
		    public function getValidator(string $type) : \MG\Sepa\Validator
			{
				return new \MG\Sepa\Validator\Mock();
			}
		};
	}
}