<?php

namespace Vendor\StoreLocator\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class AddData implements DataPatchInterface
{
     private $storeFactory;

     public function __construct(
          \Vendor\StoreLocator\Model\StoreFactory $storeFactory
     ) {
          $this->storeFactory = $storeFactory;
     }

     public function apply()
     {
          $sampleData = [
               [
                    'is_active' => 1, 
                    'name' => 'Ahmedabad Store', 
                    'address' => 'Sarkhej - Gandhinagar Hwy, Thaltej, Ahmedabad, Gujarat 380054',
					'country_id' => 'IN',
					'phone' => '079 6979 4200',
					'latitude' => '23.0575828',
					'longitude' => '72.5182695'
               ],
               [
                    'is_active' => 1, 
                    'name' => 'Bombay Store', 
                    'address' => '462, Senapati Bapat Marg, Lower Parel, Mumbai, Maharashtra 400013',
					'country_id' => 'IN',
					'phone' => '079 6979 4200',
					'latitude' => '18.994657',
					'longitude' => '72.8244225'
               ],
			   [
                    'is_active' => 1, 
                    'name' => 'Pune Store', 
                    'address' => 'HWX2+6QR, Unnamed Road, Madhav Nagar, Dhanori, Pune, Maharashtra 411015',
					'country_id' => 'IN',
					'phone' => '079 6979 4200',
					'latitude' => '18.5994711',
					'longitude' => '73.8964575'
               ],
			   [
                    'is_active' => 1, 
                    'name' => 'Dubai Store', 
                    'address' => ' Al Khail Rd - Dubai - United Arab Emirates',
					'country_id' => 'AE',
					'phone' => '+971 4 352 2816',
					'latitude' => '25.1374298',
					'longitude' => '55.257565'
               ],
			   [
                    'is_active' => 1, 
                    'name' => 'Malaysia Store', 
                    'address' => "01-33, Blk A, Pusat Perdagangan Ekoflora, Jln Ekoflora 7/3, Taman Ekoflora, 81100 Johor Bahru, Johor Darul Ta'zim",
					'country_id' => 'ML',
					'phone' => '+60183634862',
					'latitude' => '1.5879296',
					'longitude' => '103.7553718'
               ]
          ];
          foreach ($sampleData as $data) {
               $this->storeFactory->create()->setData($data)->save();
          }
     }

     public static function getDependencies()
     {
          return [];
     }

     public function getAliases()
     {
          return [];
     }
     
}