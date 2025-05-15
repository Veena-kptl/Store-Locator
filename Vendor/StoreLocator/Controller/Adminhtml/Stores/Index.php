<?php
/**
 * Copyright © 2018 Ideo. All rights reserved.
 * @license GPLv3
 */

namespace Vendor\StoreLocator\Controller\Adminhtml\Stores;

use Vendor\StoreLocator\Controller\Adminhtml\Stores;

class Index extends Stores
{
	const ADMIN_RESOURCE = 'Vendor_StoreLocator::admin_store_list';
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Store Locator - Stores'));

        return $resultPage;
    }
}
