<?php
/**
 * Created by PhpStorm.
 * User: franco
 * Date: 10/11/19
 * Time: 18:19
 */

namespace Reply\Invoicing\Setup;


use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class UpgradeData implements \Magento\Framework\Setup\UpgradeDataInterface{

    const CUSTOMER_ADDRESS_ENTITY = 2;

    /**
     * @var Config
     */
    private
        $eavConfig;

    /**
     * @var EavSetupFactory
     */
    private
        $_eavSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private
        $attributeSetFactory;

    /**
     * @param Config $eavConfig
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public
    function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ){
        $this->eavConfig = $eavConfig;
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context){

        if(version_compare($context->getVersion(), '2.0.0', '<=')){

            $setup->startSetup();

            $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

            $entityTypeId = self::CUSTOMER_ADDRESS_ENTITY;
            try{
                $eavSetup->removeAttribute($entityTypeId, 'customer_invoice_type');
                $eavSetup->removeAttribute($entityTypeId, 'fiscal_code_id');
                $eavSetup->removeAttribute($entityTypeId, 'pec');
                $eavSetup->removeAttribute($entityTypeId, 'sdi');
                $eavSetup->removeAttribute($entityTypeId, 'wantinvoice');
            } catch(\Exception $e){}

            $eavSetup->addAttribute('customer_address', 'wantinvoice', [
                'type' => 'int',
                'label' => 'Want invoice',
                'input' => 'boolean',
                'required' => false,
                'user_defined' => true,
                'default' => '0',
                'sort_order' => 100,
                'system' => false,
                'position' => 100
            ]);

            $eavSetup->addAttribute('customer_address', 'pec', [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'PEC',
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'system' => false,
                'group' => 'General',
                'global' => true,
                'visible_on_front' => true,
                'sort_order' => 102,
                'position' => 102
            ]);


            $eavSetup->addAttribute('customer_address', 'sdi', [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'SDI',
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'system' => false,
                'group' => 'General',
                'global' => true,
                'visible_on_front' => true,
                'sort_order' => 103,
                'position' => 103
            ]);

            $eavSetup->addAttribute('customer_address', 'fiscal_code_id', [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Fiscal Code',
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'system' => false,
                'group' => 'General',
                'global' => true,
                'visible_on_front' => true,
                'sort_order' => 104,
                'position' => 104
            ]);


            $customAttribute = $this->eavConfig->getAttribute('customer_address', 'wantinvoice');

            $customAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
            );
            $customAttribute->save();

            $customAttribute = $this->eavConfig->getAttribute('customer_address', 'pec');

            $customAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
            );
            $customAttribute->save();

            $customAttribute = $this->eavConfig->getAttribute('customer_address', 'sdi');

            $customAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
            );
            $customAttribute->save();

            $customAttribute = $this->eavConfig->getAttribute('customer_address', 'fiscal_code_id');

            $customAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
            );
            $customAttribute->save();

            $setup->endSetup();
        }

    }
}