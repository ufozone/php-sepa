<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Class to validate country code (ISO 3166, Alpha-2 code)
 * 
 * @author Markus
 * @since      2025-11-07
 */
class CountryCode implements \ufozone\phpsepa\Sepa\Validator
{
    public function isValid($subject) : bool
    {
        return (bool) preg_match("/^[A-Z]{2,2}$/", $subject);
    }
}