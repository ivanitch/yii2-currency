<?php

namespace core\repositories;

use core\entities\Currency;
use RuntimeException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class CurrencyRepository
{
    /**
     * @param $id
     * @return Currency
     * @throws NotFoundHttpException
     */
    public function get($id): Currency
    {
        if (!$model = Currency::findOne($id)) {
            throw new NotFoundHttpException('Currency is not found.');
        }
        return $model;
    }

    public function getAll(): array
    {
        return Currency::find()->asArray()->all();
    }

    /**
     * @param Currency $model
     */
    public function save(Currency $model): void
    {
        if (!$model->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function getByNumCode(int $numCode): array|ActiveRecord
    {
        if (!$model = Currency::find()->where(['num_code' => $numCode])->one()) {
            throw new NotFoundHttpException('Currency is not found.');
        }

        return $model;
    }
}