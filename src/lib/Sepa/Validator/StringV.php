<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate if the given test subject is a string (also able to invalidate empty strings)
 * 
 * Since "String" is a forbidden classname, beginning with PHP 7.0, StringV is used!
 * 
 * @author Markus
 * @since      2017-06-15
 */
class StringV implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject, bool $failEmpty = false) : bool
	{
		return (is_string($subject) || (true === $failEmpty && strlen(trim($subject)) === 0));
	}
}