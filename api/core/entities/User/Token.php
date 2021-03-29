<?php

namespace api\core\entities\User;

use yii\db\ActiveRecord;
use yii\base\Exception;

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
            'expired' => function () {
                return date(DATE_RFC3339, $this->expired_at);
            },
        ];
    }
}
