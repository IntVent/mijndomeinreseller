<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
 * @property string $tld
 * @property string $prijs_registratie
 * @property string $prijs_registratie_munt
 * @property string $prijs_verhuizing
 * @property string $prijs_verhuizing_munt
 * @property string $prijs_verlenging
 * @property string $prijs_verlenging_munt
 * @property string $munt_wisselkoers
 * @property string $lengte_min
 * @property string $lengte_max
 * @property string $jaar_min
 * @property string $jaar_max
 * @property string $registreren
 * @property string $verhuizen
 */
class Tld extends Model
{
    protected array $fillable = [
        'tld',
        'prijs_registratie',
        'prijs_registratie_munt',
        'prijs_verhuizing',
        'prijs_verhuizing_munt',
        'prijs_verlenging',
        'prijs_verlenging_munt',
        'munt_wisselkoers',
        'lengte_min',
        'lengte_max',
        'jaar_min',
        'jaar_max',
        'registreren',
        'verhuizen',
    ];

    /**
     * @return array|bool
     */
    public function get()
    {
        if ($result = $this->client->get('tld_list')) {
            return $result['items'];
        }

        return false;
    }

    public function find(string $tld): self
    {
        $result = $this->client->get('tld_get_details', [
            'tld' => $tld,
        ]);

        if (! isset($result['tld'])) {
            $result['tld'] = $tld;
        }

        return $this->createObjectFromResponse($result);
    }
}
