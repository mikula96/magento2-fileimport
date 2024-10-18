<?php

namespace SmSoftware\Import\Model\Database\Model;

use Magento\Framework\Model\AbstractModel;

class TireSizePattern extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(\SmSoftware\Import\Model\Database\ResourceModel\TireSizePattern::class);
    }
}