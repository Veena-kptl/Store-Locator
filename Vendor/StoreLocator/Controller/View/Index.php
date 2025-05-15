<?php
declare(strict_types=1);
/**
 * Limesharp_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Limesharp
 * @package   Limesharp_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Claudiu Creanga
 */

namespace Vendor\StoreLocator\Controller\View;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Vendor\StoreLocator\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Vendor\StoreLocator\Block\StoreList;
use Vendor\StoreLocator\Model\Config;

/**
 * Class Index
 * @package Vendor\StoreLocator\Controller\View
 */
class Index extends Action
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /** @var \Magento\Framework\View\Result\PageFactory  */
    public $resultPageFactory;

    /**
     * @var StoreCollectionFactory
     */
    public $storeCollectionFactory;

    /**
     * Configuration
     *
     * @var Stockists
     */
    protected $moduleConfig;
	
	protected $request;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig,
        StoreCollectionFactory $storeCollectionFactory,
        StoreManagerInterface $storeManager,
		\Magento\Framework\App\Request\Http $request,
        Config $moduleConfig
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeCollectionFactory = $storeCollectionFactory;
        $this->storeManager = $storeManager;
		$this->request = $request;
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * Load the page defined in view/frontend/layout/stockists_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $store_id = $this->request->getParam('store_id');

        $details = $this->getStoreDetails($store_id);
        $allStores = $this->getAllStockistStores();

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getLayout()->getBlock('storelist.stores.individual')->setDetails($details);

        return $resultPage;

    }

    /**
     * return data from the loaded store details. Only the first store is returned if there are multiple urls
     *
     * @return array
     */
    public function getStoreDetails($store_id)
    {
        $collection = $this->getIndividualStore($store_id);
        foreach($collection as $stockist){
            return $stockist->getData();
        }
    }

    /**
     * return data from the loaded store details. Only the first store is returned if there are multiple urls
     *
     * @return array
     */
    public function getAllStockistStores()
    {
        $collection = $this->getAllStoresCollection();
        $data = [];
        foreach($collection as $stockist){
            $data[] = $stockist->getData();
        }
        return $data;
    }

    /**
     * return stockists collection filtered by url
     *
     * @return CollectionFactory
     */
    public function getIndividualStore($store_id)
    {
        $collection = $this->storeCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('is_active', Store::STATUS_ACTIVE)
            ->addFieldToFilter('store_id', $store_id)
            ->setOrder('name', 'ASC');
        return $collection;
    }
	
	public function getAllStoresCollection()
	{
		$collection = $this->storeCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('is_active', Store::STATUS_ACTIVE)
            ->setOrder('name', 'ASC');
        return $collection;
	}

}