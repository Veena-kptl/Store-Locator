<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vendor\StoreLocator\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Index extends Action
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;
    
    /** @var \Magento\Framework\View\Result\PageFactory  */
    public $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
    }
    
    /**
     * Load the page defined in view/frontend/layout/stockists_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $pageTitle = "Our Store Location";
        $resultPage->getConfig()->getTitle()->set($pageTitle);
            
            /** @var \Magento\Theme\Block\Html\Breadcrumbs $breadcrumbsBlock */
            $breadcrumbsBlock = $resultPage->getLayout()->getBlock('breadcrumbs');
            if ($breadcrumbsBlock) {
                $breadcrumbsBlock->addCrumb(
                    'home',
                    [
                        'label'    => __('Home'),
                        'link'     => $this->_url->getUrl('')
                    ]
                );
                $breadcrumbsBlock->addCrumb(
                    'stockists',
                    [
                        'label'    => $pageTitle,
                    ]
                );
            }
        
        return $resultPage;

    }

}