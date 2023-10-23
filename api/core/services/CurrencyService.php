<?php

namespace api\core\services;

use api\core\entities\CBRAgent;
use api\core\entities\Currency;
use api\core\repositories\CurrencyRepository;
use yii\web\NotFoundHttpException;

readonly class CurrencyService
{
    public function __construct(
        private CurrencyRepository $repository,
        private CBRAgent           $CBRAgent
    ) {}

    /**
     * @param $id
     * @return void
     * @throws NotFoundHttpException
     */
    public function remove($id): void
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
        if (is_array($data = $this->getActualCurrencies())) {
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
    public function getActualCurrencies(): ?array
    {
        return $this->CBRAgent->getAll();
    }
}