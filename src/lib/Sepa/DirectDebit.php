<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Direct Debit
 * 
 * @author Markus
 * @since      2017-06-08
 */
class DirectDebit extends Sepa
{
	/**
	 * Constructor
	 */
	public function __construct(ValidatorFactory $validatorFactory)
	{
		$this->validatorFactory = $validatorFactory;
		$this->type = self::DIRECT_DEBIT;
		$this->pain = 'pain.008.001.08';
		$this->defaultScope = 'CORE';
		$this->defaultSequence = 'OOFF';
	}
}