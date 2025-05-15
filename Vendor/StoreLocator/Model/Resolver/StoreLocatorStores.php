<?php

declare(strict_types=1);

namespace Vendor\StoreLocator\Model\Resolver;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\DataProvider\SearchResultInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Vendor\StoreLocator\Api\Data\StoreInterface;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Fetches the store locator stores based on the provided criteria.
 */
class StoreLocatorStores implements ResolverInterface
{
    /**
     * @var StoreLocatorStoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param StoreLocatorStoreRepositoryInterface $storeRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        StoreRepositoryInterface $storeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->storeRepository = $storeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $country = $args['country'] ?? null;
        $pageSize = $args['pageSize'] ?? null;
        $currentPage = $args['currentPage'] ?? 1;

        $this->searchCriteriaBuilder->setCurrentPage($currentPage);
        if ($pageSize !== null) {
            $this->searchCriteriaBuilder->setPageSize($pageSize);
        }

        if ($country) {
            $this->searchCriteriaBuilder->addFilter(StoreInterface::COUNTRY, $country);
        }

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->storeRepository->getList($searchCriteria);

        return $this->getStoreLocatorStoreResult($searchResults);
    }

    /**
     * Format the store locator store search result.
     *
     * @param SearchResults $searchResult
     * @return array
     */
    private function getStoreLocatorStoreResult(SearchResults $searchResult): array
    {
        $stores = [];
        foreach ($searchResult->getItems() as $store) {
            $stores[] = $this->getStoreData($store);
        }

        return [
            'items' => $stores,
            'total_count' => $searchResult->getTotalCount(),
            'page_info' => [
                'current_page' => $searchResult->getSearchCriteria()->getCurrentPage(),
                'page_size' => $searchResult->getSearchCriteria()->getPageSize(),
                'total_pages' => ceil($searchResult->getTotalCount() / $searchResult->getSearchCriteria()->getPageSize()),
            ],
        ];
    }

    /**
     * Format individual store data for the GraphQL response.
     *
     * @param StoreInterface $store
     * @return array
     */
    private function getStoreData(array $store): array
    {
        return [
            'name' => $store['name'],
            'address' => $store['address'],
            'country_id' => $store['country_id'],
            'latitude' => $store['latitude'],
            'longitude' => $store['longitude'],
            'phone' => $store['phone']
            // Add other attributes as needed
        ];
    }
}