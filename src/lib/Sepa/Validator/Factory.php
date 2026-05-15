<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

use \ufozone\phpsepa\Sepa\Validator;

/**
 * Validator Factory
 * 
 * @author  ufozone
 * @since   2017-06-16
 */
class Factory
{
    public function getValidator(string $type) : Validator
    {
        /**
         * @var array<string, Validator>
         */
        static $validators = [];
        $validatorName = '\\ufozone\\phpsepa\\Sepa\\Validator\\' . $type;
        if (!class_exists($validatorName))
        {
            throw new Exception('Unknown type: {type}', Exception::NO_VALID_VALIDATOR, null, ['type' => $type]);
        }
        if (!isset($validators[$type]))
        {
            $validators[$type] = new $validatorName();
        }
        return $validators[$type];
    }
}