<?php

namespace api\controllers;

use api\models\CurrencySearch;
use core\entities\Currency;
use core\services\CurrencyService;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

class CurrencyController extends BaseRestController
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
            $currencies = $this->service->getCurrentInDb();
            if (empty($currencies)) $this->service->addCurrencies();
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

    public function actionCurrency(mixed $code): ActiveRecord|string
    {
        $currency = $this->modelClass::find()->andWhere(
            [
                'or',
                ['num_code' => $code],
                ['char_code' => strtoupper($code)]
            ]
        )->one();

        if (!$currency) return "Nothing found for your request: $code";

        return $currency;
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'currencies' => ['get'],
                'currency' => ['get'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return ActiveDataProvider
     */
    private function prepareDataProvider(): ActiveDataProvider
    {
        $searchModel = new CurrencySearch();

        return $searchModel->search($this->args);
    }
}
