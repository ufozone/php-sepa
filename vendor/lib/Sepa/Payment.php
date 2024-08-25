<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa\Payment\Exception as PaymentException;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Payment Class
 * 
 * @author Markus
 * @since      2017-06-08
 */
class Payment
{
	/**
	 * Payment Information Identifier
	 * @var string
	 */
	private $id = '';
	
	/**
	 * Scope (CORE, B2B, INST)
	 * @var string
	 */
	private $scope = '';
	
	/**
	 * Sequence (OOFF, FRST, RCUR, FNAL)
	 * @var string
	 */
	private $sequence = '';
	
	/**
	 * Creditor Identifier
	 * @var string
	 */
	private $creditorId = '';
	
	/**
	 * Global Priority
	 * @var string
	 */
	private $priority = '';
	
	/**
	 * Batch Booking
	 * @var bool
	 */
	private $batchBooking = true;
	
	/**
	 * Date (YYYY-MM-DD)
	 * @var string
	 */
	private $date = '';
	
	/**
	 * Creditor or Debtor Name
	 * @var string
	 */
	private $accountName = '';
	
	/**
	 * Creditor or Debtor IBAN
	 * @var string
	 */
	private $accountIban = '';
	
	/**
	 * Creditor or Debtor BIC
	 * @var string
	 */
	private $accountBic = '';
	
	/**
	 * Creditor or Debtor Currency
	 * @var string
	 */
	private $accountCurrency = '';
	
	/**
	 * Ultimate Creditor or Debtor Name
	 * @var string
	 */
	private $ultimateName = '';
	
	/**
	 * Payment Transactions
	 * @var array
	 */
	private $transactions = [];
	
	/**
	 * @var ValidatorFactory
	 */
	private $validatorFactory;
	
	/**
	 * Constructor
	 * 
	 * @param ValidatorFactory $validatorFactory
	 */
	public function __construct(ValidatorFactory $validatorFactory)
	{
		$this->validatorFactory = $validatorFactory;
	}
	
	/**
	 * Set payment information identifier
	 * 
	 * @param string $id
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setId(string $id) : Payment
	{
		if (!$id = trim($id))
		{
			throw new PaymentException('Payment Information Identifier empty', PaymentException::PAYMENT_INFORMATION_ID_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Id1")->isValid($id))
		{
			throw new PaymentException('Payment Information Identifier invalid (' . $id . ')', PaymentException::PAYMENT_INFORMATION_ID_INVALID);
		}
		$this->id = $id;
		
		return $this;
	}
	
	/**
	 * Get payment information identifier
	 * 
	 * @return string
	 */
	public function getId() : string
	{
		return $this->id;
	}
	
	/**
	 * Set scope
	 * 
	 * @param string $scope
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setScope(string $scope) : Payment
	{
		$scope = strtoupper($scope);
		if (!$scope = trim($scope))
		{
			throw new PaymentException('Scope empty', PaymentException::SCOPE_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Scope")->isValid($scope))
		{
			throw new PaymentException('Scope wrong (' . $scope . ')', PaymentException::SCOPE_INVALID);
		}
		$this->scope = $scope;
		
		return $this;
	}
	
	/**
	 * Get scope
	 * 
	 * @return string
	 */
	public function getScope() : string
	{
		return $this->scope;
	}
	
	/**
	 * Set sequence
	 * 
	 * @param string $sequence
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setSequence(string $sequence) : Payment
	{
		$sequence = strtoupper($sequence);
		if (!$sequence = trim($sequence))
		{
			throw new PaymentException('Sequence empty', PaymentException::SEQUENCE_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Sequence")->isValid($sequence))
		{
			throw new PaymentException('Sequence (' . $sequence . ') invalid', PaymentException::SEQUENCE_INVALID);
		}
		$this->sequence = $sequence;
		
		return $this;
	}
	
	/**
	 * Get sequence
	 * 
	 * @return string
	 */
	public function getSequence() : string
	{
		return $this->sequence;
	}
	
