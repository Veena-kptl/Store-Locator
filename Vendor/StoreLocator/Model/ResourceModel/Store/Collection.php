<?php

namespace Vendor\StoreLocator\Model\ResourceModel\Store;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vendor\StoreLocator\Model\Store as Model;
use Vendor\StoreLocator\Model\ResourceModel\Store as ResourceModel;
use Vendor\StoreLocator\Api\Data\StoreInterface;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = StoreInterface::STORE_ID;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}