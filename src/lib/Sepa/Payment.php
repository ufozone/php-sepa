<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa\Payment\Exception as PaymentException;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Payment Class
 * 
 * @author  ufozone
 * @since   2017-06-08
 */
class Payment
{
    /**
     * Payment Information Identifier
     */
    private string $id = '';
    
    /**
     * Scope (CORE, B2B, INST)
     */
    private $scope = '';
    
    /**
     * Sequence (OOFF, FRST, RCUR, FNAL)
     */
    private string $sequence = '';
    
    /**
     * Creditor Identifier
     */
    private string $creditorId = '';
    
    /**
     * Global Priority
     */
    private string $priority = '';
    
    /**
     * Batch Booking
     */
    private bool $batchBooking = true;

    /**
     * Execution Date
     */
    private ?\DateTimeImmutable $executionDate = null;
    
    /**
     * Creditor or Debtor Name
     */
    private string $accountName = '';

    /**
     * Creditor or Debtor Postal Address
     */
    private ?PostalAddress $accountPostalAddress = null;
    
    /**
     * Creditor or Debtor IBAN
     */
    private string $accountIban = '';
    
    /**
     * Creditor or Debtor BIC
     */
    private string $accountBic = '';
    
    /**
     * Creditor or Debtor Currency
     */
    private string $accountCurrency = '';
    
    /**
     * Ultimate Creditor or Debtor Name
     */
    private string $ultimateName = '';
    
    /**
     * Payment Transactions
     */
    private array $transactions = [];
    
    /**
     * Validator Factory
     */
    private ValidatorFactory $validatorFactory;
    
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
            throw new PaymentException('Payment Information Identifier invalid ({id})', PaymentException::PAYMENT_INFORMATION_ID_INVALID, null, ['id' => $id]);
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
            throw new PaymentException('Scope wrong ({scope})', PaymentException::SCOPE_INVALID, null, ['scope' => $scope]);
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
            throw new PaymentException('Sequence ({sequence}) invalid', PaymentException::SEQUENCE_INVALID, null, ['sequence' => $sequence]);
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
            throw new PaymentException('Creditor Identifier ({creditorId}) invalid', PaymentException::CREDITOR_ID_INVALID, null, ['creditorId' => $creditorId]);
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
            throw new PaymentException('Priority ({priority}) invalid, must be NORM or HIGH', PaymentException::PRIORITY_INVALID, null, ['priority' => $priority]);
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
     * Set batch booking
     * 
     * @param bool $batchBooking
     * @return Payment
     */
    public function setBatchBooking(bool $batchBooking) : Payment
    {
        $this->batchBooking = $batchBooking;
        
        return $this;
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
     * @param \DateTimeInterface $executionDate
     * @throws PaymentException
     * @return Payment
     */
    public function setExecutionDate(\DateTimeInterface $executionDate) : Payment
    {
        if (!($executionDate instanceof \DateTimeImmutable))
        {
            $executionDate = new \DateTimeImmutable(
                $executionDate->format('Y-m-d'),
                $executionDate->getTimezone()
            );
        }
        $executionDate = $executionDate->setTime(0, 0, 0);
        if ($executionDate < (new \DateTimeImmutable())->setTime(0, 0, 0))
        {
            throw new PaymentException('Execution date ({date}) in the past, expected is today or in the future', PaymentException::DATE_PAST, null, ['date' => $executionDate->format('Y-m-d')]);
        }
        $this->executionDate = $executionDate;
        
        return $this;
    }
    
    /**
     * Get execution date
     * 
     * @return \DateTimeImmutable
     */
    public function getExecutionDate() : \DateTimeImmutable
    {
        return ($this->executionDate ?? new \DateTimeImmutable())->setTime(0, 0, 0); 
    }
    
    /**
     * Set execution date
     * 
     * @deprecated Deprecated since v2.2, use setExecutionDate instead
     * @param string $date (YYYY-MM-DD)
     * @throws PaymentException
     * @return Payment
     */
    #[Deprecated(message: 'use setExecutionDate instead', since: 'v2.2')]
    public function setDate(string $date) : Payment
    {
        if (\PHP_VERSION_ID < 80400)
        {
            trigger_error('Function setDate() is deprecated since v2.2, use setExecutionDate instead', E_USER_DEPRECATED);
        }
        if (!$date = trim($date))
        {
            throw new PaymentException('Date empty', PaymentException::DATE_EMPTY);
        }
        if (!$this->validatorFactory->getValidator("Date")->isValid($date))
        {
            throw new PaymentException('Date ({date}) invalid, must be YYYY-MM-DD', PaymentException::DATE_INVALID, null, ['date' => $date]);
        }
        $this->setExecutionDate(new \DateTimeImmutable($date));
        
        return $this;
    }
    
    /**
     * Get execution date
     * 
     * @deprecated Deprecated since v2.2, use getExecutionDate instead
     * @return string
     */
    #[Deprecated(message: 'use getExecutionDate instead', since: 'v2.2')]
    public function getDate() : string
    {
        if (\PHP_VERSION_ID < 80400)
        {
            trigger_error('Function getDate() is deprecated since v2.2, use getExecutionDate instead', E_USER_DEPRECATED);
        }
        return $this->getExecutionDate()->format('Y-m-d');
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
     * Set applicant postal address
     * 
     * @param PostalAddress|null $postalAddress
     * @return Payment
     */
    public function setAccountPostalAddress(?PostalAddress $postalAddress) : Payment
    {
        $this->accountPostalAddress = $postalAddress;
        
        return $this;
    }

    /**
     * Get applicant postal address
     * 
     * @return PostalAddress|null
     */
    public function getAccountPostalAddress() : ?PostalAddress
    {
        return $this->accountPostalAddress;
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
            throw new PaymentException('Debtor or Creditor IBAN ({iban}) invalid', PaymentException::ACCOUNT_IBAN_INVALID, null, ['iban' => $iban]);
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
            throw new PaymentException('Debtor or Creditor BIC ({bic}) invalid', PaymentException::ACCOUNT_BIC_INVALID, null, ['bic' => $bic]);
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
            throw new PaymentException('Debtor or Creditor currency ({currency}) invalid', PaymentException::ACCOUNT_CURRENCY_INVALID, null, ['currency' => $currency]);
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