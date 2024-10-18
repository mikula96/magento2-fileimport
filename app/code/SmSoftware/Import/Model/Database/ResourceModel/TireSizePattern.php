<?php

namespace SmSoftware\Import\Model\Database\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TireSizePattern extends AbstractDb
{

    protected function _construct(): void
    {
        $this->_init('tire_size_pattern', 'size');
    }
}