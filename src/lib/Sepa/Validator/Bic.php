<?php
// $Id: Bic.php 7379 2017-08-02 12:27:58Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Validates BIC
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Bic implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^[A-Z]{6}[A-Z2-9][A-NP-Z0-9]([A-Z0-9]{3})?$/", $subject);
	}
}