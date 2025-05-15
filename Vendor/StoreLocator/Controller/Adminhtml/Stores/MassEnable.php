<?php

namespace Vendor\StoreLocator\Controller\Adminhtml\Stores;

use Vendor\StoreLocator\Controller\Adminhtml\MassAction;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;

class MassEnable extends MassAction
{
	const ADMIN_RESOURCE = 'Vendor_StoreLocator::admin_store_activate';
	
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

        /**
         * @var \Vendor\StoreLocator\Api\Data\StoreInterface $store
         */
        foreach ($collection as $store) {
            $store->setIsActive(true);
            $this->storeRepository->save($store);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 store(s) have been enabled.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
