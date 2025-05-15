<?php

namespace Vendor\StoreLocator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Vendor\StoreLocator\Api\Data\StoreInterface;

class Store extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('storelocator_store', StoreInterface::STORE_ID);
    }
}