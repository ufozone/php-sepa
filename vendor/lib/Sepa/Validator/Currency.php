<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate currency (ISO 4217)
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Currency implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^[A-Z]{3}$/", $subject);
	}
}