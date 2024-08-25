<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa\Validator;

/**
 * trait to calculate checksums
 * 
 * @author Markus
 * @since      2017-06-15
 */
trait Checksum
{
	/**
	 * Calculate check digit (ISO 13616:2007)
	 *
	 * @param string $checkSum
	 * @return int
	 */
	protected function calculateCheckDigit(string $checkSum) : int
	{
		$iLen = strlen($checkSum);
		for ($i = 0; $i < $iLen; $i++)
		{
			$asciiCodeElement = ord($checkSum[$i]);
			if ($asciiCodeElement > 64 && $asciiCodeElement < 91)
			{
				$checkSum = substr($checkSum, 0, $i) . (string) $asciiCodeElement - 55 . substr($checkSum, $i + 1);
			}
		}
		$left = 0;
		$pLen = strlen($checkSum);
		for ($p = 0; $p < $pLen; $p += 7) // workaround cause number to big for one run
		{
			$part = strval($left) . substr($checkSum, $p, 7);
			$left = intval($part) % 97;
		}
		return (int) sprintf("%02d", 98 - $left);
	}
}