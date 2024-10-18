<?php

namespace SmSoftware\Import\Model\Service;

class ImportService
{
    private ValidationService $_validationService;

    public function __construct(
        ValidationService $validationService
    )
    {
        $this->_validationService = $validationService;
    }

    public function import(string $filepath): void
    {
        // Import logic here
    }
}