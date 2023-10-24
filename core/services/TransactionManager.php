<?php

namespace core\services;

use Yii;

class TransactionManager
{
    public function wrap(callable $function): void
    {
        Yii::$app->db->transaction($function);
    }
}
