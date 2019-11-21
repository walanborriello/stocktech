<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\Gdpr\Model\Order\Anonymize\Processor;

use DateTime;
use Exception;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Opengento\Gdpr\Api\EraseSalesInformationInterface;
use Opengento\Gdpr\Service\Anonymize\AnonymizerInterface;
use Opengento\Gdpr\Service\Erase\ProcessorInterface;

final class OrderDataProcessor implements ProcessorInterface
{
    /**
     * @var AnonymizerInterface
     */
    private $anonymizer;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var OrderAddressRepositoryInterface
     */
    private $orderAddressRepository;

    /**
     * @var EraseSalesInformationInterface
     */
    private $eraseSalesInformation;

    public function __construct(
        AnonymizerInterface $anonymizer,
        OrderRepositoryInterface $orderRepository,
        OrderAddressRepositoryInterface $orderAddressRepository,
        EraseSalesInformationInterface $eraseSalesInformation
    ) {
        $this->anonymizer = $anonymizer;
        $this->orderRepository = $orderRepository;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->eraseSalesInformation = $eraseSalesInformation;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function execute(int $orderId): bool
    {
        /** @var Order $order */
        $order = $this->orderRepository->get($orderId);
        $lastActive = new DateTime($order->getUpdatedAt());

        if ($this->eraseSalesInformation->isAlive($lastActive)) {
            $this->eraseSalesInformation->scheduleEraseEntity((int) $order->getEntityId(), 'order', $lastActive);

            return true;
        }

        $this->orderRepository->save($this->anonymizer->anonymize($order));

        /** @var OrderAddressInterface|null $orderAddress */
        foreach ([$order->getBillingAddress(), $order->getShippingAddress()] as $orderAddress) {
            if ($orderAddress) {
                $this->orderAddressRepository->save($this->anonymizer->anonymize($orderAddress));
            }
        }

        return true;
    }
}
