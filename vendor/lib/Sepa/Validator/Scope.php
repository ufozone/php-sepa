<?php
// $Id: Scope.php 8740 2024-03-28 16:03:37Z markus $
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate scope
 * 
 * @author Markus
 * @since      2017-06-15
 */
class Scope implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^(CORE|B2B|INST)$/", $subject);
	}
}