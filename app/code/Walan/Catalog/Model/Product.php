<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Walan\Catalog\Model;

class Product extends \Magento\Catalog\Model\Product{

    public function getMediaGalleryImages(){
        $imageImport = $this->getCustomAttributes('image_import');
        if($imageImport){
            $url = $imageImport->getValue();
            if($url && $this->_checkExistUrl($url)){
                $images = $this->_collectionFactory->create();
                $image['url'] = $url;
                $image['id'] = rand(1, 300);
                $image['path'] = $url;
                $image['main'] = true;
                $images->addItem(new \Magento\Framework\DataObject($image));
            }
            $this->setData('media_gallery_images', $images);
            return $this->getData('media_gallery_images');
        }else{
            $this->getMediaGalleryImagesStandard();
        }
    }


    public function getMediaGalleryImagesStandard(){
        $directory = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
        if(!$this->hasData('media_gallery_images')){
            $this->setData('media_gallery_images', $this->_collectionFactory->create());
        }
        if(!$this->getData('media_gallery_images')->count() && is_array($this->getMediaGallery('images'))){
            $images = $this->getData('media_gallery_images');
            foreach($this->getMediaGallery('images') as $image){
                if(!empty($image['disabled'])
                    || !empty($image['removed'])
                    || empty($image['value_id'])
                    || $images->getItemById($image['value_id']) != null
                ){
                    continue;
                }
                $image['url'] = $this->getMediaConfig()->getMediaUrl($image['file']);
                $image['id'] = $image['value_id'];
                $image['path'] = $directory->getAbsolutePath($this->getMediaConfig()->getMediaPath($image['file']));
                $images->addItem(new \Magento\Framework\DataObject($image));
            }
            $this->setData('media_gallery_images', $images);
        }

        return $this->getData('media_gallery_images');
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
