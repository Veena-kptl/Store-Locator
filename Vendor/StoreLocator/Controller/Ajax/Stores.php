<?php
declare(strict_types=1);

namespace Vendor\StoreLocator\Controller\Ajax;

use Vendor\StoreLocator\Model\Store as StoresModel;
use Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Responsible for loading page content.
 *
 * This is a basic controller that only loads the corresponding layout file. It may duplicate other such
 * controllers, and thus it is considered tech debt. This code duplication will be resolved in future releases.
 */
class Stores extends \Magento\Framework\App\Action\Action
{
    
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;    
    
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;
    
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }
    
    /**
     * Load the page defined in view/frontend/layout/stockists_index_index.xml
     *
     * @return \Magento\Framework\Controller\Result\JsonFactory
     */
    public function execute()
    {        
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('is_active', StoresModel::STATUS_ACTIVE)
            ->getData();
        $json = [];
        foreach ($collection as $stockist) {
            $json[] = $stockist;
        }
        return  $this->resultJsonFactory->create()->setData($json);
    }
}