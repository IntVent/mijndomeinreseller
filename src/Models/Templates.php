<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property string $template
 * @property string $template_id
 * @property string $template_name
 * @property string $dupliceer
 * @property string $record_id
 * @property string $type
 * @property string $host
 * @property string $address
 * @property string $priority
 * @property string $weight
 * @property string $port
 * @property string $ttl
 */
class Templates extends Model
{
    protected array $fillable = [
        'template',
        'template_id',
        'template_name',
        'dupliceer',
        'record_id',
        'type',
        'host',
        'address',
        'priority',
        'weight',
        'port',
        'ttl',
    ];

    /**
     * @return array|bool
     */
    public function get()
    {
        if ($result = $this->client->get('dns_template_list')) {
            return $result['items'];
        }

        return false;
    }

    /**
     * @param string $id
     */
    public function find(string $id): array
    {
        return $this->client->get('dns_template_get_details', [
            'template_id' => $id,
        ]);
    }

    public function add(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_add', $this->attributes);
    }

    public function modify(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_modify_name', $this->attributes);
    }

    public function del(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_del', $this->attributes);
    }

    public function create(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_record_add', $this->attributes);
    }

    public function update(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_record_modify', $this->attributes);
    }

    public function remove(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_record_del', $this->attributes);
    }

    public function ttl(array $attributes = []): array
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_ttl_modify', $this->attributes);
    }
}
