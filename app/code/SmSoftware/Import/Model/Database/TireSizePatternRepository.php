<?php

namespace SmSoftware\Import\Model\Database;

use Exception;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use SmSoftware\Import\Api\TireSizePatternRepositoryInterface;
use SmSoftware\Import\Model\Database\Model\TireSizePattern as Model;
use SmSoftware\Import\Model\Database\Model\TireSizePatternFactory as Factory;
use SmSoftware\Import\Model\Database\ResourceModel\TireSizePattern as ResourceModel;

class TireSizePatternRepository implements TireSizePatternRepositoryInterface
{
    private Factory $_factory;
    private ResourceModel $_resourceModel;
    private TransactionFactory $_transactionFactory;

    public function __construct(
        Factory $factory,
        ResourceModel $resourceModel,
        TransactionFactory $transactionFactory
    )
    {
        $this->_factory = $factory;
        $this->_resourceModel = $resourceModel;
        $this->_transactionFactory = $transactionFactory;
    }

    public function getFactory(): Factory
    {
        return $this->_factory;
    }

    /**
     * @throws AlreadyExistsException
     */
    public function save(Model $tireSizePattern): void
    {
        $this->_resourceModel->save($tireSizePattern);
    }

    public function getBySize($size): ?Model
    {
        $model = $this->_factory->create();
        $this->_resourceModel->load($model, $size);
        if (!$model->getId()) {
            return null;
        }
        return $model;
    }

    /**
     * @throws Exception
     */
    public function saveTransactional(array $models): void
    {
        $transaction = $this->_transactionFactory->create();
        foreach ($models as $model) {
            $transaction->addObject($model);
        }
        $transaction->save();
    }
}