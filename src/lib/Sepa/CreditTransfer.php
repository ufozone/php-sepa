<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

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