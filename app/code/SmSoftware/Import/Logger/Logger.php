<?php


namespace SmSoftware\Import\Logger;


use Monolog\DateTimeImmutable;

class Logger extends \Monolog\Logger
{
    public function addInfo($message, $context = [], DateTimeImmutable $datetime = null){
        $this->addRecord(self::INFO, $message, $context, $datetime);
    }

    public function addError($message, $context = [], DateTimeImmutable $datetime = null){
        $this->addRecord(self::ERROR, $message, $context, $datetime);
    }

    public function addNotice($message, $context = [], DateTimeImmutable $datetime = null){
        $this->addRecord(self::NOTICE, $message, $context, $datetime);
    }

    public function addWarning($message, $context = [], DateTimeImmutable $datetime = null){
        $this->addRecord(self::WARNING, $message, $context, $datetime);
    }

    public function addCritical($message, $context = [], DateTimeImmutable $datetime = null){
        $this->addRecord(self::CRITICAL, $message, $context, $datetime);
    }

    public function addDebug($message, $context = [], DateTimeImmutable $datetime = null){
        $this->addRecord(self::DEBUG, $message, $context, $datetime);
    }
}
