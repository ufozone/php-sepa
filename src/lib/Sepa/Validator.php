<?php
// $Id: Validator.php 7028 2017-06-16 07:28:15Z markus $
declare(strict_types=1);

namespace MG\Sepa;

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