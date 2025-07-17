<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Xml;

/**
 * Extension of base exception to define XML related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \ufozone\phpsepa\Sepa\Exception
{
	const CANNOT_OPEN_TMP_FILE = 5100;
	const CANNOT_CREATE_XML = 5200;
	const SCHEMA_FILE_NOT_FOUND = 5300;
}