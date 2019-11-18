<?php
/**
 * @package Thinkopen
 * @author Paolo
 */

declare(strict_types=1);

namespace Thinkopen\CustomerCustomAttributes\Model\ResourceModel\Sales\Address;

use Thinkopen\CustomerCustomAttributes\Model\Sales\Order\AddressFactory;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\RelationInterface;
use Magento\Sales\Api\Data\OrderAddressInterface;

/**
 * Class used to update order address custom attributes after saving address object.
 */
class Relation implements RelationInterface
{
    /**
     * @var AddressFactory
     */
    private $orderAddressFactory;

    /**
     * @param AddressFactory $orderAddressFactory
     */
    public function __construct(
        AddressFactory $orderAddressFactory
    ) {
        $this->orderAddressFactory = $orderAddressFactory;
    }

    /**
     * Save order address custom attributes.
     *
     * @inheritdoc
     */
    public function processRelation(\Magento\Framework\Model\AbstractModel $orderAddress)
    {
        if ($orderAddress instanceof OrderAddressInterface) {
            /** @var $orderAddressModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Order\Address */
            $orderAddressModel = $this->orderAddressFactory->create();
            $orderAddressModel->saveAttributeData($orderAddress);
        }
    }
}
