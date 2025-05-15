<?php

namespace Vendor\StoreLocator\Model\Repository;

use Exception;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Model\AbstractModel;
use Vendor\StoreLocator\Api\Data\StoreInterface;
use Vendor\StoreLocator\Api\Data\StoreSearchResultsInterface;
use Vendor\StoreLocator\Api\Data\StoreSearchResultsInterfaceFactory as SearchResultFactory;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Vendor\StoreLocator\Model\ResourceModel\Store\Collection;
use Vendor\StoreLocator\Model\StoreFactory as StoreFactory;
use Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Vendor\StoreLocator\Model\ResourceModel\Store as StoreResource;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Reflection\DataObjectProcessor;

class StoreRepository implements StoreRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @var SearchResultFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var JoinProcessorInterface
     */
    private $joinProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var storeFactory
     */
    private $storeFactory;

    /**
     * @var storeResource
     */
    private $storeResource;
	
	protected $dataObjectHelper;

    /**
     * @param SearchResultFactory $searchResultFactory
     * @param CollectionFactory $collectionFactory
     * @param JoinProcessorInterface $joinProcessor
     * @param CollectionProcessorInterface $collectionProcessor
     * @param storeFactory $storeFactory
     * @param storeResource $storeResource
     */
    public function __construct(
        SearchResultFactory $searchResultFactory,
        CollectionFactory $collectionFactory,
        JoinProcessorInterface $joinProcessor,
        CollectionProcessorInterface $collectionProcessor,
        StoreFactory $storeFactory,
		DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreResource $storeResource
    ) {
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionFactory = $collectionFactory;
        $this->joinProcessor = $joinProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->storeFactory = $storeFactory;
		$this->dataObjectHelper = $dataObjectHelper;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeResource = $storeResource;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (!isset($this->instances[$id])) {
            $model = $this->storeFactory->create();

            $model->load($id);

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('store_id', $id);
            }

            $this->instances[$id] = $model;
        }

        return $this->instances[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return storeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var StoreSearchResultsInterface $searchResult */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

         $collection = $this->collectionFactory->create();
        /** @var Collection $collection */
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrdersData = $searchCriteria->getSortOrders();
        if ($sortOrdersData) {
            foreach ($sortOrdersData as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        
        $storeItem = [];
        /** @var Store $storeModel */
        foreach ($collection as $storeModel) {
            $storeData = $this->storeFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $storeData,
                $storeModel->getData(),
                'Vendor\StoreLocator\Api\Data\StoreInterface'
            );
            $storeItem[] = $this->dataObjectProcessor->buildOutputDataArray(
                $storeData,
                'Vendor\StoreLocator\Api\Data\StoreInterface'
            );
        }
        $searchResults->setItems($storeItem);
        return $searchResults;
    }

    /**
     * @param StoreInterface $store
     * @return storeInterface
     * @throws LocalizedException
     */
    public function save(StoreInterface $store)
    {
        /** @var storeInterface|AbstractModel $store */
        try {
            $this->storeResource->save($store);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the dynamics Customer: %1', $exception->getMessage()));
        }

        return $store;
    }

    /**
     * @param int $id
     * @return storeInterface
     * @throws LocalizedException
     */
    public function getById($id)
    {
        if (!isset($this->_instances[$id])) {
            /** @var storeInterface|AbstractModel $store */
            $store = $this->storeFactory->create();
            $this->storeResource->load($store, $id);
            if (!$store->getId()) {
                throw new NoSuchEntityException(__('dynamics Customer does not exist'));
            }
            $this->instances[$id] = $store;
        }

        return $this->instances[$id];
    }

    /**
     * @param StoreInterface $store
     * @return bool
     * @throws LocalizedException
     */
    public function delete(StoreInterface $store)
    {
        /** @var storeInterface|AbstractModel $store */
        $id = $store->getId();
        try {
            unset($this->instances[$id]);
            $this->storeResource->delete($store);
        } catch (Exception $e) {
            throw new StateException(__('Unable to remove dynamics Customer %1', $id));
        }
        unset($this->instances[$id]);

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws LocalizedException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}