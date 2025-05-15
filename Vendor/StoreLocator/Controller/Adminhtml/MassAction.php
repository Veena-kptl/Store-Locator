<?php
/**
 * Copyright © 2018 Ideo. All rights reserved.
 * @license GPLv3
 */

namespace Vendor\StoreLocator\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
abstract class MassAction extends Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory
     */
    protected $storeCollectionFactory;

    /**
     * @var \Vendor\StoreLocator\Api\StoreRepositoryInterface
     */
    protected $storeRepository;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param StoreCollectionFactory $storeCollectionFactory
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param \Vendor\StoreLocator\Api\StoreRepositoryInterface $storeRepository
     * @internal param StoreCollectionFactory $collectionFactory
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        StoreCollectionFactory $storeCollectionFactory,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->filter = $filter;
        $this->storeCollectionFactory = $storeCollectionFactory;
        $this->storeRepository = $storeRepository;
        parent::__construct($context);
    }
}
