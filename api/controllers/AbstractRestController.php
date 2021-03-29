<?php

namespace api\controllers;

use core\access\Rbac;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\base\Module;

/**
 * Class BaseRestController
 * @package api\controllers
 *
 * @property $service
 * @property $args
 */
abstract class AbstractRestController extends ActiveController
{
    abstract protected function checkActions(): array;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    protected $args;

    /**
     * BaseRestController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->args = \Yii::$app->request->queryParams;
        $this->response = \Yii::$app->getResponse();
    }

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, $this->checkActions())) {
            if (!\Yii::$app->user->can(Rbac::ROLE_ADMIN)) {
                throw  new ForbiddenHttpException('Forbidden.');
            }
        }
    }
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = $this->checkActions();
        $behaviors['authenticator']['authMethods'] = [
            HttpBasicAuth::class,
            HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => $this->checkActions(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formatParam' => '_format',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'xml' => Response::FORMAT_XML
            ],
        ];
        return $behaviors;
    }
}
