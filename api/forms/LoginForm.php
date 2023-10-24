<?php

namespace api\forms;

use core\entities\User\Token;
use core\entities\User\User;
use yii\base\Model;

class LoginForm extends Model
{
    public string $username;
    public string  $password;

    private User $user;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, array $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    public function auth(): ?Token
    {
        if (!$this->validate()) return null;

        $token = new Token();
        $token->user_id = $this->getUser()->id;
        $token->generateToken(time() + 3600 * 24);

        return $token->save() ? $token : null;
    }

    /**
     * @return User|null
     */
    protected function getUser(): ?User
    {
        return $this->user === null
            ? $this->user = User::findByUsername($this->username)
            : $this->user;
    }
}
