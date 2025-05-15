<?php
/**
 * Copyright © 2018 Ideo. All rights reserved.
 * @license GPLv3
 */

namespace Vendor\StoreLocator\Model;

use Magento\Config\Model\Config\Backend\Admin\Custom;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Encryption\EncryptorInterface;

class Config 
{
		const XML_PATH_ENABLED = 'storelocator/general/enabled';
		const XML_PATH_API_KEY = 'storelocator/general/api_key';
        const XML_PATH_API_URL = 'storelocator/general/api_url';
	/**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;
	
	protected $encryptor;

    private $storeManager;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface $encryptor,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
        $this->storeManager = $storeManager;
    }
	
	 /**
     * @param string $path
     * @param int $storeId
     * @return mixed
     */
    public function getModuleConfig($path, $storeId = null)
    {
        if ($storeId == null)
        {
            /* Get Current Website ID */
            $storeId = $this->storeManager->getStore()->getWebsiteId();
        }
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig(string $path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getFlagConfig(string $path, $storeId = null): bool
    {
        return (bool) $this->scopeConfig->isSetFlag(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isModuleEnabled(): bool
    {
        return (bool) $this->getModuleConfig(self::XML_PATH_ENABLED);
    }


    /**
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->getModuleConfig(self::XML_PATH_API_KEY);
    }

    /**
     * @return string|null
     */
    public function getApiUrl()
    {
        return $this->getModuleConfig(self::XML_PATH_API_URL);
    }
}
