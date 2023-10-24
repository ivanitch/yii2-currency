<?php

namespace console\controllers;

use core\services\CurrencyService;
use yii\console\Controller;

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
     * @return void
     */
    public function actionUpdate(): void
    {
        $this->service->updateCurrencies();
    }
}
