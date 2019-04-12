<?php
// $Id: Purpose.php 7027 2017-06-16 07:22:34Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Class to validate purpose (ISO 20022)
 * 
 * e.g.:
 * SALA	Salary			Gehaltszahlung
 * CBFF	CapitalBuilding	Vermoegenswirksame Leistungen
 * CHAR	Charity			Spende
 * 
 * @author Markus
 * @since      2017-06-15
 * @see https://www.vrb-spangenberg.de/content/dam/f0369-0/neue_homepage/SEPA/Purpose_CODES.pdf
 */
class Purpose implements \MG\Sepa\Validator
{
	public function isValid($subject) : bool
	{
		return (bool) preg_match("/^[A-Z]{4}$/", $subject);
	}
}