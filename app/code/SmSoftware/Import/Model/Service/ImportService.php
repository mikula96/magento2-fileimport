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

    public function __construct(
        ProductRepositoryInterface $productRepository,
        Product $productResource,
        TireDataConverter $tireDataConverter
    )
    {
        $this->_productRepository = $productRepository;
        $this->_productResource = $productResource;
        $this->_tireDataConverter = $tireDataConverter;
    }

    /**
     * @throws \Exception
     */
    public function import(string $filepath): void
    {
        $validFile = ValidationService::validate($filepath);
        if(!$validFile) {
            throw new FileValidationException('File is not readable or doesn\'t exist');
        }

        /** @var TireDataDTO $data */
        $data = FileHandler::readFileToArray($filepath);
        foreach ($data as $tireData) {
            $product = $this->_tireDataConverter->convert($tireData);
            $this->_productResource->save($product);
        }
    }
}