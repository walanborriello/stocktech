<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\Gdpr\Model\Action\Erase;

use InvalidArgumentException;
use Opengento\Gdpr\Api\Data\ActionContextInterface;
use Opengento\Gdpr\Api\Data\ActionResultInterface;
use Opengento\Gdpr\Api\EraseEntityManagementInterface;
use Opengento\Gdpr\Model\Action\AbstractAction;
use Opengento\Gdpr\Model\Action\ResultBuilder;

final class ExecuteAction extends AbstractAction
{
    /**
     * @var EraseEntityManagementInterface
     */
    private $eraseEntityManagement;

    public function __construct(
        ResultBuilder $resultBuilder,
        EraseEntityManagementInterface $eraseEntityManagement
    ) {
        $this->eraseEntityManagement = $eraseEntityManagement;
        parent::__construct($resultBuilder);
    }

    public function execute(ActionContextInterface $actionContext): ActionResultInterface
    {
        $eraseEntity = ArgumentReader::getEntity($actionContext);

        if ($eraseEntity === null) {
            throw new InvalidArgumentException('Argument "entity" is required.');
        }

        return $this->createActionResult(
            [ArgumentReader::ERASE_ENTITY => $this->eraseEntityManagement->process($eraseEntity)]
        );
    }
}
