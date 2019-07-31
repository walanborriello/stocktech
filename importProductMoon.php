<?php

/*
 * Please insert import_address_shipping.csv in var/import/address
 *
 */

use Exception;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\Filesystem\IoInterface;

require __DIR__ . '/app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);

ini_set('display_errors', 1);
umask(0);

set_time_limit(0);
ini_set('memory_limit', '1024M');

function is_cli(){
    return php_sapi_name() === 'cli';
}

if(!is_cli()){
    die("Forbidden in HTTP mode");
}


$file = 'moonfile.csv';
echo "Copying file: $file";
echo "\n";


$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');


$customer = null;
$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
$customer = $objectManager->get(\Magento\Customer\Api\CustomerRepositoryInterface::class);
echo $rootPath = $directory->getPath('var') . "/import/" . $file;

$_productRepo = $objectManager->create('\Magento\Catalog\Api\ProductRepositoryInterface');

$row = 1;
$countcat = 0;
try{
    if(($handle = fopen($rootPath, "r")) !== FALSE){
        while(($data = fgetcsv($handle, 1000, "|")) !== FALSE){
            if($row > 1){
                if($return = getProductArray($objectManager, $data)){
                    $products[] = $return;
                }
                if($returnCat = getCategoriesArray($data)){
                    $categories[] = $returnCat;
                    $countcat++;
                }
            }
            $row++;
        }


        echo "\n";
    }
}catch(\Exception $e){

}finally{
    fclose($handle);
}

/**
 * IMPORTA CATEGORIE MA RICORDATI DI COMMENTARE IMPORT PRODOTTI
 */
echo "CREA CATEGORIE -> START" . PHP_EOL;
foreach(array_unique($categories) as $el){
    $cat = explode('/', $el);
    $level = 1;
    $id = 2;

    foreach($cat as $item){
        $id = createCategories($objectManager, $item, $level, $id);
        $level++;
    }
}
echo "CREA CATEGORIE -> END" . PHP_EOL;

$countProd = 0;
/**
 *
 * IMPORTA I PRODOTTI SE SCOMMENTI MA RICORDA DI COMMENTARE IMPORT CATEGORIA
 * @param $objectManager
 * @param $data
 */
echo "CREA PRODOTTI -> START" . PHP_EOL;
foreach($products as $data){
    if(isset($data['sku']) && strlen($data['sku']) > 0){
        try{
            $prod = $_productRepo->get($data['sku']);
            createUpdateProduct($objectManager, $data, $prod->getId());
            echo "AGGIORNATO -> " . $data['sku'] . PHP_EOL;
        }catch(Exception $e){
            createUpdateProduct($objectManager, $data);
            echo 'IMPORTATO -> ' . $data['sku'] . PHP_EOL;
        }
    }
    $countProd++;
}
echo "CREA PRODOTTI -> END - TOTALE PRODOTTI CARICATI: " . $countProd . PHP_EOL;


function getCategoryId($objectManager, $catName){
    $id = null;
    $category = $objectManager->create('Magento\Catalog\Model\Category');
    $cate = $category->getCollection()->addAttributeToFilter('name', $catName)->getFirstItem();
    if($cate->getId()){
        $id = $cate->getId();
    }

    return $id;
}


function createCategories($objectManager, $catName, $level, $parentId){
    $url = \Magento\Framework\App\ObjectManager::getInstance();
    $storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
    /// Get Website ID
    $websiteId = $storeManager->getWebsite()->getWebsiteId();

    /// Get Store ID
    $store = $storeManager->getStore();
    $storeId = $store->getStoreId();

    $leve1Id = null;
    $leve2Id = null;
    $category = $objectManager->create('Magento\Catalog\Model\Category');
    if($level == 1){
        $cate = $category->getCollection()->addAttributeToFilter('name', $catName)->getFirstItem();
        if(!$cate->getId()){
            $id = createCat($objectManager, $catName, 2, $storeId);
        }else{
            $id = $cate->getId();
        }
    }else{
        $cate = $category->getCollection()->addAttributeToFilter('name', $catName)->getFirstItem();
        if(!$cate->getId()){
            $id = createCat($objectManager, $catName, $parentId, $storeId);
        }else{
            $id = $cate->getId();
        }
    }

    return $id;
}

