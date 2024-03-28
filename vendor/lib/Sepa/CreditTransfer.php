<?php
// $Id: CreditTransfer.php 8745 2024-03-28 17:08:31Z markus $
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
	 * Constructor
	 */
	public function __construct(ValidatorFactory $validatorFactory)
	{
		$this->validatorFactory = $validatorFactory;
		$this->type = self::CREDIT_TRANSFER;
		$this->pain = 'pain.001.001.09';
	}
}