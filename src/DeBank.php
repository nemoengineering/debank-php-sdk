<?php

namespace Nemo\DeBank;

use GuzzleHttp\Client;
use Nemo\DeBank\Api\User;

class DeBank
{
    protected const BASE_URI = 'https://pro-openapi.debank.com';

    private Client $httpClient;

    public function __construct(string $accessKey, ?Client $client = null)
    {
        $this->httpClient = $client ?: new Client([
            'base_uri' => self::BASE_URI,
            'headers' => ['AccessKey' => $accessKey],
        ]);
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    public function user(): User
    {
        return new User($this);
    }
}
