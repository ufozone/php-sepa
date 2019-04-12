<?php
// $Id: StringV.php 7027 2017-06-16 07:22:34Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate if the given test subject is a string (also able to invalidate empty strings)
 * 
 * Since "String" is a forbidden classname, beginning with PHP 7.0, StringV is used!
 * 
 * @author Markus
 * @since      2017-06-15
 */
class StringV implements \MG\Sepa\Validator
{
	public function isValid($subject, bool $failEmpty = false) : bool
	{
		return (is_string($subject) || (true === $failEmpty && strlen(trim($subject)) === 0));
	}
}