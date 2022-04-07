<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property array<int, DnsSecRecord> $dnssec_records
 */
class DnsSec extends Model
{
    protected array $fillable = [
        'domein',
        'tld',
        'dnssec_records',
    ];

    public function find(string $domain, string $tld): self
    {
        $result = $this->client->get('dnssec_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);

        $result = $this->processDnsSecRecords($result);

        return $this->createObjectFromResponse($result);
    }

    protected function processDnsSecRecords(array $result): array
    {
        if (isset($result['items']) && count($result['items'])) {
            $result['dnssec_records'] = [];

            foreach ($result['items'] as $item) {
                $result['dnssec_records'][] = new DnsSecRecord($this->client, $item);
            }
        }

        return $result;
    }
}
