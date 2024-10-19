<?php

namespace SmSoftware\Import\Model\Service;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product;
use SmSoftware\Import\Exception\FileValidationException;
use SmSoftware\Import\Model\Converter\TireDataConverter;
use SmSoftware\Import\Model\Dto\TireDataDTO;

class ImportService
{
    private ProductRepositoryInterface $_productRepository;
    private Product $_productResource;
    private TireDataConverter $_tireDataConverter;
    private CategoryService $_categoryService;
    private AttributeSetService $_attributeSetService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        Product                    $productResource,
        TireDataConverter          $tireDataConverter,
        CategoryService            $categoryService,
        AttributeSetService        $attributeSetService
    )
    {
        $this->_productRepository = $productRepository;
        $this->_productResource = $productResource;
        $this->_tireDataConverter = $tireDataConverter;
        $this->_categoryService = $categoryService;
        $this->_attributeSetService = $attributeSetService;
    }

    /**
     * @throws \Exception
     */
    public function import(string $filepath): void
    {
        $validFile = ValidationService::validate($filepath);
        if (!$validFile) {
            throw new FileValidationException('File is not readable or doesn\'t exist');
        }

        $data = FileHandler::readFileToArray($filepath);
        /** @var TireDataDTO $tireData */
        $brands = [];
        foreach ($data as $tireData) {
            $this->_categoryService->addMultiplePredefinedCategories($tireData);
            if (!in_array($tireData->brand, $brands)) {
                $brands[] = $tireData->brand;
            }
        }
//            $product = $this->_tireDataConverter->convert($tireData);
        $this->_attributeSetService->createAttributeSets($brands);
        $this->_categoryService->createCategories();
    }
}