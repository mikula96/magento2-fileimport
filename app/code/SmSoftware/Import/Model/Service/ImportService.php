<?php

namespace SmSoftware\Import\Model\Service;

use SmSoftware\Import\Exception\FileValidationException;
use SmSoftware\Import\Model\Dto\TireDataDTO;

class ImportService
{
    public function __construct()
    {
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
    }
}