<?php
/**
 * @package Thinkopen
 * @author Paolo
 */
declare(strict_types=1);

namespace Thinkopen\CustomerCustomAttributes\Model\Quote;

use Thinkopen\CustomerCustomAttributes\Model\Sales\QuoteFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\RelationInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Persist relation between quote and user defined customer custom attributes.
 */
class Relation implements RelationInterface
{
    /**
     * @var QuoteFactory
     */
    private $quoteFactory;

    /**
     * @param QuoteFactory $quoteFactory
     */
    public function __construct(
        QuoteFactory $quoteFactory
    ) {
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function processRelation(AbstractModel $object)
    {
        if ($object instanceof CartInterface) {
            $customAttributes = $object->getCustomer()->getCustomAttributes();
            if (!empty($customAttributes)) {
                /** @var $quoteModel \Thinkopen\CustomerCustomAttributes\Model\Sales\Quote */
                $quoteModel = $this->quoteFactory->create();
                $quoteModel->saveAttributeData($object);
            }
        }
    }
}