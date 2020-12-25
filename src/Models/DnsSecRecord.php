<?php

namespace IntVent\MijnDomeinReseller\Models;

class DnsSecRecord extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'domein',
        'tld',
        'flag',
        'algorithm',
        'publickey',
        'record_id',
    ];

    /**
     * @param $domain
     * @param $tld
     *
     * @return array
     */
    public function find($domain, $tld)
    {
        return $this->client->get('dnssec_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dnssec_record_add', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function update(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dnssec_record_modify', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function remove(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dnssec_record_del', $this->attributes);
    }
}
