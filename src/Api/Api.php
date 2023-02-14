<?php

declare(strict_types=1);

namespace Nemo\DeBank\Api;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Nemo\DeBank\DeBank;
use Nemo\DeBank\ResponseTransformer;

class Api
{
    /**
     * @var DeBank
     */
    protected DeBank $client;

    /**
     * @var string
     */
    private string $version = 'v1';

    /**
     * @var ResponseTransformer
     */
    protected ResponseTransformer $transformer;

    /**
     * @param  DeBank  $client
     */
    public function __construct(DeBank $client)
    {
        $this->client = $client;
        $this->transformer = new ResponseTransformer();
    }

    /**
     * @param  string  $uri
     * @param  array  $query
     * @return array
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function get(string $uri, array $query = []): array
    {
        $response = $this->client->getHttpClient()->request('GET', "/$this->version/$uri", ['query' => $query]);

        return $this->transformer->transform($response);
    }
}
