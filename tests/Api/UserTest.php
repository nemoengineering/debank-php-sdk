<?php

namespace Nemo\DeBank\Tests\Api;

use Nemo\DeBank\DeBank;
use Nemo\DeBank\Tests\TestCase;
use Nemo\DeBank\ValueObjects\Chain;
use Nemo\DeBank\ValueObjects\HistoryEntry;

class UserTest extends TestCase
{
    public function testGetChainList()
    {
        // given
        $handler = $this->mockJsonResponse("[\n  {\n    \"id\": \"boba\",\n    \"community_id\": 288,\n    \"name\": \"Boba\",\n    \"native_token_id\": \"boba\",\n    \"logo_url\": \"https://static.debank.com/image/chain/logo_url/boba/e43d79cd8088ceb3ea3e4a240a75728f.png\",\n    \"wrapped_token_id\": \"0xdeaddeaddeaddeaddeaddeaddeaddeaddead0000\"\n  }\n]");
        $client = $this->clientWithHandler($handler);
        $deBank = new DeBank('secret', $client);

        // when
        $result = $deBank->user()->getChainList('0x29D7d1dd5B6f9C864d9db560D72a247c178aE86B');

        // then
        /** @var Chain $first */
        $first = $result[0];

        $this->assertEquals('boba', $first->id);
        $this->assertEquals(288, $first->communityId);
        $this->assertEquals('Boba', $first->name);
        $this->assertEquals('boba', $first->nativeTokenId);
        $this->assertEquals('0xdeaddeaddeaddeaddeaddeaddeaddeaddead0000', $first->wrappedTokenId);
    }

