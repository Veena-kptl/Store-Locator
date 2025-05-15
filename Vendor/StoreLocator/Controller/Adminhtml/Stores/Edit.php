<?php
/**
 * Copyright © 2018 Ideo. All rights reserved.
 * @license GPLv3
 */

namespace Vendor\StoreLocator\Controller\Adminhtml\Stores;

use Vendor\StoreLocator\Controller\Adminhtml\Stores;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Vendor\StoreLocator\Model\Config as ConfigHelper;
use Magento\Framework\Registry;
use Vendor\StoreLocator\Api\Data\StoreInterfaceFactory;

class Edit extends Stores
{
	const ADMIN_RESOURCE = 'Vendor_StoreLocator::admin_store_edit';
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreInterfaceFactory $storeFactory
     * @param \Vendor\StoreLocator\Helper\Config $configHelper
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper,
        Registry $registry
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $resultPageFactory, $storeRepository, $storeFactory, $configHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {

        $id = $this->getRequest()->getParam('store_id');
        $store = $this->storeFactory->create();

        if ($id) {
            try {
                $store = $this->storeRepository->get($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $store->setData($data);
        }

        $this->coreRegistry->register('storelocator_store', $store);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Store') : __('Add New Store'),
            $id ? __('Edit Store') : __('Add New Store')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Storelocator Stores'));
        $resultPage->getConfig()->getTitle()
            ->prepend($store->getId() ? $store->getName() : __('Add New Store'));

        return $resultPage;
    }
}
