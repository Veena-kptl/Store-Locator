<?php

namespace Vendor\StoreLocator\Controller\Adminhtml\Stores;

use Vendor\StoreLocator\Controller\Adminhtml\Stores;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Vendor\StoreLocator\Model\Config as ConfigHelper;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Vendor\StoreLocator\Api\Data\StoreInterfaceFactory;

class NewAction extends Stores
{
	const ADMIN_RESOURCE = 'Vendor_StoreLocator::admin_store_new';
    /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    protected $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Vendor\StoreLocator\Api\StoreRepositoryInterface $storeRepository
     * @param StoreInterfaceFactory $storeFactory
     * @param \Vendor\StoreLocator\Helper\Config $configHelper
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $resultPageFactory, $storeRepository, $storeFactory, $configHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($error = $this->checkGoogleApiKey()) {
            return $error;
        }
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
