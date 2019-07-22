<?php

namespace Walan\Catalog\Helper;

use Magento\Store\Model\StoreManagerInterface;


class Image extends \Magento\Catalog\Helper\Image{

    private $viewAssetPlaceholderFactory;

    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Catalog\Model\Product\ImageFactory $productImageFactory,
                                \Magento\Framework\View\Asset\Repository $assetRepo,
                                \Magento\Framework\View\ConfigInterface $viewConfig,
                                \Magento\Catalog\Model\View\Asset\PlaceholderFactory $placeholderFactory = null,
                                StoreManagerInterface $storeManager
    ){
        $this->viewAssetPlaceholderFactory = $placeholderFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Catalog\Model\View\Asset\PlaceholderFactory::class);
        parent::__construct($context, $productImageFactory, $assetRepo, $viewConfig, $placeholderFactory);
    }

    public function getUrl(){
        $url = '';
        $imageImport =  $this->_product->getCustomAttribute('image_import');
        if($imageImport) {
            $url = $imageImport->getValue();
        }else {
            try {
                $this->applyScheduledActions();
                return $this->_getModel()->getUrl();
            } catch (\Exception $e) {
                return $this->getDefaultPlaceholderUrl();
            }
        }
        if($url != '' && $this->_checkExistUrl($url)){
            return $url;
        }else{
            return $this->getDefaultPlaceholderUrl();
        }

    }

    private function _checkExistUrl($url){
        $return = false;
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 200){
            $return = true;
        }
        curl_close($handle);
        return $return;
    }


}