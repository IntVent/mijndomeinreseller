<?php

namespace IntVent\MijnDomeinReseller\Models;

class DnsRecord extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
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

    /**
     * @param $domain
     * @param $tld
     *
     * @return array
     */
    public function find($domain, $tld)
    {
        return $this->client->get('dns_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes)
    {
        $this->fill($attributes);

        return $this->client->put('dns_record_add', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function update(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_record_modify', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function ttl(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_ttl_modify', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function remove(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_record_del', $this->attributes);
    }
}
