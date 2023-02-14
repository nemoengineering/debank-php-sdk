<?php

declare(strict_types=1);

namespace Nemo\DeBank;

use Nemo\DeBank\Exceptions\TransformResponseException;
use Psr\Http\Message\ResponseInterface;

class ResponseTransformer
{
    /**
     * @throws TransformResponseException
     */
    public function transform(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        if (str_starts_with($response->getHeaderLine('Content-Type'), 'application/json')) {
            $content = json_decode($body, true);
            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }

            throw new TransformResponseException('Error transforming response to array. JSON_ERROR: '
                .json_last_error().' --'.$body.'---');
        }

        throw new TransformResponseException('Error transforming response to array. Content-Type
            is not application/json');
    }
}
