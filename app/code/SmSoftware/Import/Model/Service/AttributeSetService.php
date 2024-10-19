<?php

namespace SmSoftware\Import\Model\Service;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeSetManagementInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Eav\Model\Entity\TypeFactory;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class AttributeSetService
{
    const ATTRIBUTE_SET_NAME_PREFIX = 'Tires - ';
    private array $_attributeSets = [];
    private AttributeSetManagementInterface $_attributeSetManagement;
    private SetFactory $_attributeSetFactory;
    private TypeFactory $_eavTypeFactory;
    private AttributeService $_attributeService;

    public function __construct(
        AttributeSetManagementInterface $attributeSetManagement,
        SetFactory $attributeSetFactory,
        TypeFactory $eavTypeFactory,
        AttributeService $attributeService
    )
    {
        $this->_attributeSetManagement = $attributeSetManagement;
        $this->_attributeSetFactory = $attributeSetFactory;
        $this->_eavTypeFactory = $eavTypeFactory;
        $this->_attributeService = $attributeService;
    }

    /**
     * Based on brand names, create attribute sets with prefix
     *
     * @param array $attributeSets - list of brand names
     * @return void
     * @throws InputException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function createAttributeSets(array $attributeSets): void
    {
        $entityType = $this->_eavTypeFactory->create()->loadByCode(Product::ENTITY);
        $defaultSetId = $entityType->getDefaultAttributeSetId();

        foreach ($attributeSets as $attributeSetName) {
            $attributeSetName = trim(strval($attributeSetName));
            if(!in_array($attributeSetName, $this->_attributeSets)) {
                $attributeSetId = $this->_createAttributeSet($attributeSetName, $defaultSetId);
                $this->_attributeService->createProductAttribute($attributeSetName, $attributeSetName, $attributeSetId);
                $this->_attributeSets[$attributeSetName] = $attributeSetId;
            }
        }
    }

    public function getAttributeSetByBrandName($brandName): string
    {
        return $this->_attributeSets[$brandName] ?? "";
    }

    /**
     * Create new attribute set by name and code
     *
     * @throws NoSuchEntityException
     * @throws InputException
     * @throws LocalizedException
     */
    private function _createAttributeSet($attributeSetName, $defaultSetId): int
    {
        $attributeSet = $this->_attributeSetFactory->create();
        $attributeSet->setAttributeSetName(self::ATTRIBUTE_SET_NAME_PREFIX.$attributeSetName);
        $attributeSet->setEntityTypeId(Product::ENTITY);
        return $this->_attributeSetManagement->create(Product::ENTITY, $attributeSet, $defaultSetId)->getAttributeSetId();
    }
}