<?php
// $Id: CreditTransfer.php 7387 2017-08-07 12:19:14Z markus $
declare(strict_types=1);

namespace MG\Sepa;

use MG\Sepa;
use \MG\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Credit Transfer
 * 
 * @author Markus
 * @since      2017-06-08
 */
class CreditTransfer extends Sepa
{
	/**
	 * the constructor
	 */
	public function __construct(ValidatorFactory $validatorFactory)
	{
		$this->validatorFactory = $validatorFactory;
		$this->type = self::CREDIT_TRANSFER;
		$this->pain = 'pain.001.001.03';
	}
}