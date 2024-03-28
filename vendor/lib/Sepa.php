<?php
// $Id: Sepa.php 7657 2019-04-12 21:26:58Z markus $
declare(strict_types=1);

namespace MG;

use \MG\Sepa\Exception as SepaException;
use \MG\Sepa\Payment;
use \MG\Sepa\Validator\Factory as ValidatorFactory;

/**
 * SEPA
 * 
 * @author Markus
 * @since      2017-06-08
 */
abstract class Sepa
{
	const CREDIT_TRANSFER = 1;
	const DIRECT_DEBIT = 2;
	
	/**
	 * Type (Credit Transfer, Direct Debit)
	 * @var string
	 */
	protected $type = 0;
	
	/**
	 * PAIN Version
	 * @var string
	 */
	protected $pain = '';
	
	/**
	 * @var ValidatorFactory
	 */
	protected $validatorFactory;
	
	/**
	 * Global Message Identifier
	 * @var string
	 */
	private $id = '';
	
	/**
	 * Initiator Name
	 * @var string
	 */
	private $initiator = '';
	
	/**
	 * Payment Collections
	 * @var array
	 */
	private $payments = [];
	
	/**
	 * constructor
	 * 
	 * @param ValidatorFactory $validatorFactory
	 */
	abstract public function __construct(ValidatorFactory $validatorFactory);
	
	/**
	 * get type
	 * 
	 * @return int
	 */
	public function getType() : int
	{
		return $this->type;
	}
	
	/**
	 * get pain mode
	 * 
	 * @return string
	 */
	public function getPain() : string
	{
		return $this->pain;
	}
	
	/**
	 * set message identifier
	 * 
	 * @param string $id
	 * @throws SepaException
	 * @return Sepa
	 */
	public function setId(string $id) : Sepa
	{
		if (!$id = trim($id))
		{
			throw new SepaException('Message Identifier empty', SepaException::MESSAGE_ID_EMTPY);
		}
		if (!$this->validatorFactory->getValidator("Id1")->isValid($id))
		{
			throw new SepaException('Message Identifier invalid (' . $id . ')', SepaException::MESSAGE_ID_INVALID);
		}
		$this->id = $id;
		
		return $this;
	}
	
	/**
	 * get message identifier
	 * 
	 * @return string
	 */
	public function getId() : string
	{
		return $this->id ?: 'SEPA-' . gmdate('YmdHis') . '-' . str_pad((string) getmypid(), 5, '0', STR_PAD_LEFT);
	}
	
	/**
	 * set initiator
	 * 
	 * @param string $initiator
	 * @throws SepaException
	 * @return Sepa
	 */
	public function setInitiator(string $initiator) : Sepa
	{
		if (!$initiator = trim($initiator))
		{
			throw new SepaException('Initiator empty', 1200);
		}
		$this->initiator = $initiator;
		
		return $this;
	}
	
	/**
	 * get initiator
	 * 
	 * @return string
	 */
	public function getInitiator() : string
	{
		return $this->initiator;
	}
	
	/**
	 * add payment collection
	 * 
	 * @param Payment $payment
	 * @return Sepa
	 */
	public function addPayment(Payment $payment) : Sepa
	{
		$this->payments[] = $payment;
		
		return $this;
	}
	
	/**
	 * get payment collections
	 * 
	 * return array
	 */
	public function getPayments() : array
	{
		return $this->payments;
	}
	
	/**
	 * counts the transactions in all collections
	 * 
	 * @return int
	 */
	public function getNumberOfTransactions() : int
	{
		$numberOfTransactions = 0;
		foreach ($this->payments as $payment)
		{
			$numberOfTransactions += $payment->getNumberOfTransactions();
		}
		return $numberOfTransactions;
	}
	
	/**
	 * get control sum
	 * 
	 * @return int
	 */
	public function getControlSum() : int
	{
		$controlSum = 0;
		foreach ($this->payments as $payment)
		{
			$controlSum += $payment->getControlSum();
		}
		return $controlSum;
	}
	
	/**
	 * check necessary data
	 * 
	 * @throws SepaException
	 * @return bool
	 */
	public function validate() : bool
	{
		if ($this->initiator === '')
		{
			throw new SepaException('Initiator missing', SepaException::INITIATOR_MISSING);
		}
		if ($this->getNumberOfTransactions() === 0)
		{
			throw new SepaException('No transactions provided', SepaException::NO_TRANSACTIONS_PROVIDED);
		}
		$isDirectDebit = ($this->type === self::DIRECT_DEBIT);
		foreach ($this->payments as $payment)
		{
			$payment->validate($isDirectDebit);
		}
		return true;
	}
}