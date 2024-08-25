<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Validates IBAN (international)
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Iban implements \ufozone\phpsepa\Sepa\Validator
{
	use Checksum;
	
	public function isValid($subject) : bool
	{
		if (!preg_match("/^[A-Z]{2}[0-9]{2}[a-zA-Z0-9]{1,30}$/", $subject))
		{
			return false;
		}
		// Position 5-34, Position 1-2 (Country code; numerically converted), Position 3-4 (Check digit)
		$checkSum = substr($subject, 4) . strval(ord($subject[0]) - 55) . strval(ord($subject[1]) - 55) . substr($subject, 2, 2);
		
		return ($this->calculateCheckDigit($checkSum) === 97);
	}
}