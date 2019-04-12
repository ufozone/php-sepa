<?php
// $Id: Exception.php 7066 2017-07-04 17:24:06Z markus $
declare(strict_types=1);

namespace MG\Sepa\Xml;

/**
 * Extension of base exception to define XML related errors
 * 
 * @author Markus
 * @since      2017-06-13
 * @uses \Exception
 */
class Exception extends \MG\Exception
{
	const CANNOT_OPEN_TMP_FILE = 4100;
	const CANNOT_CREATE_XML = 4200;
	const SCHEMA_FILE_NOT_FOUND = 4300;
}