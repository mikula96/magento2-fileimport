<?php

namespace SmSoftware\Import\Model\Dto;

class TireDataDTO {
    public string $sku;
    public string $name;
    public int $price;
    public int $qty;
    public string $size;
    public string $sizeVariation;
    public string $brand;
    public string $model;
    public string $performance;
    public string $carType;
    public string $season;
    public array $additionalAttributes;

    public function __construct($sku, $name, $price, $qty, $size, $sizeVariation,
                                $brand, $model, $performance, $carType, $season, $additionalAttributes) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->qty = $qty;
        $this->size = $size;
        $this->sizeVariation = $sizeVariation;
        $this->brand = $brand;
        $this->model = $model;
        $this->performance = $performance;
        $this->carType = $carType;
        $this->season = $season;
        $this->additionalAttributes = $additionalAttributes;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }
}