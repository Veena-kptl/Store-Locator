<?php

namespace Vendor\StoreLocator\Api\Data;

interface StoreInterface
{
	const STORE_ID = 'store_id';
    const NAME = 'name';
	const ADDRESS = 'address';
    const COUNTRY = 'country_id';
	const PHONE = 'phone';
	const LATITUDE = 'latitude';
	const LONGITUDE = 'longitude';
    const CREATION_TIME = 'created_at';
    const IS_ACTIVE = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName();
	
	/**
     * Get Address    *
     * @return string|null
     */
    public function getAddress();

    /**
     * Get Country
     *
     * @return string|null;
     */
    public function getCountryId();
	
	/**
     * Get Phone
     *
     * @return string|null;
     */
    public function getPhone();
	
	/**
     * Get Longitude
     *
     * @return string|null;
     */
    public function getLongitude();
	
	/**
     * Get Latitude
     *
     * @return string|null;
     */
    public function getLatitude();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setId($id);

    /**
     * Set Name
     *
     * @param string $name
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setName($name);

    /**
     * Set country
     *
     * @param string $country
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setCountryId($country);
	
	/**
     * Set Phone
     *
     * @param string $phone
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setPhone($phone);
	
	/**
     * Set Latitude
     *
     * @param string $latitude
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setLatitude($latitude);
	
	/**
     * Set Longitude
     *
     * @param string $longitude
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setLongitude($longitude);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update address
     *
     * @param string $address
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setAddress($address);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     */
    public function setIsActive($isActive);
}
