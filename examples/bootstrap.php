<?php
// error reporting setup
@error_reporting(E_ALL ^ E_DEPRECATED);
@ini_set("log_errors", true);
@ini_set("display_errors", true);

// deactivate maximum execution time
@set_time_limit(0);

// set memory limit
@ini_set("memory_limit", "256M");

// set the encoding to UTF-8
$charset = "utf-8";
@ini_set("default_charset", $charset);
@mb_internal_encoding($charset);

/**
 * format bytes to biggest unit
 * 
 * @param number $bytes
 * @param number $decimals
 * @return string
 */
function formatFilesize($bytes, $decimals = 2)
{
	if (($bytes = intval($bytes)) < 1024)
	{
		return "{$bytes} Byte";
	}
	$units = ["KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
	foreach ($units as $k => $unit)
	{
		$multiplier = pow(1024, $k + 1);
		if ($bytes < ($multiplier * 1024))
		{
			break;
		}
	}
	return number_format(($bytes / $multiplier), $decimals, ",", ".") . " {$unit}";
}
