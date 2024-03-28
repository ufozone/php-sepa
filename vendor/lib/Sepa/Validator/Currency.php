<?php
// $Id: Currency.php 7657 2019-04-12 21:26:58Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate currency (ISO 4217)
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Currency implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^[A-Z]{3}$/", $subject);
	}
}