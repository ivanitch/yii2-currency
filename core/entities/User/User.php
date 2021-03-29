<?php
namespace core\entities\User;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $email_confirm_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 10;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id): IdentityInterface
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return array|ActiveRecord|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface
    {
        return static::find()
            ->joinWith('tokens t')
            ->andWhere(['t.token' => $token])
            ->andWhere(['>', 't.expired_at', time()])
            ->one();
    }

    public static function findByUsername($username): ?User
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
