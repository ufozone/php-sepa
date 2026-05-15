<?php
declare(strict_types=1);

namespace ufozone\phpsepa;

use \ufozone\phpsepa\Sepa\Exception as SepaException;
use \ufozone\phpsepa\Sepa\Payment;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * SEPA
 * 
 * @author  ufozone
 * @since   2017-06-08
 */
abstract class Sepa
{
    const CREDIT_TRANSFER = 1;
    const DIRECT_DEBIT = 2;
    
    /**
     * Type (Credit Transfer, Direct Debit)
     */
    protected $type = 0;
    
    /**
     * PAIN Version
     */
    protected $pain = '';
    
    /**
     * Default Scope
     */
    protected $defaultScope = '';
    
    /**
     * Default Sequence
     */
    protected $defaultSequence = '';
    
    /**
     * Validator Factory
     */
    protected $validatorFactory;
    
    /**
     * Global Message Identifier
     */
    private $id = '';
    
    /**
     * Initiator Name
     */
    private $initiator = '';
    
    /**
     * Payment Collections
     */
    private $payments = [];
    
    /**
     * Constructor
     * 
     * @param ValidatorFactory $validatorFactory
     */
    abstract public function __construct(ValidatorFactory $validatorFactory);
    
    /**
     * Get type
     * 
     * @return int
     */
    public function getType() : int
    {
        return $this->type;
    }
    
    /**
     * Get pain mode
     * 
     * @return string
     */
    public function getPain() : string
    {
        return $this->pain;
    }
    
    /**
     * Set message identifier
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
            throw new SepaException('Message Identifier invalid ({id})', SepaException::MESSAGE_ID_INVALID, null, ['id' => $id]);
        }
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Get message identifier
     * 
     * @return string
     */
    public function getId() : string
    {
        return $this->id ?: 'SEPA-' . gmdate('YmdHis') . '-' . str_pad((string) getmypid(), 5, '0', STR_PAD_LEFT);
    }
    
    /**
     * Set initiator
     * 
     * @param string $initiator
     * @throws SepaException
     * @return Sepa
     */
    public function setInitiator(string $initiator) : Sepa
    {
        if (!$initiator = trim($initiator))
        {
            throw new SepaException('Initiator empty', SepaException::INITIATOR_EMPTY);
        }
        $this->initiator = $initiator;
        
        return $this;
    }
    
    /**
     * Get initiator
     * 
     * @return string
     */
    public function getInitiator() : string
    {
        return $this->initiator;
    }
    
    /**
     * Add payment collection
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
     * Get payment collections
     * 
     * return array
     */
    public function getPayments() : array
    {
        return $this->payments;
    }
    
    /**
     * Counts the transactions in all collections
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
     * Get control sum
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
     * Get default scope
     * 
     * @return string
     */
    public function getDefaultScope() : string
    {
        return $this->defaultScope;
    }
    
    /**
     * Get default sequence
     * 
     * @return string
     */
    public function getDefaultSequence() : string
    {
        return $this->defaultSequence;
    }
    
    /**
     * Check necessary data
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