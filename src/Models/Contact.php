<?php

namespace IntVent\MijnDomeinReseller\Models;

/**
* @property string $contact_id
* @property string $contact_bedrijfsnaam
* @property string $contact_rechtsvorm
* @property string $contact_regnummer
* @property string $contact_voornaam
* @property string $contact_voorletter
* @property string $contact_tussenvoegsel
* @property string $contact_achternaam
* @property string $contact_straat
* @property string $contact_huisnr
* @property string $contact_huisnrtoev
* @property string $contact_postcode
* @property string $contact_plaats
* @property string $contact_land
* @property string $contact_email
* @property string $contact_tel
* @property string $contact_tel_land
* @property string $contact_kvknr
* @property string $bedrijfsnaam
* @property string $rechtsvorm
* @property string $regnummer
* @property string $btwnummer
* @property string $voorletter
* @property string $tussenvoegsel
* @property string $achternaam
* @property string $straat
* @property string $huisnr
* @property string $huisnrtoev
* @property string $postcode
* @property string $plaats
* @property string $land
* @property string $tel_land
* @property string $tel
* @property string $email
 */
class Contact extends Model
{
    protected array $fillable = [
        'contact_id',
        'contact_bedrijfsnaam',
        'contact_rechtsvorm',
        'contact_regnummer',
        'contact_voornaam',
        'contact_voorletter',
        'contact_tussenvoegsel',
        'contact_achternaam',
        'contact_straat',
        'contact_huisnr',
        'contact_huisnrtoev',
        'contact_postcode',
        'contact_plaats',
        'contact_land',
        'contact_email',
        'contact_tel',
        'contact_tel_land',
        'contact_kvknr',

        'bedrijfsnaam',
        'rechtsvorm',
        'regnummer',
        'btwnummer',
        'voorletter',
        'tussenvoegsel',
        'achternaam',
        'straat',
        'huisnr',
        'huisnrtoev',
        'postcode',
        'plaats',
        'land',
        'tel_land',
        'tel',
        'email',
    ];

    /**
     * @return bool|array
     */
    public function get()
    {
        if ($result = $this->client->get('contact_list')) {
            return $result['items'];
        }

        return false;
    }

    public function find(string $id): self
    {
        $result = $this->client->get('contact_get_details', [
            'contact_id' => $id,
        ]);

        if (! isset($result['contact_id'])) {
            $result['contact_id'] = $id;
        }

        return $this->createObjectFromResponse($result);
    }

    public function create(array $attributes): array
    {
        $this->fill($attributes);

        $result = $this->client->put('contact_add', $this->attributes);

        if (isset($result['contact_id'])) {
            $this->contact_id = $result['contact_id'];
        }

        return $result;
    }
}
