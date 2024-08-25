<?php
// $Id: Mock.php 7657 2019-04-12 21:26:58Z markus $
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Mock Object
 * 
 * @author Markus
 * @since      2017-07-13
 */
class Mock implements \ufozone\phpsepa\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return true;
	}
}