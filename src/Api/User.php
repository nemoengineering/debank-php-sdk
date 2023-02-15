<?php

declare(strict_types=1);

namespace Nemo\DeBank\Api;

use Carbon\CarbonImmutable;
use GuzzleHttp\Exception\GuzzleException;
use Nemo\DeBank\Exceptions\IllegalParameterException;
use Nemo\DeBank\ValueObjects\Chain;
use Nemo\DeBank\ValueObjects\ComplexProtocol;
use Nemo\DeBank\ValueObjects\Token;
use Nemo\DeBank\ValueObjects\TransactionHistory;

class User extends Api
{
    /**
     * Get user used chain
     *
     * @param  string  $id user address
     * @return array
     *
     * @throws GuzzleException
     */
    public function getChainList(string $id): array
    {
        $params['id'] = $id;
        $res = $this->get('user/used_chain_list', $params);

        return array_map(fn ($i) => Chain::fromResponse($i), $res);
    }

    /**
     * Get user complex protocol list
     *
     * @param  string  $id
     * @param  string|array  $chainIds
     * @return array
     *
     * @throws GuzzleException
     */
    public function getComplexProtocolList(string $id, string|array $chainIds): array
    {
        $params['id'] = $id;

        if (is_array($chainIds)) {
            $params['chain_ids'] = implode(',', $chainIds);
            $res = $this->get('user/all_complex_protocol_list', $params);
        } else {
            $params['chain_id'] = $chainIds;
            $res = $this->get('user/complex_protocol_list', $params);
        }

        return array_map(fn ($i) => ComplexProtocol::fromResponse($i), $res);
    }

    /**
     * Get user token list
     *
     * @param  string  $id user address
     * @param  bool  $isAll if true, all tokens are returned, including protocol-derived tokens, not-is-core tokens
     * @param  string|null  $chainId chain id
     * @return array
     *
     * @throws GuzzleException
     */
    public function getTokenList(string $id, bool $isAll = false, ?string $chainId = null): array
    {
        $params['id'] = $id;
        $params['is_all'] = $isAll;

        if ($chainId !== null) {
            $params['chain_id'] = $chainId;
            $res = $this->get('user/token_list', $params);
        } else {
            $res = $this->get('user/all_token_list', $params);
        }

        return array_map(fn ($i) => Token::fromResponse($i), $res);
    }

    /**
     * Get user history list
     *
     * @param  string  $id
     * @param  string|null  $chainId
     * @param  CarbonImmutable|null  $untilTime
     * @param  int  $pageCount
     * @return TransactionHistory
     *
     * @throws GuzzleException
     * @throws IllegalParameterException
     */
    public function getTransactionHistory(string $id, ?string $chainId = null, ?CarbonImmutable $untilTime = null, int $pageCount = 20): TransactionHistory
    {
        if ($pageCount < 1 || $pageCount > 20) {
            throw new IllegalParameterException('The page count parameter must be in the range 1 to 20!');
        }

        $untilTimestamp = $untilTime ?? CarbonImmutable::now();

        $params['id'] = $id;
        $params['page_count'] = $pageCount;
        $path = 'user/all_history_list';

        if ($chainId !== null) {
            $params['chain_id'] = $chainId;
            $path = 'user/history_list';
        }

        $breaker = false;
        $history = new TransactionHistory([], [], [], []);
        while (! $breaker) {
            $params['start_time'] = $untilTimestamp->getTimestamp();
            $res = $this->get($path, $params);

            $historyPage = TransactionHistory::fromResponse($res);
            $history = $history->merge($historyPage);

            $breaker = $historyPage->entriesCount() < $pageCount;
            if ($historyPage->entriesCount()) {
                $untilTimestamp = $historyPage->lastEntry()->timeAt;
            }
        }

        return $history;
    }
}
