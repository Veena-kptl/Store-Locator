<?php

namespace Vendor\StoreLocator\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Magento\Framework\Json\Helper\Data as DataHelper;
use Vendor\StoreLocator\Model\Config as ConfigHelper;
use Vendor\StoreLocator\Api\Data\StoreInterface;
use Vendor\StoreLocator\Model\ResourceModel\Store\Collection as StoreCollection;
use Vendor\StoreLocator\Model\Store;
use Vendor\StoreLocator\Model\Config\Source\GroupBy;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollection;

class StoreList extends Template implements IdentityInterface
{
    /**
     * @var \Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory
     */
    private $storeCollectionFactory;

    /**
     * @var \Vendor\StoreLocator\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $dataHelper;

    /**
     * @var \Vendor\StoreLocator\Helper\Config
     */
    private $configHelper;

    /**
     * @var \Vendor\StoreLocator\Model\Category\Icon
     */
    private $categoryIcon;

    protected $countryCollection;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory $storeCollectionFactory
     * @param \Vendor\StoreLocator\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Framework\Json\Helper\Data $dataHelper
     * @param ConfigHelper $configHelper
     * @param CategoryIcon $categoryIcon
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        StoreCollectionFactory $storeCollectionFactory,
        DataHelper $dataHelper,
        ConfigHelper $configHelper,
        CountryCollection $countryCollection,
        array $data = []
    ) {
        $this->storeCollectionFactory = $storeCollectionFactory;
        $this->dataHelper = $dataHelper;
        $this->configHelper = $configHelper;
        $this->countryCollection = $countryCollection;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        $this->_addBreadcrumbs();

        return parent::_prepareLayout();
    }

    private function _addBreadcrumbs()
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );

            $breadcrumbsBlock->addCrumb(
                'storelocator',
                [
                    'label' => __('Store Locator'),
                ]
            );
        }
    }

   /**
      * return stockists collection
      *
      * @return CollectionFactory
      */
    public function getStoresForFrontend()
    {
        $collection = $this->storeCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('is_active', Store::STATUS_ACTIVE)
            ->setOrder('name', 'ASC');
        return $collection;
    }

    /**
     * Get store identifier
     *
     * @return  string
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
    
    /**
     * get an array of country codes and country names: AF => Afganisthan
     *
     * @return array
     */
    public function getCountries(): array
    {

        /** @var \Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection */
        $countryCollection = $this->countryCollection->create();

        $countryCollection = $countryCollection->toOptionArray();

       return $countryCollection;
    }
    
    /**
     * get media url
     *
     * @return string
     */  
    public function getMediaUrl(): string
    {
	    return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
    }
    /**
     * @return string|null
     */
    public function getGoogleApiKey()
    {
        return $this->configHelper->getApiKey();
    }
	
	public function isModuleEnabled()
	{
		return $this->configHelper->isModuleEnabled();
	}
	
	/**
     * @return string|null
     */
    public function getGoogleApiUrl()
    {
        return $this->configHelper->getApiUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [Store::CACHE_TAG . '_' . 'list'];
    }
}
