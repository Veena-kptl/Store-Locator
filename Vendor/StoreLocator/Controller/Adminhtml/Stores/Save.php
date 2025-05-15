<?php

namespace Vendor\StoreLocator\Controller\Adminhtml\Stores;

use Vendor\StoreLocator\Controller\Adminhtml\Stores;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Vendor\StoreLocator\Model\Config as ConfigHelper;
use Vendor\StoreLocator\Model\Config;
use Magento\Framework\App\Cache\TypeListInterface;
use Vendor\StoreLocator\Api\Data\StoreInterfaceFactory;

class Save extends Stores
{
	const ADMIN_RESOURCE = 'Vendor_StoreLocator::admin_store_edit';
    /**
     * @var \Vendor\StoreLocator\Model\Config
     */
    private $config;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    private $typeList;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreInterfaceFactory $storeFactory
     * @param ConfigHelper $configHelper
     * @param Config $config
     * @param TypeListInterface $typeList
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper,
        Config $config,
        TypeListInterface $typeList
    ) {
        $this->config = $config;
        $this->typeList = $typeList;
        parent::__construct($context, $resultPageFactory, $storeRepository, $storeFactory, $configHelper);
    }

    /**
     * Save store
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if ($this->config->isModuleEnabled()) {
            $this->typeList->invalidate('full_page');
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
			if($data['store_id'])
			{
				$store=$this->storeRepository->get($data['store_id']);
				$store->setName($data['name']);
				$store->setAddress($data['address']);
				$store->setCountryId($data['country_id']);
				$store->setPhone($data['phone']);
				$store->setLatitude($data['latitude']);
				$store->setLongitude($data['longitude']);
				$store->setIsActive($data['is_active']);
			}
			else
			{
				$store = $this->storeFactory->create();
				$store->setName($data['name']);
				$store->setAddress($data['address']);
				$store->setCountryId($data['country_id']);
				$store->setPhone($data['phone']);
				$store->setLatitude($data['latitude']);
				$store->setLongitude($data['longitude']);
				$store->setIsActive($data['is_active']);
			}

				$this->_eventManager->dispatch(
					'storelocator_store_prepare_save',
					['store' => $store, 'request' => $this->getRequest()]
				);

            try {
                $this->storeRepository->save($store);

                $this->messageManager->addSuccessMessage(__('The store has been saved.'));
                $this->_getSession()->setFormData(false);

                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['store_id' => $store->getId(), '_current' => true, 'active_tab' => 'store_info']);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the store.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['store_id' => $this->getRequest()->getParam('store_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }
}
