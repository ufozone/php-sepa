<?php
// $Id: Date.php 7657 2019-04-12 21:26:58Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate date (YYYY-MM-DD)
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Date implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^\d{4}-\d{2}-\d{2}$/", $subject);
	}
}