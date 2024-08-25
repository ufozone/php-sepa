<?php
// $Id: Factory.php 8834 2024-08-25 14:52:29Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

use \MG\Sepa\Validator;

/**
 * Validator Factory
 * 
 * @author Markus
 * @since      2017-06-16
 */
class Factory
{
	public function getValidator(string $type) : Validator
	{
		/**
		 * @var Validator[]
		 */
		static $validators = [];
		$validatorName = '\\MG\\Sepa\\Validator\\' . $type;
		if (!class_exists($validatorName))
		{
			throw new Exception('Unknown type: ' . $type, Exception::NO_VALID_VALIDATOR);
		}
		if (!isSet($validators[$type]))
		{
			$validators[$type] = new $validatorName();
		}
		return $validators[$type];
	}
}