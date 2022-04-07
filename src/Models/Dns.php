<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property array<int, DnsRecord> $dns_records
 * @property string $ttl
 */
class Dns extends Model
{
    protected array $fillable = [
        'domein',
        'tld',
        'ttl',
        'dns_records',
    ];

    public function find(string $domain, string $tld): Dns
    {
        $result = $this->client->get('dns_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);

        $result = $this->processDnsRecords($result);

        return $this->createObjectFromResponse($result);
    }

    public function updateTtl(string $domain, string $tld, string $ttl): array
    {
        return $this->client->get('dns_ttl_modify', [
            'domein' => $domain,
            'tld' => $tld,
            'ttl' => $ttl,
        ]);
    }

    protected function processDnsRecords(array $result): array
    {
        if (isset($result['items']) && count($result['items'])) {
            $result['dns_records'] = [];

            foreach ($result['items'] as $item) {
                $result['dns_records'][] = new DnsRecord($this->client, $item);
            }
        }

        return $result;
    }
}