	/**
	 * Set creditor identifier
	 * 
	 * @param string $creditorId
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setCreditorId(string $creditorId) : Payment
	{
		if (!$creditorId = trim($creditorId))
		{
			throw new PaymentException('Creditor Identifier empty', PaymentException::CREDITOR_ID_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("CreditorId")->isValid($creditorId))
		{
			throw new PaymentException('Creditor Identifier (' . $creditorId . ') invalid', PaymentException::CREDITOR_ID_INVALID);
		}
		$this->creditorId = $creditorId;
		
		return $this;
	}
	
	/**
	 * Get creditor identifier
	 * 
	 * @return string
	 */
	public function getCreditorId() : string
	{
		return $this->creditorId;
	}
	
	/**
	 * Set priority
	 * 
	 * @param string $priority
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setPriority(string $priority) : Payment
	{
		$priority = strtoupper($priority);
		if (!$priority = trim($priority))
		{
			throw new PaymentException('Priority empty', PaymentException::PRIORITY_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Priority")->isValid($priority))
		{
			throw new PaymentException('Priority (' . $priority . ') invalid, must be NORM or HIGH', PaymentException::PRIORITY_INVALID);
		}
		$this->priority = $priority;
		
		return $this;
	}
	
	/**
	 * Get priority
	 * 
	 * @return string
	 */
	public function getPriority() : string
	{
		return $this->priority;
	}
	
	/**
	 * Enable batch booking
	 * 
	 * @return Payment
	 */
	public function enableBatchBooking() : Payment
	{
		$this->batchBooking = true;
		
		return $this;
	}
	
	/**
	 * Disable batch booking
	 * 
	 * @return Payment
	 */
	public function disableBatchBooking() : Payment
	{
		$this->batchBooking = false;
		
		return $this;
	}
	
	/**
	 * Get batch booking
	 * 
	 * @return bool
	 */
	public function isBatchBooking() : bool
	{
		return $this->batchBooking;
	}
	
	/**
	 * Set execution date
	 * 
	 * @param string $date (YYYY-MM-DD)
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setDate(string $date) : Payment
	{
		if (!$date = trim($date))
		{
			throw new PaymentException('Date empty', PaymentException::DATE_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Date")->isValid($date))
		{
			throw new PaymentException('Date (' . $date . ') invalid, must be YYYY-MM-DD', PaymentException::DATE_INVALID);
		}
		$this->date = $date;
		
		return $this;
	}
	
	/**
	 * Get execution date
	 * 
	 * @return string
	 */
	public function getDate() : string
	{
		return $this->date ?: gmdate('Y-m-d');
	}
	
	/**
	 * Set applicant (debtor or creditor)
	 * 
	 * @param string $name
	 * @param string $iban
	 * @param string $bic
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setAccount(string $name, string $iban, string $bic = '') : Payment
	{
		$this->setAccountName($name);
		$this->setAccountIban($iban);
		if ($bic !== '')
		{
			$this->setAccountBic($bic);
		}
		return $this;
	}
	
	/**
	 * Set applicant name
	 * 
	 * @param string $name
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setAccountName(string $name) : Payment
	{
		if (!$name = trim($name))
		{
			throw new PaymentException('Debtor or Creditor name empty', PaymentException::ACCOUNT_NAME_EMPTY);
		}
		$this->accountName = $name;
		
		return $this;
	}
	
	/**
	 * Get applicant name
	 * 
	 * @return string
	 */
	public function getAccountName() : string
	{
		return $this->accountName;
	}
	
	/**
	 * Set applicant IBAN
	 * 
	 * @param string $iban
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setAccountIban(string $iban) : Payment
	{
		if (!$iban = trim($iban))
		{
			throw new PaymentException('Debtor or Creditor IBAN empty', PaymentException::ACCOUNT_IBAN_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Iban")->isValid($iban))
		{
			throw new PaymentException('Debtor or Creditor IBAN (' . $iban . ') invalid', PaymentException::ACCOUNT_IBAN_INVALID);
		}
		$this->accountIban = $iban;
		
		return $this;
	}
	
	/**
	 * Get applicant IBAN
	 *
	 * @return string
	 */
	public function getAccounIban() : string
	{
		return $this->accountIban;
	}
	
