<?php

namespace IntVent\MijnDomeinReseller\Models;

use IntVent\MijnDomeinReseller\Client;

abstract class Model
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * Model constructor.
     *
     * @param Client $client
     * @param array $attributes
     */
    public function __construct(Client $client, array $attributes = [])
    {
        $this->client = $client;
        $this->fill($attributes);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $result
     *
     * @return mixed
     */
    public function createObjectFromResponse($result)
    {
        $modelName = get_class($this);

        $model = new $modelName($this->client, $result);

        return $model;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        if ($this->isFillable($key)) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * @param array $attributes
     */
    protected function fill(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * @param $key
     * @return bool
     */
    protected function isFillable($key)
    {
        return in_array($key, $this->fillable);
    }
}
