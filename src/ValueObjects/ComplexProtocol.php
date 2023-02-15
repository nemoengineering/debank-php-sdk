<?php

namespace Nemo\DeBank\ValueObjects;

class ComplexProtocol
{
    public function __construct(
        public string $id, // The protocol's id.
        public string $chain, // The chain's id.
        public string $name, // The protocol's name. null if not defined in the contract and not available from other sources.
        public string $logoUrl, // URL of the protocol's logo image. null if not available.
        public string $siteUrl, // prioritize websites that can be interacted with, not official websites.
        public string $hasSupportedPortfolio, // Is the portfolio already supported.
        public array $portfolioItemList, // Array of PortfolioItemObject
        public ?float $tvl = null,
    ) {
        //
    }

    public static function fromResponse(array $response): ComplexProtocol
    {
        return new ComplexProtocol(
            id: $response['id'],
            chain: $response['chain'],
            name: $response['name'],
            logoUrl: $response['logo_url'],
            siteUrl: $response['site_url'],
            hasSupportedPortfolio: $response['has_supported_portfolio'],
            portfolioItemList: $response['portfolio_item_list'], // array_map(fn($i) => PortfolioItem::fromResponse($i), $response["portfolio_item_list"]),
            tvl: $response['tvl']
        );
    }
}
