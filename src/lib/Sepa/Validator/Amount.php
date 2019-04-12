<?php
// $Id: Amount.php 7027 2017-06-16 07:22:34Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate amount
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Amount implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return !($subject < 0.01 || $subject > 999999999.99);
	}
}