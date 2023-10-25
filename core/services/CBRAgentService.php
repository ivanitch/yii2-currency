<?php

namespace core\services;

use DOMDocument;
use DOMElement;
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
        if ($xml->load($url)):
            $root = $xml->documentElement;
            $items = $root->getElementsByTagName('Valute');
            foreach ($items as $item):
                $num_code  = self::getElement($item, 'NumCode');
                $char_code = self::getElement($item, 'CharCode');
                $nominal   = self::getElement($item, 'Nominal');
                $name      = self::getElement($item, 'Name');
                $value     = self::getElement($item, 'Value');
                $rate      = self::getElement($item, 'VunitRate');

                $this->list[$num_code] = [
                    'num_code' => (int) $num_code,
                    'char_code' => $char_code,
                    'nominal' => (int) $nominal,
                    'name' => $name,
                    'value' => self::format($value),
                    'rate' => self::format($rate),
                ];
            endforeach;
        else:
            throw new RuntimeException('Failed to load data.');
        endif;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->list;
    }

    /**
     * @param mixed $price
     * @return float|null
     */
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

    /**
     * @param DOMElement $domElement
     * @param mixed $element
     * @return string|null
     */
    protected static function getElement(DOMElement $domElement, mixed $element): ?string
    {
        return $domElement->getElementsByTagName($element)->item(0)->nodeValue;
    }
}
