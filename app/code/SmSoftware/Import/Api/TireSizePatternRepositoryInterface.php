<?php

namespace SmSoftware\Import\Api;

use SmSoftware\Import\Model\Database\Model\TireSizePattern as Model;

interface TireSizePatternRepositoryInterface
{
    public function getFactory();
    public function save(Model $tireSizePattern);
    public function getBySize($size);
    public function saveTransactional(array $models);
}