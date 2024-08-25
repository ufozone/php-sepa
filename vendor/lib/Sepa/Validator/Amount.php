<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate amount
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Amount implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return !($subject < 0.01 || $subject > 999999999.99);
	}
}