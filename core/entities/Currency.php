<?php

namespace core\entities;

use yii\db\ActiveRecord;

/**
 * @property int $num_code
 * @property string $char_code
 * @property int $nominal
 * @property string $name
 * @property float $value
 * @property float $rate
 */
class Currency extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%currency}}';
    }

    /**
     * @param int $num_code
     * @param string $char_code
     * @param int $nominal
     * @param string $name
     * @param float $value
     * @param float $rate
     * @return self
     */
    public static function add(
        int $num_code,
        string $char_code,
        int $nominal,
        string $name,
        float $value,
        float $rate
    ): self
    {
        $model = new static();
        $model->num_code = $num_code;
        $model->char_code = $char_code;
        $model->nominal = $nominal;
        $model->name = $name;
        $model->value = $value;
        $model->rate = $rate;

        return $model;
    }
}
