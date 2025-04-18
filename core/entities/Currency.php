<?php

namespace core\entities;

use core\entities\User\User;
use core\services\SmsService;
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
    const DOLLAR_NUM_CODE = 840;
    const DOLLAR_CHAR_CODE = 'USD';
    const DOLLAR_MAX_VALUE = 100;

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

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $num_code = $this->getAttribute('num_code');
        $char_code = $this->getAttribute('char_code');

        if (self::isDollar($num_code, $char_code)) {
            $dollarValue = (int) $this->getAttribute('value');
            if ($dollarValue >= self::DOLLAR_MAX_VALUE) {
                /* @var User $admin */
                $admin = User::find()->where(['username' => 'admin'])->one();
                (new SmsService())->send(
                    $admin->phone,
                    "The maximum value of the dollar is $dollarValue rubles."
                );
            }
        }
    }

    protected static function isDollar(mixed $num_code, mixed $char_code): bool
    {
        return ($num_code == self::DOLLAR_NUM_CODE && $char_code == self::DOLLAR_CHAR_CODE);
    }
}
