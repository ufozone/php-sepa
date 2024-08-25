<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

/**
 * Validator Interface
 * 
 * @author Markus
 * @since      2017-06-15
 */
interface Validator
{
	public function isValid($subject) : bool;
}