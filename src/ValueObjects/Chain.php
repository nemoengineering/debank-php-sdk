<?php

namespace Nemo\DeBank\ValueObjects;

class Chain
{
    public function __construct(
        public string $id, // The chain's id.
        public int $communityId, // The community-identified id.
        public string $name, // The chain's name.
        public string $logoUrl, // URL of the chain's logo image. null if not available.
        public string $nativeTokenId, // The native token's id.
        public string $wrappedTokenId, // The address of the native token.
    ) {
        //
    }

    public static function fromResponse(array $response): Chain
    {
        return new Chain(
            id: $response['id'],
            communityId: $response['community_id'],
            name: $response['name'],
            logoUrl: $response['logo_url'],
            nativeTokenId: $response['native_token_id'],
            wrappedTokenId: $response['wrapped_token_id'],
        );
    }
}
