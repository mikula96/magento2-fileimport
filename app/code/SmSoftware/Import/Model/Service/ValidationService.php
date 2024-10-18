<?php

namespace SmSoftware\Import\Model\Service;

class ValidationService
{
    private function __construct(){}

    public static function validate(string $filepath): bool
    {
        return is_readable($filepath);
    }
}