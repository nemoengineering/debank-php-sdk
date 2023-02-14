<?php

namespace Nemo\DeBank\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected const BASE_URI = 'https://pro-openapi.debank.com';

    protected function clientWithHandler(HandlerStack $handlerStack): Client
    {
        return new Client([
            'base_uri' => self::BASE_URI,
            'headers' => ['AccessKey' => 'secret'],
            'handler' => $handlerStack,
        ]);
    }

    protected function mockJsonResponse(string $json): HandlerStack
    {
        $headers = ['Content-Type' => 'application/json'];

        $response = new Response(200, $headers, $json);
        $mock = new MockHandler([$response]);

        return HandlerStack::create($mock);
    }
}
