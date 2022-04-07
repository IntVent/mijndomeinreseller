<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property string $transfer_id
 * @property string $domein
 * @property string $status
 * @property string $tld
 * @property string $status_melding
 * @property string $datum_invoer
 * @property string $datum_update
 * @property string $status_melding_count
 * @property string $status_datum
 */
class Transfer extends Model
{
    protected array $fillable = [
        'transfer_id',
        'domein',
        'status',
        'tld',
        'status_melding',
        'datum_invoer',
        'datum_update',
        'status_melding_count',
        'status_datum',
    ];

    /**
     * @return array|bool
     */
    public function get(array $attributes = [])
    {
        $this->fill($attributes);

        $result = $this->client->get('transfer_list', [
            'status' => $this->status,
            'domein' => $this->domein,
            'tld' => $this->tld,
        ]);

        if ($result['transfercount'] > 0) {
            return $result['items'];
        }

        return false;
    }

    public function find(string $id): array
    {
        $result = $this->client->get('transfer_details', [
            'transfer_id' => $id,
        ]);

        return $result['items'];
    }
}
