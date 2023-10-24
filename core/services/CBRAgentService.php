<?php

namespace core\services;

use DOMDocument;
use RuntimeException;

/**
 * Class CBRAgent
 * @package core\services
 */
class CBRAgentService
{
    const URL = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';

    protected array $list;

    /**
     * CBRAgent constructor.
     */
    public function __construct()
    {
        $xml = new DOMDocument();

        $url = self::URL . date('d.m.Y');

        if ($xml->load($url)) {
            $root = $xml->documentElement;
            $items = $root->getElementsByTagName('Valute');

            foreach ($items as $item) {
                $name = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $rate = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->list[$name] = floatval(str_replace(',', '.', $rate));
            }
        }

        else throw new RuntimeException('Failed to load data.');
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->list;
    }
}
