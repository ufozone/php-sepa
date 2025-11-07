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

	/**
	 * Set department
	 * 
	 * @param string $department
	 * @return PostalAddress
	 */
	public function setDepartment(string $department) : PostalAddress
	{
		$this->department = trim($department);
		return $this;
	}

	/**
	 * Get department
	 * 
	 * @return string
	 */
	public function getDepartment() : string
	{
		return $this->department;
	}

	/**
	 * Set sub-department
	 * 
	 * @param string $subDepartment
	 * @return PostalAddress
	 */
	public function setSubDepartment(string $subDepartment) : PostalAddress
	{
		$this->subDepartment = trim($subDepartment);
		return $this;
	}

	/**
	 * Get sub-department
	 * 
	 * @return string
	 */
	public function getSubDepartment() : string
	{
		return $this->subDepartment;
	}

	/**
	 * Set street name
	 * 
	 * @param string $streetName
	 * @return PostalAddress
	 */
	public function setStreetName(string $streetName) : PostalAddress
	{
		$this->streetName = trim($streetName);
		return $this;
	}

	/**
	 * Get street name
	 * 
	 * @return string
	 */
	public function getStreetName() : string
	{
		return $this->streetName;
	}

	/**
	 * Set building number
	 * 
	 * @param string $buildingNumber
	 * @return PostalAddress
	 */
	public function setBuildingNumber(string $buildingNumber) : PostalAddress
	{
		$this->buildingNumber = trim($buildingNumber);
		return $this;
	}

	/**
	 * Get building number
	 * 
	 * @return string
	 */
	public function getBuildingNumber() : string
	{
		return $this->buildingNumber;
	}

	/**
	 * Set building name
	 * 
	 * @param string $buildingName
	 * @return PostalAddress
	 */
	public function setBuildingName(string $buildingName) : PostalAddress
	{
		$this->buildingName = trim($buildingName);
		return $this;
	}

	/**
	 * Get building name
	 * 
	 * @return string
	 */
	public function getBuildingName() : string
	{
		return $this->buildingName;
	}

	/**
	 * Set floor
	 * 
	 * @param string $floor
	 * @return PostalAddress
	 */
	public function setFloor(string $floor) : PostalAddress
	{
		$this->floor = trim($floor);
		return $this;
	}

	/**
	 * Get floor
	 * 
	 * @return string
	 */
	public function getFloor() : string
	{
		return $this->floor;
	}

	/**
	 * Set post box
	 * 
	 * @param string $postBox
	 * @return PostalAddress
	 */
	public function setPostBox(string $postBox) : PostalAddress
	{
		$this->postBox = trim($postBox);
		return $this;
	}

	/**
	 * Get post box
	 * 
	 * @return string
	 */
	public function getPostBox() : string
	{
		return $this->postBox;
	}

	/**
	 * Set room
	 * 
	 * @param string $room
	 * @return PostalAddress
	 */
	public function setRoom(string $room) : PostalAddress
	{
		$this->room = trim($room);
		return $this;
	}

	/**
	 * Get room
	 * 
	 * @return string
	 */
	public function getRoom() : string
	{
		return $this->room;
	}

	/**
	 * Set post code
	 * 
	 * @param string $postCode
	 * @return PostalAddress
	 */
	public function setPostCode(string $postCode) : PostalAddress
	{
		$this->postCode = trim($postCode);
		return $this;
	}

	/**
	 * Get post code
	 * 
	 * @return string
	 */
	public function getPostCode() : string
	{
		return $this->postCode;
	}

	/**
	 * Set town name
	 * 
	 * @param string $townName
	 * @return PostalAddress
	 */
	public function setTownName(string $townName) : PostalAddress
	{
		$this->townName = trim($townName);
		return $this;
	}

	/**
	 * Get town name
	 * 
	 * @return string
	 */
	public function getTownName() : string
	{
		return $this->townName;
	}

	/**
	 * Set town location name
	 * 
	 * @param string $townLocationName
	 * @return PostalAddress
	 */
	public function setTownLocationName(string $townLocationName) : PostalAddress
	{
		$this->townLocationName = trim($townLocationName);
		return $this;
	}

	/**
	 * Get town location name
	 * 
	 * @return string
	 */
	public function getTownLocationName() : string
	{
		return $this->townLocationName;
	}

	/**
	 * Set district name
	 * 
	 * @param string $districtName
	 * @return PostalAddress
	 */
	public function setDistrictName(string $districtName) : PostalAddress
	{
		$this->districtName = trim($districtName);
		return $this;
	}

	/**
	 * Get district name
	 * 
	 * @return string
	 */
	public function getDistrictName() : string
	{
		return $this->districtName;
	}

	/**
	 * Set country sub-division
	 * 
	 * @param string $countrySubDivision
	 * @return PostalAddress
	 */
	public function setCountrySubDivision(string $countrySubDivision) : PostalAddress
	{
		$this->countrySubDivision = trim($countrySubDivision);
		return $this;
	}

	/**
	 * Get country sub-division
	 * 
	 * @return string
	 */
	public function getCountrySubDivision() : string
	{
		return $this->countrySubDivision;
	}

	/**
	 * Set country
	 * 
	 * @param string $country
	 * @throws PostalAddressException
	 * @return PostalAddress
	 */
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
	 * Get country
	 * 
	 * @return string
	 */
	public function getCountry() : string
	{
		return $this->country;
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