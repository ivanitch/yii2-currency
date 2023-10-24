<?php

namespace core\services;

use core\entities\Currency;
use core\repositories\CurrencyRepository;
use yii\web\NotFoundHttpException;

readonly class CurrencyService
{
    public function __construct(
        private CurrencyRepository $repository,
        private CBRAgentService $CBRAgentService
    ) {}

    /**
     * @param $id
     * @return void
     * @throws NotFoundHttpException
     */
    public function remove($id): void // @TODO ????
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

    /**
     * @param $id
     * @return Currency|null
     * @throws NotFoundHttpException
     */
    public function get($id): ?Currency
    {
        return $this->repository->get($id);
    }


    public function insertCurrency(): void
    {
        if (is_array($data = $this->getActualThroughAnAgent())) {
            foreach ($data as $name => $rate) {
                $model = Currency::add($name, $rate);
                $this->repository->save($model);
            }
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function updateCurrency(array $difference): void
    {
        if ($difference) {
            foreach ($difference as $name => $rate) {
                $model = $this->repository->getByName($name);
                $model->edit($rate);
                $this->repository->save($model);
            }
        }
    }


    /**
     * @return array|null
     */
    public function getActualThroughAnAgent(): ?array
    {
        return $this->CBRAgentService->getAll();
    }

    public function getAll(): array
    {
        return Currency::find()->select(['name', 'rate'])->asArray()->all();
    }
}