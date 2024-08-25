<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Transaction;

/**
 * Extension of base exception to define transaction related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \ufozone\phpsepa\Sepa\Exception
{
	const INSTRUCTION_ID_EMPTY = 3101;
	const INSTRUCTION_ID_INVALID = 3102;
	const END2END_ID_EMPTY = 3201;
	const END2END_ID_INVALID = 3202;
	const NAME_MISSING = 3300;
	const NAME_EMPTY = 3301;
	const IBAN_MISSING = 3400;
	const IBAN_EMPTY = 3401;
	const IBAN_INVALID = 3402;
	const BIC_EMPTY = 3501;
	const BIC_INVALID = 3502;
	const AMOUNT_MISSING = 3600;
	const AMOUNT_INVALID = 3602;
	const CURRENCT_EMPTY = 3701;
	const CURRENCY_INVALID = 3702;
	const PURPOSE_CODE_EMPTY = 3801;
	const PURPOSE_CODE_INVALID = 3802;
	const MANDATE_ID_MISSING = 3910;
	const MANDATE_ID_EMPTY = 3911;
	const MANDATE_ID_INVALID = 3912;
	const MANDATE_DATE_MISSING = 3920;
	const MANDATE_DATE_EMPTY = 3921;
	const MANDATE_DATE_INVALID = 3922;
	const ORIGINAL_MANDATE_ID_EMPTY = 3951;
	const ORIGINAL_MANDATE_ID_INVALID = 3952;
	const ORIGINAL_MANDATE_IBAN_EMPTY = 3961;
	const ORIGINAL_MANDATE_IBAN_INVALID = 3962;
	const ORIGINAL_MANDATE_BIC_EMPTY = 3971;
	const ORIGINAL_MANDATE_BIC_INVALID = 3972;
}