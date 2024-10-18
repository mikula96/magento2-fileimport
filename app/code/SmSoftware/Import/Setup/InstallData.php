<?php

namespace SmSoftware\Import\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    const ATTRIBUTE_SIZE = 'size';
    const ATTRIBUTE_SIZE_VARIATION = 'size_variation';
    const ATTRIBUTE_BRAND = 'brand';
    const ATTRIBUTE_MODEL = 'model';
    const ATTRIBUTE_PERFORMANCE = 'performance';
    const ATTRIBUTE_CAR_TYPE = 'car_type';
    const ATTRIBUTE_SEASON = 'season';
    const ATTRIBUTE_MPN = 'mpn';
    const ATTRIBUTE_SPEED_RATING = 'speed_rating';
    const ATTRIBUTE_UTQG = 'utqg';

    private EavSetupFactory $_eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ): void
    {
        if(!version_compare($context->getVersion(), '1.0.0', '<')) {
            return;
        }
        $eavSetup = $this->_eavSetupFactory->create();

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_SIZE,
            [
                'type' => 'int',
                'label' => 'Tire Size',
                'input' => 'select',
                'required' => true,
                'sort_order' => 100,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_SIZE_VARIATION,
            [
                'type' => 'int',
                'label' => 'Size Variation',
                'input' => 'select',
                'required' => true,
                'sort_order' => 101,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_BRAND,
            [
                'type' => 'int',
                'label' => 'Brand',
                'input' => 'select',
                'required' => true,
                'sort_order' => 102,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_MODEL,
            [
                'type' => 'int',
                'label' => 'Model',
                'input' => 'select',
                'required' => true,
                'sort_order' => 103,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_PERFORMANCE,
            [
                'type' => 'int',
                'label' => 'Performance',
                'input' => 'select',
                'required' => false,
                'sort_order' => 104,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CAR_TYPE,
            [
                'type' => 'varchar',
                'label' => 'Car Type',
                'input' => 'text',
                'required' => false,
                'sort_order' => 105,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_SEASON,
            [
                'type' => 'int',
                'label' => 'Season',
                'input' => 'select',
                'required' => false,
                'sort_order' => 106,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_MPN,
            [
                'type' => 'varchar',
                'label' => 'MPN',
                'input' => 'text',
                'required' => false,
                'sort_order' => 107,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_SPEED_RATING,
            [
                'type' => 'int',
                'label' => 'Speed Rating',
                'input' => 'select',
                'required' => false,
                'sort_order' => 108,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        )->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_UTQG,
            [
                'type' => 'varchar',
                'label' => 'UTQG',
                'input' => 'text',
                'required' => false,
                'sort_order' => 109,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'group' => 'General',
            ]
        );
    }
}