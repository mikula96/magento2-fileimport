<?php

namespace SmSoftware\Import\Model\Service;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeGroupRepositoryInterface;
use Magento\Eav\Api\AttributeManagementInterface;
use Magento\Eav\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Eav\Api\Data\AttributeInterfaceFactory;
use Magento\Eav\Api\Data\AttributeSetInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;

class AttributeGroupService
{
    private AttributeGroupRepositoryInterface $attributeGroupRepository;
    private AttributeGroupInterfaceFactory $attributeGroupFactory;
    private AttributeSetInterfaceFactory $attributeSetFactory;
    private AttributeManagementInterface $attributeManagement;
    private AttributeInterfaceFactory $attributeFactory;

    public function __construct(
        AttributeGroupRepositoryInterface $attributeGroupRepository,
        AttributeGroupInterfaceFactory $attributeGroupFactory,
        AttributeSetInterfaceFactory $attributeSetFactory,
        AttributeManagementInterface $attributeManagement,
        AttributeInterfaceFactory $attributeFactory
    ) {
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->attributeGroupFactory = $attributeGroupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->attributeManagement = $attributeManagement;
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * Create attribute group and assign attributes to it.
     *
     * @param int $attributeSetId
     * @param string $groupName
     * @param array $attributes
     * @throws LocalizedException
     */
    public function createAttributeGroup(int $attributeSetId, string $groupName, array $attributes): void
    {
        // Create attribute group
        $attributeGroup = $this->attributeGroupFactory->create();
        $attributeGroup->setAttributeSetId($attributeSetId);
        $attributeGroup->setAttributeGroupName($groupName);
        $this->attributeGroupRepository->save($attributeGroup);

        $sortOrder = 100;
        // Assign attributes to the group
        foreach ($attributes as $attributeCode) {
            $attribute = $this->attributeFactory->create();
            $attribute->setAttributeCode($attributeCode);
            $this->attributeManagement->assign(
                Product::ENTITY,
                $attributeSetId,
                $attributeGroup->getAttributeGroupId(),
                $attributeCode,
                $sortOrder
            );
            $sortOrder += 100;
        }
    }
}