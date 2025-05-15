<?php
/**
 * Copyright © 2018 Vendor. All rights reserved.
 * @license GPLv3
 */

namespace Vendor\StoreLocator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vendor\StoreLocator\Api\Data\StoreInterface;
use Vendor\StoreLocator\Api\Data\StoreSearchResultsInterface;

/**
 * Interface StoreRepositoryInterface
 * @package Vendor\StoreLocator\Api
 */
interface StoreRepositoryInterface
{
	
	 /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
	
    /**
     * @param int $id
     *
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($id);

    /**
     * @param \Vendor\StoreLocator\Api\Data\StoreInterface $model
     *
     * @return \Vendor\StoreLocator\Api\Data\StoreInterface
     * @throws \Exception
     */
    public function save(StoreInterface $model);

    /**
     * @param \Vendor\StoreLocator\Api\Data\StoreInterface $model
     *
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(StoreInterface $model);

    /**
     * @param int $id
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);
}
