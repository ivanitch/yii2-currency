<?php

namespace console\controllers;

use api\core\entities\Currency;
use api\core\services\CurrencyService;
use yii\console\Controller;
use yii\web\NotFoundHttpException;

class CurrencyController extends Controller
{
    /**
     * @param $id
     * @param $module
     * @param CurrencyService $service
     * @param array $config
     */
    public function __construct(
                                         $id,
                                         $module,
        private readonly CurrencyService $service,
        array                            $config = []
    )
    {
        parent::__construct($id, $module, $config);
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

        echo "DONE!" . PHP_EOL;
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