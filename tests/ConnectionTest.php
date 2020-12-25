<?php

namespace IntVent\MijnDomeinReseller\Tests;

use IntVent\MijnDomeinReseller\Client;
use IntVent\MijnDomeinReseller\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    /** @test */
    public function connection_fails_with_false_credentials()
    {
        $this->expectException(ApiException::class);

        $client = new Client('test', 'test');
        $client->get('domain_list');
    }
}
