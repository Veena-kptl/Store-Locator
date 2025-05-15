<?php

namespace Vendor\StoreLocator\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoreSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get list.
     *
     * @return StoreInterface[]
     */
    public function getItems();

    /**
     * Set list.
     *
     * @param StoreInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}