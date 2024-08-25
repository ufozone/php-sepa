<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate datetime (YYYY-MM-DD\THH:II:SS)
 * 
 * @author Markus
 * @since      2017-06-15
 */
class DateTime implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/", $subject);
	}
}