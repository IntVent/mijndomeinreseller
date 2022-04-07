<?php

namespace IntVent\MijnDomeinReseller\Models;

use IntVent\MijnDomeinReseller\Client;

abstract class Model
{
    protected array $attributes = [];
    protected array $fillable = [];
    protected Client $client;

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

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function createObjectFromResponse(array $result): static
    {
        $modelName = get_class($this);

        return new $modelName($this->client, $result);
    }

    /**
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, $value): void
    {
        if ($this->isFillable($key)) {
            $this->attributes[$key] = $value;
        }
    }

    protected function fill(array $attributes = []): void
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    protected function isFillable(string $key): bool
    {
        return in_array($key, $this->fillable, true);
    }
}