function createCat($objMng, $catName, $parentId, $storeId){
    $categoryFactory = $objMng->get('\Magento\Catalog\Model\CategoryFactory');
    $category = $categoryFactory->create();
    $category->setName($catName);
    $category->setIsActive(1);
    $category->setUrlKey(strtolower($catName));
    $category->setParentId($parentId);
    $category->setStoreId($storeId);
    $rootCat = $objMng->get('Magento\Catalog\Model\Category')->load($parentId);
    $category->setPath($rootCat->getPath());
    $category->save();
    return $category->getId();
}


function createUpdateProduct($objectManager, $data, $prodId = null){
    $_product = $objectManager->create('Magento\Catalog\Model\Product');
    if($prodId){
        $_product = $_product->load($prodId);
    }else{
        $_product->setSku($data['sku']);
    }
    $_product->setName($data['name']);
    $_product->setStatus(true);
    $_product->setBrand($data['brand']);
    $_product->setTypeId('simple');
    $_product->setVisibility(4);
    $_product->setWebsiteIds(array(1));
    $_product->setAttributeSetId(4);
    $_product->setUrlKey(strtolower(strtolower($data['name']) . '-' . $data['sku']));
    if(strlen($data['image']) > 0){
        $_product->setImageImport($data['image']);
        $_product->setImage($data['image']);
        $_product->setSmallImage($data['image']);
        $_product->setThumbnail($data['image']);
    }
    if(count($data['category']) > 0){
        $_product->setCategoryIds($data['category']);
    }

    $percentuale = getGuadagno($data['category']);
    $price = $data['price'] + ($data['price'] * $percentuale / 100);
    if(strlen($data['price']) > 0){
        $_product->setData('price', $price);
    }

    $availability = 1;
    $manage_stock = 1;
    if($data['stock'] == 0){
        $manage_stock = 0;
        $stock = 0;
        $availability = 0;
    }else{
        $stock = $data['stock'];
    }

    $_product->setStockData(array(
            'use_config_manage_stock' => 0, //'Use config settings' checkbox
            'manage_stock' => $manage_stock, //manage stock
            'is_in_stock' => $availability, //Stock Availability
            'qty' => $stock,
        )
    );

    try{
        $_product->save();

    }catch(\Exception $e){
        echo $e->getMessage();
    }
}

function getCategoriesArray($data){
    $return = null;
    if(isset($data['1']) && $data['1'] != '8056040382134'){
        $sku = isset($data['1']) ? $data['1'] : null;
        $name = isset($data['5']) ? $data['5'] : null;
        $price = isset($data['11']) ? trim($data['11']) : null;
        if(isset($data['8'])){
            $category = calculateCategory($data['8']);
        }

        if($sku && $price && $category && $name){
            $return = $category;
        }
        return $return;
    }
}

function getProductArray($obj, $data){
    $return = null;
    if(isset($data['1']) && $data['1'] != '8056040382134'){
        $sku = isset($data['1']) ? $data['1'] : null;
        $name = isset($data['5']) ? $data['5'] : null;
        $description = isset($data['6']) ? strip_tags($data['6']) : null;
        $brand = isset($data['9']) ? $data['9'] : null;
        $price = isset($data['11']) ? trim($data['11']) : null;
        $stock = isset($data['12']) ? $data['12'] : 0;
        $image = isset($data['13']) ? $data['13'] : null;
        if(isset($data['8'])){
            $category = getCategories($obj, $data['8']);
        }else{
            $category = null;
        }

        if($sku && $price && $category && $name){
            $return = ['name' => $name, 'description' => $description, 'price' => $price,
                'stock' => $stock,
                'brand' => $brand, 'sku' => $sku, 'category' => $category, 'image' => $image];
        }
        return $return;
    }
}

function getCategories($obj, $data){
    $categories = null;
    $catNames = explode(' > ', $data);
    foreach($catNames as $catName){
        if($cat = getCategoryId($obj, $catName)){
            $categories[] = (int)$cat;
        }
    }
    return $categories;
}


function calculateCategory($category){
    $categoria = str_replace(' > ', '/', $category);

    return $categoria;
}

function getGuadagno($categoria){
    $return = 30;
    if(in_array('ACCESSORI PER INFORMATICA', $categoria)){
        $return = 20;
    }

    if(in_array('TELEFONIA', $categoria)){
        $return = 20;
    }

    if(in_array('INFORMATICA', $categoria) && in_array('COMPONENTISTICA', $categoria)){
        $return = 20;
    }

    if(in_array('INFORMATICA', $categoria) && in_array('SOFTWARE', $categoria)){
        $return = 20;
    }
    return $return;
}
