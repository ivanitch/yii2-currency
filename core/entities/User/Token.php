<?php

namespace core\entities\User;

use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%token}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $expired_at
 * @property string $token
 */
class Token extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%token}}';
    }

    /**
     * @param $expire
     * @throws Exception
     */
    public function generateToken($expire): void
    {
        $this->expired_at = $expire;
        $this->token = \Yii::$app->security->generateRandomString();
    }

    public function fields(): array
    {
        return [
            'token' => 'token',
            'expired' => fn() => date(DATE_RFC3339, $this->expired_at),
        ];
    }
}