    public function testGetTransactionHistory()
    {
        // given
        $handler = $this->mockJsonResponse("{\n  \"cate_dict\": {\n    \"approve\": {\n      \"id\": \"approve\",\n      \"name\": \"Authorize\"\n    },\n    \"receive\": {\n      \"id\": \"receive\",\n      \"name\": \"Receive\"\n    },\n    \"send\": {\n      \"id\": \"send\",\n      \"name\": \"Send\"\n    }\n  },\n  \"history_list\": [\n    {\n      \"cate_id\": \"send\",\n      \"chain\": \"eth\",\n      \"id\": \"0x403d4d104637442ed98132157319b6a5771a402551c7a1f9a0cbebea201c9930\",\n      \"project_id\": null,\n      \"receives\": [],\n      \"sends\": [\n        {\n          \"amount\": 0.01,\n          \"to_addr\": \"0x4c2e86c04e3829bc6808b9fc87f21350fde5e41c\",\n          \"token_id\": \"0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48\"\n        }\n      ],\n      \"time_at\": 1646634891,\n      \"token_approve\": null,\n      \"tx\": {\n        \"eth_gas_fee\": 0.002296035,\n        \"from_addr\": \"0x5853ed4f26a3fcea565b3fbc698bb19cdf6deb85\",\n        \"name\": \"transfer\",\n        \"params\": [],\n        \"status\": 1,\n        \"to_addr\": \"0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48\",\n        \"usd_gas_fee\": 5.82290548245,\n        \"value\": 0\n      }\n    },\n    {\n      \"cate_id\": \"approve\",\n      \"chain\": \"eth\",\n      \"id\": \"0x8e4245cc567905898b3148d43b9e73e543acdadd180ab7334a97377f9524ce03\",\n      \"other_addr\": \"0xd07e86f68c7b9f9b215a3ca3e79e74bf94d6a847\",\n      \"project_id\": \"daomaker\",\n      \"receives\": [],\n      \"sends\": [],\n      \"time_at\": 1641536066,\n      \"token_approve\": {\n        \"spender\": \"0xd07e86f68c7b9f9b215a3ca3e79e74bf94d6a847\",\n        \"token_id\": \"0x0f51bb10119727a7e5ea3538074fb341f56b09ad\",\n        \"value\": 1000000000000000\n      },\n      \"tx\": {\n        \"eth_gas_fee\": 0.00603421,\n        \"from_addr\": \"0x5853ed4f26a3fcea565b3fbc698bb19cdf6deb85\",\n        \"name\": \"approve\",\n        \"params\": [],\n        \"status\": 1,\n        \"to_addr\": \"0x0f51bb10119727a7e5ea3538074fb341f56b09ad\",\n        \"usd_gas_fee\": 19.2814732656,\n        \"value\": 0\n      }\n    }\n  ],\n  \"project_dict\": {\n    \"zkswap\": {\n      \"chain\": \"eth\",\n      \"id\": \"zkswap\",\n      \"logo_url\": \"https://static.debank.com/image/project/logo_url/zkswap/7686efb3683487e4f96b4c639854c06a.png\",\n      \"name\": \"ZKSwap\",\n      \"site_url\": \"https://zks.app\"\n    }\n  },\n  \"token_dict\": {\n    \"eth\": {\n      \"chain\": \"eth\",\n      \"decimals\": 18,\n      \"display_symbol\": null,\n      \"id\": \"eth\",\n      \"is_core\": true,\n      \"is_verified\": true,\n      \"is_wallet\": true,\n      \"logo_url\": \"https://static.debank.com/image/token/logo_url/eth/935ae4e4d1d12d59a99717a24f2540b5.png\",\n      \"name\": \"ETH\",\n      \"optimized_symbol\": \"ETH\",\n      \"price\": 2536.07,\n      \"protocol_id\": \"\",\n      \"symbol\": \"ETH\",\n      \"time_at\": 1483200000\n    }\n  }\n}");
        $client = $this->clientWithHandler($handler);
        $deBank = new DeBank('secret', $client);

        // when
        $result = $deBank->user()->getTransactionHistory('0x29D7d1dd5B6f9C864d9db560D72a247c178aE86B', pageCount: 3);

        // then
        $this->assertEquals(['id' => 'approve', 'name' => 'Authorize'], $result->categoryDictionary['approve']);
        $this->assertEquals([
            'chain' => 'eth',
            'id' => 'zkswap',
            'logo_url' => 'https://static.debank.com/image/project/logo_url/zkswap/7686efb3683487e4f96b4c639854c06a.png',
            'name' => 'ZKSwap',
            'site_url' => 'https://zks.app',
        ], $result->projectDictionary['zkswap']);
        $this->assertEquals([
            'chain' => 'eth',
            'decimals' => 18,
            'display_symbol' => null,
            'id' => 'eth',
            'is_core' => true,
            'is_verified' => true,
            'is_wallet' => true,
            'logo_url' => 'https://static.debank.com/image/token/logo_url/eth/935ae4e4d1d12d59a99717a24f2540b5.png',
            'name' => 'ETH',
            'optimized_symbol' => 'ETH',
            'price' => 2536.07,
            'protocol_id' => '',
            'symbol' => 'ETH',
            'time_at' => 1483200000,
        ], $result->tokenDictionary['eth']);

        /** @var HistoryEntry $firstEntry */
        $firstEntry = $result->historyList[0];

        $this->assertEquals('send', $firstEntry->categoryId);
        $this->assertEquals('eth', $firstEntry->chain);
        $this->assertEquals('0x403d4d104637442ed98132157319b6a5771a402551c7a1f9a0cbebea201c9930', $firstEntry->id);
        $this->assertNull($firstEntry->projectId);
        $this->assertEquals([[
            'amount' => 0.01,
            'to_addr' => '0x4c2e86c04e3829bc6808b9fc87f21350fde5e41c',
            'token_id' => '0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48',
        ]], $firstEntry->sends);
        $this->assertEquals([], $firstEntry->receives);
        $this->assertNull($firstEntry->tokenApprove);
        $this->assertEquals([
            'eth_gas_fee' => 0.002296035,
            'from_addr' => '0x5853ed4f26a3fcea565b3fbc698bb19cdf6deb85',
            'name' => 'transfer',
            'params' => [],
            'status' => 1,
            'to_addr' => '0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48',
            'usd_gas_fee' => 5.82290548245,
            'value' => 0,
        ], $firstEntry->tx);
    }
}
