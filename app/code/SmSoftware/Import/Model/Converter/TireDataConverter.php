<?php

namespace SmSoftware\Import\Model\Converter;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use SmSoftware\Import\Model\Dto\TireDataDTO;

class TireDataConverter
{
    private ProductFactory $productFactory;

    public function __construct(
        ProductFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function convert(TireDataDTO $tireDataDTO): Product
    {
        $product = $this->productFactory->create();
        $product->setSku($tireDataDTO->sku);
        $product->setName($tireDataDTO->name);
        $product->setPrice($tireDataDTO->price);
        $product->setQty($tireDataDTO->qty);
        $product->setSize($tireDataDTO->size);
        $product->setSizeVariation($tireDataDTO->sizeVariation);
        $product->setBrand($tireDataDTO->brand);
        $product->setModel($tireDataDTO->model);
        $product->setPerformance($tireDataDTO->performance);
        $product->setCarType($tireDataDTO->carType);
        $product->setSeason($tireDataDTO->season);

        // Assuming additional attributes are custom attributes
        foreach ($tireDataDTO->additionalAttributes as $attribute) {
            $product->setCustomAttribute('attribute1', $attribute->attribute1);
            $product->setCustomAttribute('attribute2', $attribute->attribute2);
            $product->setCustomAttribute('attribute3', $attribute->attribute3);
        }

        return $product;
    }
}