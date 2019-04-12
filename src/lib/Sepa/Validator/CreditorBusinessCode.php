<?php
// $Id: CreditorBusinessCode.php 7379 2017-08-02 12:27:58Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Validates Creditor Business Code
 * 
 * @author Markus
 * @since      2017-06-15
 */
class CreditorBusinessCode implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^[A-Z0-9]{3}$/", $subject);
	}
}