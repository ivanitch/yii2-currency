<?php

namespace console\controllers;

use core\services\CurrencyService;
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
     * @return void
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): void
    {
        $result = [];
        $current = $this->getCurrent();

        dd($current);
        if (empty($current)):
            $this->service->insertCurrency();
        else:
            foreach ($current as $item):
                $result[$item['name']] = (float) $item['rate'];
            endforeach;
            $actual = $this->service->getActualThroughAnAgent();
            $difference = array_diff_assoc($actual, $result);
            if (!empty($difference)):
                $this->service->updateCurrency($difference);
            endif;
        endif;

        echo "DONE!" . PHP_EOL;
    }

    /**
     * @return array
     */
    private function getCurrent(): array
    {
        return $this->service->getAll();
    }
}