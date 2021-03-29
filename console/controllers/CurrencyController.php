<?php

namespace console\controllers;

use api\core\entities\Currency;
use api\core\services\CurrencyService;
use yii\console\Controller;
use yii\web\NotFoundHttpException;

class CurrencyController extends Controller
{
    private CurrencyService $service;

    /**
     * CurrencyController constructor.
     * @param $id
     * @param $module
     * @param CurrencyService $service
     * @param array $config
     */
    public function __construct($id, $module, CurrencyService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Adds role to user
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $array = [];
        $current = $this->getCurrentCurrencies();
        foreach ($current as $item) {
            $array[$item['name']] = (float)$item['rate'];
        }

        $actual = $this->getActualCurrencies();
        $difference = array_diff_assoc($actual, $array);
        if ($difference) {
            $this->service->updateCurrency($difference);
        }
    }

    /**
     * @return array|null
     */
    private function getActualCurrencies(): ?array
    {
        return $this->service->getActualCurrencies();
    }

    /**
     * @return array
     */
    private function getCurrentCurrencies(): array
    {
        return Currency::find()->select(['name', 'rate'])->asArray()->all();
    }
}