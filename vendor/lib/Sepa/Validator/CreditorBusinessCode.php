<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Validates Creditor Business Code
 * 
 * @author Markus
 * @since      2017-06-15
 */
class CreditorBusinessCode implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^[A-Z0-9]{3}$/", $subject);
	}
}