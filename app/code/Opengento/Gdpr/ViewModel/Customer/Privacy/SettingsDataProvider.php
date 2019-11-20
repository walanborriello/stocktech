<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\Gdpr\ViewModel\Customer\Privacy;

use Magento\Cms\Block\Block;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\BlockFactory;
use Opengento\Gdpr\Model\Config;

final class SettingsDataProvider implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var null|string
     */
    private $privacyInformationHtml;

    public function __construct(
        Config $config,
        BlockFactory $blockFactory
    ) {
        $this->config = $config;
        $this->blockFactory = $blockFactory;
    }

    public function getPrivacyInformationHtml(): string
    {
        return $this->privacyInformationHtml ??
            $this->privacyInformationHtml = $this->blockFactory->createBlock(
                Block::class,
                ['data' => ['block_id' => $this->config->getPrivacyInformationBlockId()]]
            )->toHtml();
    }
}
