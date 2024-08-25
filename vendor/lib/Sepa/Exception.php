<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

/**
 * Extension of base exception to define SEPA related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \Exception
{
	const MESSAGE_ID_EMTPY = 1101;
	const MESSAGE_ID_INVALID = 1102;
	const INITIATOR_MISSING = 1200;
	const INITIATOR_EMPTY = 1201;
	const NO_TRANSACTIONS_PROVIDED = 1300;
}