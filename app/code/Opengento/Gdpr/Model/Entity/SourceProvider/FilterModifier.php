<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\Gdpr\Model\Entity\SourceProvider;

use Magento\Framework\Api\Filter;
use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\LocalizedException;

final class FilterModifier implements ModifierInterface
{
    /**
     * @var string
     */
    private $filterIdentifier;

    /**
     * @var string
     */
    private $fieldToFilter;

    public function __construct(
        string $filterIdentifier,
        string $fieldToFilter
    ) {
        $this->filterIdentifier = $filterIdentifier;
        $this->fieldToFilter = $fieldToFilter;
    }

    /**
     * @inheritdoc
     * @throws LocalizedException
     */
    public function apply(Collection $collection, Filter $filter): void
    {
        if ($filter->getField() === $this->filterIdentifier) {
            $collection->addFieldToFilter(
                $this->fieldToFilter,
                [$filter->getConditionType() => $filter->getValue()]
            );
        }
    }
}
