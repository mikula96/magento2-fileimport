<?php

namespace SmSoftware\Import\Model\Service;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeManagementInterface;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\AttributeSetManagementInterface;
use Magento\Eav\Model\Entity\AttributeFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class AttributeService
{
    private AttributeRepositoryInterface $_attributeRepository;
    private AttributeFactory $_attributeFactory;
    private AttributeManagementInterface $_attributeManagement;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        AttributeFactory             $attributeFactory,
        AttributeManagementInterface $attributeManagement
    )
    {
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeFactory = $attributeFactory;
        $this->_attributeManagement = $attributeManagement;
    }

    /**
     * Create a product attribute and return its ID.
     *
     * @param string $attributeCode
     * @param string $attributeLabel
     * @return int
     * @throws LocalizedException
     */
    public function createProductAttribute(string $attributeCode, string $attributeLabel, int $attributeSetId): int
    {
        $attributeCode = 'var_' . strtolower(trim($attributeCode));

        try {
            $attribute = $this->_attributeRepository->get(Product::ENTITY, $attributeCode);
            return $attribute->getId();
        } catch (NoSuchEntityException $e) {
            $attribute = $this->_attributeFactory->create();
            $attribute->setData([
                'attribute_code' => $attributeCode,
                'frontend_label' => $attributeLabel,
                'backend_type' => 'int',
                'frontend_input' => 'select',
                'is_user_defined' => 1,
                'is_unique' => 0,
                'is_global' => 1,
                'is_visible' => 1
            ]);

            $this->_attributeRepository->save($attribute);

            $this->_attributeManagement->assign(
                Product::ENTITY,
                $attributeSetId,
                $attribute->getId(),
                $attributeCode,
                100 + $attribute->getId()
            );

            return $attribute->getId();
        }
    }
}