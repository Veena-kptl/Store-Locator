<?php
/**
 * Copyright © 2018 Ideo. All rights reserved.
 * @license GPLv3
 */

namespace Vendor\StoreLocator\Controller\Adminhtml\Stores;

use Vendor\StoreLocator\Controller\Adminhtml\MassAction;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;

class MassDelete extends MassAction
{
	const ADMIN_RESOURCE = 'Vendor_StoreLocator::admin_store_delete';
	
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->storeCollectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $this->storeRepository->delete($item);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 store(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
