<?php

namespace Nemo\DeBank\ValueObjects;

class TransactionHistory
{
    public function __construct(
        public array $categoryDictionary, // Call type category (eg. approve, receive, send).
        public array $projectDictionary, // Projects which this address interacted.
        public array $tokenDictionary, // Tokens which this address interacted.
        public array $historyList, // Address's history transaction list.
    ) {
        //
    }

    public function entriesCount(): int
    {
        return count($this->historyList);
    }

    public function lastEntry(): ?HistoryEntry
    {
        return $this->entriesCount() > 0 ? end($this->historyList) : null;
    }

    public function merge(TransactionHistory $other): TransactionHistory
    {
        return new TransactionHistory(
            categoryDictionary: array_merge($this->categoryDictionary, $other->categoryDictionary),
            projectDictionary: array_merge($this->projectDictionary, $other->projectDictionary),
            tokenDictionary: array_merge($this->tokenDictionary, $other->tokenDictionary),
            historyList: array_merge($this->historyList, $other->historyList)
        );
    }

    public static function fromResponse(array $response): TransactionHistory
    {
        return new TransactionHistory(
            categoryDictionary: $response['cate_dict'],
            projectDictionary: $response['project_dict'],
            tokenDictionary: $response['token_dict'],
            historyList: array_map(fn ($i) => HistoryEntry::fromResponse($i), $response['history_list'])
        );
    }
}
