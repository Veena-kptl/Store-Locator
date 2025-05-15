<?php
namespace Vendor\StoreLocator\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

use Vendor\StoreLocator\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;

class ListView extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Action\Contex
     */
    private $context;
	
	protected $storeCollectionFactory;

    protected $_urlInterface;

    /**
     * @param \Magento\Framework\App\Action\Context $context
	 * @param StoreCollectionFactory $storeCollectionFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\UrlInterface $urlInterface,  
		StoreCollectionFactory $storeCollectionFactory
    ) {
        parent::__construct($context);
        $this->context           = $context;
        $this->_urlInterface = $urlInterface;
		$this->storeCollectionFactory = $storeCollectionFactory;
    }
    
    /**
     * @return json
     */
    public function execute()
    {
        $whoteData = $this->context->getRequest()->getParams();
		$storeCollection = $this->storeCollectionFactory->create()->addFieldToFilter("country_id",$whoteData['country_id']);
		if($storeCollection->getSize() > 0)
		{
			$html = '<div class="results-store">';

                   foreach ($storeCollection as $item):

                         $data_marker = $item["latitude"].$item["longitude"];

                        $html = $html. '<div class="results-content loaded-results" data-marker="'.$data_marker.'">

                            <div class="results-item-data">

                                <p class="results-title"><a href="'.$this->_urlInterface->getUrl("storelist/view/index").'store_id/'.$item['store_id'].'">'.$item["name"].'</a></p>';

                                if ($item["address"]):
                                   $html = $html. ' <p class="results-address">'.$item["address"].'</p>';
                                 endif;


                                if ($item["country_id"]): 
                                   $html = $html. ' <p class="results-miles">'.$item["country_id"].'</p>';
                                endif;

                           $html = $html. ' </div>';

                        $html = $html. '</div>';

                    endforeach;

                $html = $html. '</div>';

		}
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(["html" => $html, "suceess" => true]);
        return $resultJson;
    }
}