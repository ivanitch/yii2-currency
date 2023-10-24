<?php

namespace api\controllers;

use api\models\CurrencySearch;
use core\entities\Currency;
use core\services\CurrencyService;
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


    public function __construct(
                                         $id,
                                         $module,
        private readonly CurrencyService $service,
                                         array $config = []
    )
    {
        parent::__construct($id, $module, $config);
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
        return ['update'];// TODO (update)!!
    }
}
