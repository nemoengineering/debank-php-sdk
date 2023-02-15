<?php

namespace Nemo\DeBank\ValueObjects;

use Carbon\CarbonImmutable;

class HistoryEntry
{
    public function __construct(
        public ?string $categoryId, // call type.
        public string $chain, // chain id.
        public string $id, // transaction hash.
        public ?string $otherAddress,
        public ?string $projectId, // project id which was interacted.
        public array $sends, // valid when categoryId is send.
        public array $receives, // valid when categoryId is receive.
        public ?array $tokenApprove, // valid when categoryId is approve.
        public CarbonImmutable $timeAt, // timestamp.
        public ?array $tx, // The transaction's base info
    ) {
        //
    }

    public static function fromResponse(array $response): HistoryEntry
    {
        return new HistoryEntry(
            categoryId: $response['cate_id'] ?? null,
            chain: $response['chain'],
            id: $response['id'],
            otherAddress: $response['other_addr'] ?? null,
            projectId: $response['project_id'] ?? null,
            sends: $response['sends'],
            receives: $response['receives'],
            tokenApprove: $response['token_approve'] ?? null,
            timeAt: CarbonImmutable::createFromTimestamp($response['time_at']),
            tx: $response['tx'] ?? null,
        );
    }
}
