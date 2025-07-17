<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * Extension of base exception to define validator related errors
 * 
 * @author Markus
 * @since      2024-08-25
 * @uses \Exception
 */
class Exception extends \ufozone\phpsepa\Sepa\Exception
{
	const NO_VALID_VALIDATOR = 4000;
}