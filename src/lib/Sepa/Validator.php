<?php
// $Id: Validator.php 7657 2019-04-12 21:26:58Z markus $
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