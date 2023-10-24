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
                $num_code = $item->getElementsByTagName('NumCode')->item(0)->nodeValue;
                $char_code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $nominal = $item->getElementsByTagName('Nominal')->item(0)->nodeValue;
                $name = $item->getElementsByTagName('Name')->item(0)->nodeValue;
                $value = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $rate = $item->getElementsByTagName('VunitRate')->item(0)->nodeValue;

                $this->list[$num_code] = [
                    'num_code' => (int) $num_code,
                    'char_code' => $char_code,
                    'nominal' => (int) $nominal,
                    'name' => $name,
                    'value' => self::format($value),
                    'rate' => self::format($rate),
                ];
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

    protected static function format(mixed $price): ?float
    {
        if (!$price) return null;

        return number_format(
            str_replace(
                ' ',
                '',
                str_replace(',', '.', $price)
            ), 4, '.', ''
        );
    }
}
