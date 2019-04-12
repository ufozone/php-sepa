<?php
// $Id: Exception.php 7064 2017-07-04 17:20:25Z markus $
declare(strict_types=1);

namespace MG\Sepa;

/**
 * Extension of base exception to define SEPA related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \MG\Exception
{
	const MESSAGE_ID_EMTPY = 1101;
	const MESSAGE_ID_INVALID = 1102;
	const INITIATOR_MISSING = 1200;
	const INITIATOR_EMPTY = 1201;
	const NO_TRANSACTIONS_PROVIDED = 1300;
}