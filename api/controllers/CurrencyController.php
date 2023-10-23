<?php

namespace api\controllers;

use api\core\entities\Currency;
use api\core\services\CurrencyService;
use api\models\CurrencySearch;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class CurrencyController extends AbstractRestController
{
    /**
     * @var Currency $modelClass
     */
    public $modelClass = Currency::class;

    private CurrencyService $service;

    /**
     * CurrencyController constructor.
     * @param $id
     * @param $module
     * @param CurrencyService $service
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        CurrencyService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @param Action $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if ($action->id === 'currencies') {
            $currencies = $this->modelClass::find()->asArray()->all();
            if (empty($currencies)) $this->service->insertCurrency();
        }

        return parent::beforeAction($action);
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionCurrencies(): ActiveDataProvider
    {
        return $this->prepareDataProvider();
    }

    /**
     * @param $id
     * @return Currency|null
     * @throws NotFoundHttpException
     */
    public function actionCurrency($id): ?Currency
    {
        if (($model = $this->modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested Currency does not exist.');
        }
    }

    /**
     * @return ActiveDataProvider
     */
    private function prepareDataProvider(): ActiveDataProvider
    {
        $searchModel = new CurrencySearch();
        return $searchModel->search($this->args);
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'currencies' => ['get'],
                'currency' => ['get'],
            ],
        ];

        return $behaviors;
    }

    protected function checkActions(): array
    {
        return ['currencies', 'currency'];// TODO (update)!!
    }
}
