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

    /**
     * @return string
     */
    public function getMpn(): string
    {
        return $this->mpn;
    }

    /**
     * @return string
     */
    public function getSpeedRating(): string
    {
        return $this->speedRating;
    }

    /**
     * @return string
     */
    public function getUtqg(): string
    {
        return $this->utqg;
    }
}