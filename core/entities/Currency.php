<?php

namespace core\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property float $rate
 */
class Currency extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%currency}}';
    }

    public static function add(string $name, string $rate): self
    {
        $model = new static();
        $model->name = $name;
        $model->rate = $rate;
        return $model;
    }

    public function edit(string $rate): void
    {
        $this->rate = $rate;
    }
}
