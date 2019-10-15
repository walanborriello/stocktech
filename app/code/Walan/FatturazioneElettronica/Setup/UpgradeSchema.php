<?php

namespace Walan\FatturazioneElettronica\Setup;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            if (!$installer->tableExists('customer_address_custom_attributes')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('customer_address_custom_attributes')
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'Customer ID'
                    )
                    ->addColumn(
                        'order_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable' => 'false'],
                        'Order ID'
                    )->addColumn(
                        'request_invoice',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        255,
                        ['nullable' => 'false'],
                        'Request invoice'
                    )
                    ->addColumn(
                        'pec',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'PEC'
                    )
                    ->addColumn(
                        'ssid',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'SSID'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                        'Created At'
                    )->addColumn(
                        'updated_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At'
                    )
                    ->setComment('customer address custom attributes');
                $installer->getConnection()->createTable($table);

                $installer->getConnection()->addIndex(
                    $installer->getTable('customer_address_custom_attributes'),
                    $setup->getIdxName(
                        $installer->getTable('customer_address_custom_attributes'),
                        ['pec', 'ssid'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    ['pec', 'ssid'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                );
            }
            $installer->endSetup();
        }
    }
}