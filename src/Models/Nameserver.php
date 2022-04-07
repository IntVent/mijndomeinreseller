<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property string $ns_id
 * @property string $auto
 * @property string $ns1
 * @property string $ns1_ip
 * @property string $ns2
 * @property string $ns2_ip
 * @property string $ns3
 * @property string $ns3_ip
 * @property string $ns4
 * @property string $ns4_ip
 * @property string $ns5
 * @property string $ns5_ip
 * @property string $ns6
 * @property string $ns6_ip
 * @property string $ns7
 * @property string $ns7_ip
 */
class Nameserver extends Model
{
    protected array $fillable = [
        'ns_id',
        'auto',
        'ns1',
        'ns1_ip',
        'ns2',
        'ns2_ip',
        'ns3',
        'ns3_ip',
        'ns4',
        'ns4_ip',
        'ns5',
        'ns5_ip',
        'ns6',
        'ns6_ip',
        'ns7',
        'ns7_ip',
    ];

    /**
     * @return array|bool
     */
    public function get()
    {
        if ($result = $this->client->get('nameserver_list')) {
            return $result['items'];
        }

        return false;
    }

    public function create(array $attributes): array
    {
        $this->fill($attributes);

        $result = $this->client->put('nameserver_add', $this->attributes);

        if (isset($result['ns_id'])) {
            $this->ns_id = $result['ns_id'];
        }

        return $result;
    }
}
