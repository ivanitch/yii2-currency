<?php

namespace core\services;

use core\entities\Currency;
use core\repositories\CurrencyRepository;
use Yii;

readonly class CurrencyService
{
    public function __construct(
        private CurrencyRepository $repository,
        private CBRAgentService $CBRAgentService
    ) {}

    public function addCurrencies(): void
    {
        $data = $this->getActualWithAgent();
        if (empty($data)) return;

        foreach ($data as $item):
            $currency = Currency::add(
                $item['num_code'],
                $item['char_code'],
                $item['nominal'],
                $item['name'],
                $item['value'],
                $item['rate']
            );
            $this->repository->save($currency);
        endforeach;

        echo "Done!" . PHP_EOL;
        echo "Added " . count($data) . " currencies" . PHP_EOL;
    }

    public function updateCurrencies(): void
    {
        $currentInDb = $this->getCurrentInDb();
        if (!empty($currentInDb)) {
            Yii::$app->db->createCommand()->truncateTable(Currency::tableName())->execute();
        }

        $this->addCurrencies();
    }

    /**
     * @return array|null
     */
    public function getActualWithAgent(): ?array
    {
        return $this->CBRAgentService->getAll();
    }

    public function getCurrentInDb(): array
    {
        return $this->repository->getAll();
    }
}
