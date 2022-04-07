<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property string $record_id
 * @property string $type
 * @property string $host
 * @property string $address
 * @property string $priority
 * @property string $weight
 * @property string $port
 */
class DnsRecord extends Model
{
    protected array $fillable = [
        'domein',
        'tld',
        'ttl',
        'record_id',
        'type',
        'host',
        'address',
        'priority',
        'weight',
        'port',
    ];

    public function find(string $domain, string $tld): array
    {
        return $this->client->get('dns_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);
    }

    public function create(array $attributes): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_record_add', $this->attributes);
    }

    public function update(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_record_modify', $this->attributes);
    }

    public function ttl(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_ttl_modify', $this->attributes);
    }

    public function remove(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_record_del', $this->attributes);
    }
}
