<?php

use Magento\Framework\App\Bootstrap;
use Magento\Framework\Filesystem\IoInterface;

require __DIR__ . '/app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');
/// Get Website ID
$websiteId = $storeManager->getWebsite()->getWebsiteId();
echo 'websiteId: ' . $websiteId . " ";

/// Get Store ID
$store = $storeManager->getStore();
$storeId = $store->getStoreId();
echo 'storeId: ' . $storeId . " ";

/// Get Root Category ID
$rootNodeId = $store->getRootCategoryId();
echo 'rootNodeId: ' . $rootNodeId . " ";
/// Get Root Category
$rootCat = $objectManager->get('Magento\Catalog\Model\Category');
$cat_info = $rootCat->load($rootNodeId);
$arrResults = ['aaa','bb','c'];
$parentId = $rootNodeId;
$list = array();
foreach ( $arrResults as $import_category ) {
    try {
        $enabled = ( strtolower( $import_category[5] ) == 'true' ) ? 1 : 0;
        $parentId = ( $import_category[1] == 0 )? '2' : $list[$import_category[1]];
        $url = strtolower($import_category[2]);
        $cleanurl = trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($url))))));
        $categoryFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
        /// Add a new sub category under root category

        $category = $categoryFactory->create();
        $category->setName($import_category);
        $category->setIsActive( $enabled );
        $category->setUrlKey($cleanurl);
        $category->setData('description', strip_tags($import_category[10]));
        $category->setParentId($parentId);

        //$mediaAttribute = array ('image', 'small_image', 'thumbnail');
        //$category->setImage( $import_category[6], $mediaAttribute, true, false);// Path pub/meida/catalog/category/
        $category->setStoreId($storeId);
        $rootCat = $objectManager->get('Magento\Catalog\Model\Category')->load($parentId);
        $category->setPath($rootCat->getPath());echo"hi";
        $category->save();echo"hi";
        $list[$import_category[0]] = $category->getId();
        echo 'Category ' . $category->getName() . ' ' . $category->getId() . ' imported successfully' . PHP_EOL;
    }
    catch (Exception $e)
    {
        echo 'Something failed for category ' . $import_category[2] . PHP_EOL;
        print_r($e);
    }
}