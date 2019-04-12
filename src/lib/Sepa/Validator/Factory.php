<?php
// $Id: Factory.php 7075 2017-07-04 18:33:52Z markus $
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
			throw new \MG\Exception('Unknown type: ' . $type);
		}
		if (!isSet($validators[$type]))
		{
			$validators[$type] = new $validatorName();
		}
		return $validators[$type];
	}
}