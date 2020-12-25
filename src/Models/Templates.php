<?php

namespace IntVent\MijnDomeinReseller\Models;

class Templates extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
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
     * @return bool
     */
    public function get()
    {
        if ($result = $this->client->get('dns_template_list')) {
            return $result['items'];
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->client->get('dns_template_get_details', [
            'template_id' => $id,
        ]);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function add(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_add', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function modify(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_modify_name', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function del(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_del', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_record_add', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function update(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_record_modify', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function remove(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_record_del', $this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function ttl(array $attributes = [])
    {
        $this->fill($attributes);

        return $this->client->put('dns_template_ttl_modify', $this->attributes);
    }
}
