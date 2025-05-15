<?php

namespace Vendor\StoreLocator\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Vendor\StoreLocator\Api\StoreRepositoryInterface;
use Vendor\StoreLocator\Api\Data\StoreInterfaceFactory;
use Vendor\StoreLocator\Model\Config as ConfigHelper;

abstract class Stores extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Vendor\StoreLocator\Api\StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @var \Vendor\StoreLocator\Api\Data\StoreInterfaceFactory
     */
    protected $storeFactory;

    /**
     * @var \Vendor\StoreLocator\Helper\Config
     */
    private $configHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Vendor\StoreLocator\Api\StoreRepositoryInterface $storeRepository
     * @param StoreInterfaceFactory $storeFactory
     * @param \Vendor\StoreLocator\Helper\Config $configHelper
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeFactory,
        ConfigHelper $configHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
        $this->configHelper = $configHelper;
        parent::__construct($context);
    }

    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vendor_StoreLocator::stores_list');
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vendor_StoreLocator::stores');
    }
}
