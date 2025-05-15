<?php

namespace Vendor\StoreLocator\Model;

use Magento\Framework\Model\AbstractModel;
use Vendor\StoreLocator\Api\Data\StoreInterface;
use Vendor\StoreLocator\Model\ResourceModel\Store as ResourceModel;

class Store extends AbstractModel implements StoreInterface
{
	const STATUS_ACTIVE = '1';
	const STATUS_INACTIVE = '0';
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sc_store';

    /**
     * Parameter name in event
     * In observe method you can use $observer->getEvent()->getRule() in this case
     *
     * @var string
     */
    protected $_eventObject = 'store';

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel::class);
    }
	
	 /**
     * Prepare store's types.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ACTIVE => __('Enabled'), self::STATUS_INACTIVE => __('Disabled')];
    }
	
	 /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
	{
        return $this->getData(self::STORE_ID);
	}

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName()
	{
        return $this->getData(self::NAME);
	}
	
	/**
     * Get Address    *
     * @return string|null
     */
    public function getAddress()
	{
        return $this->getData(self::ADDRESS);
	}
	
	/**
     * Get Country
     *
     * @return string|null;
     */
    public function getCountryId()
	{
        return $this->getData(self::COUNTRY);
	}
	
	/**
     * Get Phone
     *
     * @return string|null;
     */
    public function getPhone()
	{
        return $this->getData(self::PHONE);
	}
	
	/**
     * Get Longitude
     *
     * @return string|null;
     */
    public function getLongitude()
	{
        return $this->getData(self::LONGITUDE);
	}
	
	/**
     * Get Latitude
     *
     * @return string|null;
     */
    public function getLatitude()
	{
        return $this->getData(self::LATITUDE);
	}
	
	/**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
	{
        return $this->getData(self::NAME);
	}

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
	{
        return $this->getData(self::NAME);
	}
	
	/**
     * Set ID
     *
     * @param int $id
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setId($id)
	{
		 $this->setData(self::STORE_ID, $id);
	}

    /**
     * Set Name
     *
     * @param string $name
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setName($name)
	{
		 $this->setData(self::NAME, $name);
	}

	/**
     * Set update address
     *
     * @param string $address
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setAddress($address)
	{
		 $this->setData(self::ADDRESS, $address);
	}
	
    /**
     * Set country
     *
     * @param string $country
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setCountryId($country)
	{
		 $this->setData(self::COUNTRY, $country);
	}
	
	/**
     * Set Phone
     *
     * @param string $phone
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setPhone($phone)
	{
		 $this->setData(self::PHONE, $phone);
	}
	
	/**
     * Set Latitude
     *
     * @param string $latitude
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setLatitude($latitude)
	{
		 $this->setData(self::LATITUDE, $latitude);
	}
	
	/**
     * Set Longitude
     *
     * @param string $longitude
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setLongitude($longitude)
	{
		 $this->setData(self::LONGITUDE, $longitude);
	}
	
    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setCreationTime($creationTime)
	{
		 $this->setData(self::CREATION_TIME, $creationTime);
	}

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setIsActive($isActive)
	{
		 $this->setData(self::IS_ACTIVE, $isActive);
	}
    
}