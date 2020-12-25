<?php

namespace IntVent\MijnDomeinReseller\Tests;

use IntVent\MijnDomeinReseller\Client;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    /** @test */
    public function connection_failes_with_false_credentials()
    {
        $this->expectException(\IntVent\MijnDomeinReseller\Exceptions\ApiException::class);

        $client = new Client('test', 'test');
        $client->get('domain_list');
    }
}
