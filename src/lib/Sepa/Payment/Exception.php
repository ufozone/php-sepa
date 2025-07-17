<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Payment;

/**
 * Extension of base exception to define payment related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \ufozone\phpsepa\Sepa\Exception
{
	const PAYMENT_INFORMATION_ID_EMPTY = 2101;
	const PAYMENT_INFORMATION_ID_INVALID = 2102;
	const DATE_EMPTY = 2201;
	const DATE_INVALID = 2202;
	const ACCOUNT_NAME_MISSING = 2310;
	const ACCOUNT_NAME_EMPTY = 2311;
	const ACCOUNT_IBAN_MISSING = 2320;
	const ACCOUNT_IBAN_EMPTY = 2321;
	const ACCOUNT_IBAN_INVALID = 2322;
	const ACCOUNT_BIC_EMPTY = 2331;
	const ACCOUNT_BIC_INVALID = 2332;
	const ACCOUNT_CURRENCY_EMPTY = 2341;
	const ACCOUNT_CURRENCY_INVALID = 2342;
	const PRIORITY_EMPTY = 2811;
	const PRIORITY_INVALID = 2812;
	const SCOPE_EMPTY = 2911;
	const SCOPE_INVALID = 2912;
	const SEQUENCE_EMPTY = 2921;
	const SEQUENCE_INVALID = 2922;
	const CREDITOR_ID_MISSING = 2930;
	const CREDITOR_ID_EMPTY = 2931;
	const CREDITOR_ID_INVALID = 2932;
}