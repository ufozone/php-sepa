<?php
// $Id: Exception.php 8836 2024-08-25 14:58:41Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Extension of base exception to define validator related errors
 * 
 * @author Markus
 * @since      2024-08-25
 * @uses \Exception
 */
class Exception extends \MG\Sepa\Exception
{
	const NO_VALID_VALIDATOR = 4000;
}