<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Simple product data view
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */

namespace Walan\Catalog\Block\Product\View;

class Gallery extends \Magento\Catalog\Block\Product\View\Gallery{

    protected $configView;

    protected $jsonEncoder;

    public function getGalleryImages(){
        $product = $this->getProduct();
        $images = $product->getMediaGalleryImages();
        if($images instanceof \Magento\Framework\Data\Collection){
            foreach($images as $image){
                /* @var \Magento\Framework\DataObject $image */
                $image->setData(
                    'small_image_url',
                    $image->getUrl()
                );
                $image->setData(
                    'medium_image_url',
                    $image->getUrl()
                );
                $image->setData(
                    'large_image_url',
                    $image->getUrl()
                );
            }
        }

        return $images;
    }

    public function getGalleryImagesJson(){
        $imagesItems = [];
        foreach($this->getGalleryImages() as $image){
            $main = $image->getData('main');
            $imagesItems[] = [
                'thumb' => $image->getData('small_image_url'),
                'img' => $image->getData('medium_image_url'),
                'full' => $image->getData('large_image_url'),
                'caption' => ($image->getLabel() ?: $this->getProduct()->getName()),
                'position' => $image->getPosition(),
                'isMain' => $main, //$this->isMainImage($image),
                'type' => str_replace('external-', '', $image->getMediaType()),
                'videoUrl' => $image->getVideoUrl(),
            ];
        }
        if(empty($imagesItems)){
            $imagesItems[] = [
                'thumb' => $this->_imageHelper->getDefaultPlaceholderUrl('thumbnail'),
                'img' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'full' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'caption' => '',
                'position' => '0',
                'isMain' => true,
                'type' => 'image',
                'videoUrl' => null,
            ];
        }
        return json_encode($imagesItems);
    }


}
