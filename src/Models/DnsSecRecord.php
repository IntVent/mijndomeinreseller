<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property string $flag
 * @property string $algorithm
 * @property string $publickey
 * @property string $record_id
 */
class DnsSecRecord extends Model
{
    protected array $fillable = [
        'domein',
        'tld',
        'flag',
        'algorithm',
        'publickey',
        'record_id',
    ];

    public function find(string $domain, string $tld): array
    {
        return $this->client->get('dnssec_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);
    }

    public function create(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dnssec_record_add', $this->attributes);
    }

    public function update(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dnssec_record_modify', $this->attributes);
    }

    public function remove(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dnssec_record_del', $this->attributes);
    }
}
