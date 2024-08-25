<?php
// $Id: Exception.php 8834 2024-08-25 14:52:29Z markus $
declare(strict_types=1);

namespace MG\Sepa\Validator;

/**
 * Extension of base exception to define validator related errors
 * 
 * @author Markus
 * @since      2024-08-25
 * @uses \Exception
 */
class Exception extends \Exception
{
	const NO_VALID_VALIDATOR = 4000;
}