<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa\PostalAddress\Exception as PostalAddressException;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Postal Address Class
 * 
 * @author Markus
 * @since      2025-11-07
 */
class PostalAddress
{
	private $department = '';
	
	private $subDepartment = '';

	private $streetName = '';

	private $buildingNumber = '';

	private $buildingName = '';

	private $floor = '';

	private $postBox = '';

	private $room = '';

	private $postCode = '';

	private $townName = '';

	private $townLocationName = '';

	private $districtName = '';

	private $countrySubDivision = '';

	private $country = '';

	private $addressLine = [];
	
	/**
	 * @var ValidatorFactory
	 */
	private $validatorFactory;
	
	/**
	 * Constructor
	 * 
	 * @param ValidatorFactory $validatorFactory
	 */
	public function __construct(ValidatorFactory $validatorFactory)
	{
		$this->validatorFactory = $validatorFactory;
	}

	public function setCountry(string $country) : PostalAddress
	{
		$country = strtoupper($country);
		if (!$country = trim($country))
		{
			throw new PostalAddressException('Country empty', PostalAddressException::COUNTRY_EMPTY);
		}
		if (!$this->validatorFactory->getValidator("CountryCode")->isValid($country))
		{
			throw new PostalAddressException('Country (' . $country . ') invalid', PostalAddressException::COUNTRY_INVALID);
		}
		$this->country = $country;
		
		return $this;
	}
	
	/**
	 * Check necessary postal address data
	 * 
	 * @throws PostalAddressException
	 * @return bool
	 */
	public function validate() : bool
	{
		if ($this->country === '')
		{
			throw new PostalAddressException('Country missing', PostalAddressException::COUNTRY_MISSING);
		}
		return true;
	}
}