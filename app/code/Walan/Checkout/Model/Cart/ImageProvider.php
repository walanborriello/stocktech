<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Walan\Checkout\Model\Cart;

use Magento\Checkout\CustomerData\DefaultItem;
use Magento\Framework\App\ObjectManager;

/**
 * @api
 * @since 100.0.2
 */
class ImageProvider extends \Magento\Checkout\Model\Cart\ImageProvider
{
    protected $productRepository;

    public function __construct(\Magento\Quote\Api\CartItemRepositoryInterface $itemRepository, \Magento\Checkout\CustomerData\ItemPoolInterface $itemPool, DefaultItem $customerDataItem = null,    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ){
        parent::__construct($itemRepository, $itemPool, $customerDataItem);
        $this->productRepository = $productRepository;
    }

    public function getImages($cartId)
    {
        var_dump("ciao");
        $itemData = [];

        /** @see code/Magento/Catalog/Helper/Product.php */
        $items = $this->itemRepository->getList($cartId);
        /** @var \Magento\Quote\Model\Quote\Item $cartItem */
        foreach ($items as $cartItem) {
            $allData = $this->customerDataItem->getItemData($cartItem);
            $product = $this->productRepository->get($allData['sku']);
            $itemData[$cartItem->getItemId()] = $allData['product_image'];
        }
        return $itemData;
    }
}
