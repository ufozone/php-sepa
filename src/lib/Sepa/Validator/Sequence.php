<?php
// $Id: Sequence.php 7353 2017-08-01 19:53:34Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate sequence
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Sequence implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^(OOFF|FRST|RCUR|FNAL)$/", $subject);
	}
}