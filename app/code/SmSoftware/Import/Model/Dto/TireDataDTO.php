<?php

namespace SmSoftware\Import\Model\Dto;

class TireDataDTO {
    public string $sku;
    public string $name;
    public float $price;
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


    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getSizeVariation(): string
    {
        return $this->sizeVariation;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getPerformance(): string
    {
        return $this->performance;
    }

    public function getCarType(): string
    {
        return $this->carType;
    }

    public function getSeason(): string
    {
        return $this->season;
    }

    public function getAdditionalAttributes(): array
    {
        return $this->additionalAttributes;
    }
}