	/**
	 * Set applicant BIC
	 * 
	 * @param string $bic
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setAccountBic(string $bic = '') : Payment
	{
		if (!$bic = trim($bic))
		{
			throw new PaymentException('Debtor or Creditor BIC empty', PaymentException::ACCOUNT_BIC_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Bic")->isValid($bic))
		{
			throw new PaymentException('Debtor or Creditor BIC (' . $bic . ') invalid', PaymentException::ACCOUNT_BIC_INVALID);
		}
		$this->accountBic = str_pad($bic, 11, 'X');
		
		return $this;
	}
	
	/**
	 * Get applicant BIC
	 * 
	 * @return string
	 */
	public function getAccountBic() : string
	{
		return $this->accountBic;
	}
	
	/**
	 * Set account currency
	 * 
	 * @param string $currency
	 * @throws PaymentException
	 * @return Payment
	 */
	public function setAccountCurrency(string $currency) : Payment
	{
		$currency = strtoupper($currency);
		if (!$currency = trim($currency))
		{
			throw new PaymentException('Debtor or Creditor currency empty', PaymentException::ACCOUNT_CURRENCY_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("Currency")->isValid($currency))
		{
			throw new PaymentException('Debtor or Creditor currency (' . $currency . ') invalid', PaymentException::ACCOUNT_CURRENCY_INVALID);
		}
		$this->accountCurrency = $currency;
		
		return $this;
	}
	
	/**
	 * Get applicant currency
	 * 
	 * @return string
	 */
	public function getAccountCurrency() : string
	{
		return $this->accountCurrency;
	}
	
	/**
	 * Set ultimate applicant
	 * 
	 * @param string $ultimateName
	 * @return Payment
	 */
	public function setUltimateName(string $ultimateName) : Payment
	{
		$this->ultimateName = trim($ultimateName);
		
		return $this;
	}
	
	/**
	 * Get ultimate applicant
	 * 
	 * @return string
	 */
	public function getUltimateName() : string
	{
		return $this->ultimateName;
	}
	
	/**
	 * Add transaction
	 * 
	 * @param Transaction $transaction
	 * @return Payment
	 */
	public function addTransaction(Transaction $transaction) : Payment
	{
		$this->transactions[] = $transaction;
		
		return $this;
	}
	
	/**
	 * Get payment transactions
	 * 
	 * return array
	 */
	public function getTransactions() : array
	{
		return $this->transactions;
	}
	
	/**
	 * Counts the transactions in this payment collection
	 * 
	 * @return int
	 */
	public function getNumberOfTransactions() : int
	{
		return count($this->transactions);
	}
	
	/**
	 * Get control sum
	 * 
	 * @return int
	 */
	public function getControlSum() : int
	{
		$controlSum = 0;
		foreach ($this->transactions as $transaction)
		{
			$controlSum += $transaction->getAmount();
		}
		return $controlSum;
	}
	
	/**
	 * Check necessary payment data
	 * 
	 * @param bool $isDirectDebit
	 * @throws PaymentException
	 * @return bool
	 */
	public function validate(bool $isDirectDebit) : bool
	{
		if ($this->accountName === '')
		{
			throw new PaymentException('Debtor or Creditor name missing', PaymentException::ACCOUNT_NAME_MISSING);
		}
		if ($this->accountIban === '')
		{
			throw new PaymentException('Debtor or Creditor IBAN missing', PaymentException::ACCOUNT_IBAN_MISSING);
		}
		if ($isDirectDebit)
		{
			if ($this->creditorId === '')
			{
				throw new PaymentException('Creditor Identifier missing', PaymentException::CREDITOR_ID_MISSING);
			}
		}
		foreach ($this->transactions as $transaction)
		{
			$transaction->validate($isDirectDebit);
		}
		return true;
	}
}