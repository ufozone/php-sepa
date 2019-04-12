<?php
// $Id: DateTime.php 7027 2017-06-16 07:22:34Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate datetime (YYYY-MM-DD\THH:II:SS)
 * 
 * @author Markus
 * @since      2017-06-15
 */
class DateTime implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/", $subject);
	}
}