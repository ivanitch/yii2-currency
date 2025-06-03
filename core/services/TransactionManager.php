<?php

namespace core\services;

use Throwable;
use Yii;

class TransactionManager
{
    /**
     * @throws Throwable
     */
    public function wrap(callable $function): void
    {
        Yii::$app->db->transaction($function);
    }
}
