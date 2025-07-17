<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate sequence
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Sequence implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^(OOFF|FRST|RCUR|FNAL)$/", $subject);
	}
}