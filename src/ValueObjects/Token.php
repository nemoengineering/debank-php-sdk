<?php

namespace Nemo\DeBank\ValueObjects;

use Carbon\CarbonImmutable;

class Token
{
    public function __construct(
        public string $id, // The address of the token contract.
        public string $chain, // The chain's name.
        public string $name, // The token's name. null if not defined in the contract and not available from other sources.
        public ?string $symbol, // The token's symbol. null if not defined in the contract and not available from other sources.
        public ?string $displaySymbol, //  The token's displayed symbol. If two tokens have the same symbol, they are distinguished by $displaySymbol.
        public string $optimizedSymbol, // For front-end display. $optimizedSymbol || $displaySymbol || $symbol.
        public int $decimals, // The number of decimals of the token. null if not defined in the contract and not available from other sources.
        public ?string $logoUrl, // URL of the token's logo image. null if not available.
        public bool $isVerified, // Whether it has been verified.
        public bool $isCore, // Whether to show as a common token in the wallet.
        public float $price, // USD price. Price of 0 means no data.
        public CarbonImmutable $timeAt, // The timestamp when the current token was deployed on the blockchain.
        public float $amount, // The amount of user's token.
        public string $rawAmount, // The raw amount of user's token. // FIXME BigNumber
    ) {
        //
    }

    public static function fromResponse(array $response): Token
    {
        return new Token(
            id: $response['id'],
            chain: $response['chain'],
            name: $response['name'],
            symbol: $response['symbol'],
            displaySymbol: $response['display_symbol'],
            optimizedSymbol: $response['optimized_symbol'],
            decimals: $response['decimals'],
            logoUrl: $response['logo_url'],
            isVerified: $response['is_verified'],
            isCore: $response['is_core'],
            price: $response['price'],
            timeAt: CarbonImmutable::createFromTimestamp($response['time_at']),
            amount: $response['amount'],
            rawAmount: $response['raw_amount'],
        );
    }
}
