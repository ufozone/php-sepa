<?php
// $Id: DirectDebit.php 8745 2024-03-28 17:08:31Z markus $
declare(strict_types=1);

namespace MG\Sepa;

use MG\Sepa;
use \MG\Sepa\Validator\Factory as ValidatorFactory;

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