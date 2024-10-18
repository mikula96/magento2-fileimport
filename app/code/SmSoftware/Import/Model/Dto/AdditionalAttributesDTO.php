<?php

namespace SmSoftware\Import\Model\Dto;

class AdditionalAttributesDTO
{
    public string $mpn;
    public string $speedRating;
    public string $utqg;

    public function __construct($mpn, $speedRating, $utqg) {
        $this->mpn = $mpn;
        $this->speedRating = $speedRating;
        $this->utqg = $utqg;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }
}