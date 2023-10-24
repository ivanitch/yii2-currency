<?php

namespace core\repositories;

use core\entities\Currency;
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
            throw new NotFoundHttpException('Model is not found.');
        }
        return $model;
    }

    public function getAll($id): array
    {
        $data = Currency::find()->select(['name', 'rate'])->asArray()->all();



        if (!$model = Currency::findOne($id)) {
            throw new NotFoundHttpException('Model is not found.');
        }
        return $model;
    }


    /**
     * @param Currency $model
     */
    public function save(Currency $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Currency $model
     */
    public function remove(Currency $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param $name
     * @return Currency
     * @throws NotFoundHttpException
     */
    public function getByName($name): Currency
    {
        if (!$model = Currency::find()->where(['name' => $name])->one()) {
            throw new NotFoundHttpException('Model is not found.');
        }
        return $model;
    }

}