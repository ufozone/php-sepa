<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\PostalAddress;

/**
 * Extension of base exception to define postal address related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \ufozone\phpsepa\Sepa\Exception
{
	const COUNTRY_MISSING = 4110;
	const COUNTRY_EMPTY = 4111;
	const COUNTRY_INVALID = 4112;
}