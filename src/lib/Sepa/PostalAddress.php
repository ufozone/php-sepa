<?php
declare(strict_types=1);

namespace ufozone\phpsepa\Sepa;

use \ufozone\phpsepa\Sepa\PostalAddress\Exception as PostalAddressException;
use \ufozone\phpsepa\Sepa\Validator\Factory as ValidatorFactory;

/**
 * Postal Address Class
 * 
 * @author  ufozone
 * @since   2025-11-07
 */
class PostalAddress
{
    /**
     * Department
     * @var string
     */
    private string $department = '';

    /**
     * Sub-department
     * @var string
     */
    private string $subDepartment = '';

    /**
     * Street name
     * @var string
     */
    private string $streetName = '';

    /**
     * Building number
     * @var string
     */
    private string $buildingNumber = '';

    /**
     * Building name
     * @var string
     */
    private string $buildingName = '';

    /**
     * Floor
     * @var string
     */
    private string $floor = '';

    /**
     * Post box
     * @var string
     */
    private string $postBox = '';

    /**
     * Room
     * @var string
     */
    private string $room = '';

    /**
     * Post code
     * @var string
     */
    private string $postCode = '';

    /**
     * Town name
     * @var string
     */
    private string $townName = '';

    /**
     * Town location name
     * @var string
     */
    private string $townLocationName = '';

    /**
     * District name
     * @var string
     */
    private string $districtName = '';

    /**
     * Country sub-division
     * @var string
     */
    private string $countrySubDivision = '';

    /**
     * Country
     * @var string
     */
    private string $country = '';

    /**
     * Address lines
     * @var array
     */
    private array $addressLine = [];

    /**
     * @var ValidatorFactory
     */
    private ValidatorFactory $validatorFactory;

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
        if (!$townName = trim($townName))
        {
            throw new PostalAddressException('Town name empty', PostalAddressException::TOWN_NAME_EMPTY);
        }
        $this->townName = $townName;
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
            throw new PostalAddressException('Country ({country}) invalid', PostalAddressException::COUNTRY_INVALID, null, ['country' => $country]);
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
     * Add address line
     * 
     * @param string $addressLine
     * @return PostalAddress
     */
    public function addAddressLine(string $addressLine) : PostalAddress
    {
        if (count($this->addressLine) >= 2)
        {
            throw new PostalAddressException('Address lines exceed maximum of 2', PostalAddressException::ADDRESS_LINES_EXCEED_MAXIMUM);
        }
        $this->addressLine[] = trim($addressLine);
        return $this;
    }

    /**
     * Get address lines
     * 
     * @return array
     */
    public function getAddressLines() : array
    {
        return $this->addressLine;
    }
    
    /**
     * Check necessary postal address data
     * 
     * @throws PostalAddressException
     * @return bool
     */
    public function validate() : bool
    {
        if ($this->townName === '')
        {
            throw new PostalAddressException('Town name missing', PostalAddressException::TOWN_NAME_MISSING);
        }
        if ($this->country === '')
        {
            throw new PostalAddressException('Country missing', PostalAddressException::COUNTRY_MISSING);
        }
        if (count($this->addressLine) > 2)
        {
            throw new PostalAddressException('Address lines exceed maximum of 2', PostalAddressException::ADDRESS_LINES_EXCEED_MAXIMUM);
        }
        return true;
    }
}