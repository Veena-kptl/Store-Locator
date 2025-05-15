<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Vendor\StoreLocator\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\TypeResolverInterface;

/**
 * @inheritdoc
 */
class StoreInterfaceTypeResolver implements TypeResolverInterface
{
    /**
     * @var array
     */
    private $supportedTypes = [];

    /**
     * @param array $supportedTypes
     */
    public function __construct(array $supportedTypes = [])
    {
        $this->supportedTypes = $supportedTypes;
    }

    public function resolveType(array $data) : string
    {
        if (!isset($data['store_id'])) {
            throw new LocalizedException(__('Missing key "store_id" in store data'));
        }
        $productData = $data['store_id'];
        return $data;
    }
}