<?php

namespace core\services;

use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

readonly class SmsService
{
    const string TEST_KEY = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function send(string $phone, string $message): void
    {
        $url = "https://smspilot.ru/api.php?send=$message&to=$phone&apikey=" . self::TEST_KEY;

        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();

        var_dump($response->getContent());
        /**
         * string(55) "SUCCESS=SMS SENT 4.81/20006.97
         * 10000,79991231212,4.81,0"
         */
    }
}
