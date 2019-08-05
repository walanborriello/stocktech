<?php
/**
 * Created by PhpStorm.
 * User: franco
 * Date: 03/08/19
 * Time: 16:54
 */

declare(strict_types=1);

namespace Walan\Catalog\Block\Product;

use Magento\Catalog\Block\Product\Image as ImageBlock;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Image\ParamsBuilder;
use Magento\Catalog\Model\View\Asset\ImageFactory as AssetImageFactory;
use Magento\Catalog\Model\View\Asset\PlaceholderFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\ConfigInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Helper\ImageFactory as HelperFactory;
use Magento\Framework\View\Asset\Repository;

class ImageFactory extends \Magento\Catalog\Block\Product\ImageFactory{
    private $presentationConfig;
    private $imageParamsBuilder;
    private $viewAssetPlaceholderFactory;
    private $viewAssetImageFactory;
    private $objectManager;
    /**
     * @var HelperFactory
     */
    protected $helperFactory;

    /**
     * @var Repository
     */
    protected $assetRepos;

    public function __construct(ObjectManagerInterface $objectManager, ConfigInterface $presentationConfig, AssetImageFactory $viewAssetImageFactory, PlaceholderFactory $viewAssetPlaceholderFactory, ParamsBuilder $imageParamsBuilder,HelperFactory $helperFactory,
                                Repository $repository){
        parent::__construct($objectManager, $presentationConfig, $viewAssetImageFactory, $viewAssetPlaceholderFactory, $imageParamsBuilder);
        $this->presentationConfig = $presentationConfig;
        $this->imageParamsBuilder = $imageParamsBuilder;
        $this->viewAssetImageFactory = $viewAssetImageFactory;
        $this->viewAssetPlaceholderFactory = $viewAssetPlaceholderFactory;
        $this->objectManager = $objectManager;
        $this->assetRepos = $repository;
        $this->helperFactory = $helperFactory;
    }

    public function create(Product $product, string $imageId, array $attributes = null) :ImageBlock{
        $viewImageConfig = $this->presentationConfig->getViewConfig()->getMediaAttributes(
            'Magento_Catalog',
            ImageHelper::MEDIA_TYPE_CONFIG_NODE,
            $imageId
        );

        $imageMiscParams = $this->imageParamsBuilder->build($viewImageConfig);
        $originalFilePath = $product->getData($imageMiscParams['image_type']);

        if($originalFilePath === null || $originalFilePath === 'no_selection'){
            $imageAsset = $this->viewAssetPlaceholderFactory->create(
                [
                    'type' => $imageMiscParams['image_type']
                ]
            );
        }else{
            $imageAsset = $this->viewAssetImageFactory->create(
                [
                    'miscParams' => $imageMiscParams,
                    'filePath' => $originalFilePath,
                ]
            );
        }

        $data = [
            'data' => [
                'template' => 'Magento_Catalog::product/image_with_borders.phtml',
                'image_url' => $this->getImageUrlImported($product, $imageAsset),
                'width' => $imageMiscParams['image_width'],
                'height' => $imageMiscParams['image_height'],
                'label' => $this->getLabel($product, $imageMiscParams['image_type']),
                'ratio' => $this->getRatio($imageMiscParams['image_width'], $imageMiscParams['image_height']),
                'custom_attributes' => $this->getStringCustomAttributes($attributes),
                'class' => $this->getClass($attributes),
                'product_id' => $product->getId()
            ],
        ];

        return $this->objectManager->create(ImageBlock::class, $data);
    }

    private function getLabel(Product $product, string $imageType) :string{
        $label = $product->getData($imageType . '_' . 'label');
        if(empty($label)){
            $label = $product->getName();
        }
        return (string)$label;
    }

    private function getClass(array $attributes) :string{
        return $attributes['class'] ?? 'product-image-photo';
    }

    private function getRatio(int $width, int $height) :float{
        if($width && $height){
            return $height / $width;
        }
        return 1.0;
    }

    private function getStringCustomAttributes(array $attributes) :string{
        $result = [];
        foreach($attributes as $name => $value){
            if($name != 'class'){
                $result[] = $name . '="' . $value . '"';
            }
        }
        return !empty($result) ? implode(' ', $result) : '';
    }

    protected function getImageUrlImported($product, $imageAsset){
        if($this->_checkExistUrl($product->getImageImport())){
            $url = $product->getImageImport();
        }else {
            $url = $this->getPlaceHolderImage();
        }
        return $url;
    }

    public function getPlaceHolderImage()
    {
        /** @var \Magento\Catalog\Helper\Image $helper */
        $helper = $this->helperFactory->create();
        return $this->assetRepos->getUrl($helper->getPlaceholder('small_image'));
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