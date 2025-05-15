<?php

namespace Vendor\StoreLocator\Block\Widget;

use Zend_Json_Encoder;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Ui\Component\Listing\Column\Cms\Options;
use Magento\Framework\Api\Search\SearchCriteriaBuilderFactory;
use Vendor\StoreLocator\Api\Data\StoreInterface;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Vendor\StoreLocator\Model\Config;

/**
 * @method Map getHeight(): string
 * @method Map getWidth(): string
 * @method Map getDescription(): string
 */
class Store extends Template implements BlockInterface
{
    protected $_template = "widget/store.phtml";

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var Data
     */
    private $configModule;

    private $dataObjectHelper;

    /**
     * @param Context $context
     * @param StoreRepositoryInterface $storeRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param StoreManagerInterface $storeManager
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param Data $dataHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreRepositoryInterface $storeRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        StoreManagerInterface $storeManager,
        FilterGroupBuilder $filterGroupBuilder,
        Config $configModule,
        DataObjectHelper $dataObjectHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
		$this->setTemplate('widget/store.phtml');
        $this->storeRepository = $storeRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->storeManager = $storeManager;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->configModule = $configModule;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @return StoreInterface[]
     * @throws NoSuchEntityException
     */
    public function getStores($country_id, $max_size): array
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();

        $statusFilter = $this->filterBuilder->create()->setConditionType("eq")->setValue(1)->setField(StoreInterface::IS_ACTIVE);
        $allStoreFilter = $this->filterBuilder->create()->setConditionType("like")->setValue($country_id)->setField(StoreInterface::COUNTRY);
        $statusGroupFilter = $this->filterGroupBuilder->addFilter($statusFilter)->create();
        $allStoreGroupFilter = $this->filterGroupBuilder->addFilter($allStoreFilter)->create();

        $searchCriteriaWithFilters = $searchCriteriaBuilder->create()->setFilterGroups([$allStoreGroupFilter, $statusGroupFilter])->setPageSize($max_size);

        $sortOrder = $this->sortOrderBuilder->setField(StoreInterface::NAME)->setDirection(SortOrder::SORT_ASC)->create();

        $searchCriteriaWithFilters->setSortOrders([$sortOrder]);

        return $this->storeRepository->getList($searchCriteriaWithFilters)->getItems();
    }

    /**
     * @return string
     */
    public function getStoresJson(): string
    {
        try {
            $stores = $this->getStores();
        } catch (NoSuchEntityException $e) {
            $stores = [];
        }

        $storesArray = [];
        foreach ($stores as $store) {
            $storesArray[] = $store->toArray();
        }

        return Zend_Json_Encoder::encode($storesArray);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getApiUrl(): string
    {
        return $this->configModule->getApiUrl() . '?key=' . $this->configModule->getApiKey();
    }
	
	public function getModuleConfig(): bool
    {
        return $this->configModule->isModuleEnabled();
    }

    /**
     * @return int
     * @throws NoSuchEntityException
     */
    protected function getStoreId(): int
    {
        return $this->storeManager->getStore()->getId();
    }
}