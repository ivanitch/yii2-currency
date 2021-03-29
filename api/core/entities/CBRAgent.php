<?php

namespace api\core\entities;
/**
 * Class CBRAgent
 * @package api\core\entities
 */
class CBRAgent
{
    protected $list = [];

    /**
     * CBRAgent constructor.
     */
    public function __construct()
    {
        $xml = new \DOMDocument();
        $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');

        if (@$xml->load($url))
        {
            $root = $xml->documentElement;
            $items = $root->getElementsByTagName('Valute');

            foreach ($items as $item)
            {
                $name = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $rate = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->list[$name] = floatval(str_replace(',', '.', $rate));
            }
        }
        else throw new \RuntimeException('Failed to load data.');
    }


    public function getByName($name)
    {
        return isset($this->list[$name]) ? $this->list[$name] : 0;
    }

    public function getAll()
    {
        return $this->list;
    }
}