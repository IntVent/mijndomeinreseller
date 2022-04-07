<?php

namespace IntVent\MijnDomeinReseller\Models;

use InvalidArgumentException;

/**
 * @property string $domein
 * @property string $tld
 * @property string $registrant_id
 * @property string $registrant_bedrijfsnaam
 * @property string $registrant_rechtsvorm
 * @property string $registrant_regnummer
 * @property string $registrant_voorletter
 * @property string $registrant_tussenvoegsel
 * @property string $registrant_achternaam
 * @property string $registrant_straat
 * @property string $registrant_huisnr
 * @property string $registrant_huisnrtoev
 * @property string $registrant_postcode
 * @property string $registrant_plaats
 * @property string $registrant_land
 * @property string $registrant_tel
 * @property string $registrant_email
 * @property string $admin_id
 * @property string $admin_bedrijfsnaam
 * @property string $admin_rechtsvorm
 * @property string $admin_regnummer
 * @property string $admin_voorletter
 * @property string $admin_tussenvoegsel
 * @property string $admin_achternaam
 * @property string $admin_straat
 * @property string $admin_huisnr
 * @property string $admin_huisnrtoev
 * @property string $admin_postcode
 * @property string $admin_plaats
 * @property string $admin_land
 * @property string $admin_tel
 * @property string $admin_email
 * @property string $tech_id
 * @property string $tech_bedrijfsnaam
 * @property string $tech_rechtsvorm
 * @property string $tech_regnummer
 * @property string $tech_voorletter
 * @property string $tech_tussenvoegsel
 * @property string $tech_achternaam
 * @property string $tech_straat
 * @property string $tech_huisnr
 * @property string $tech_huisnrtoev
 * @property string $tech_postcode
 * @property string $tech_plaats
 * @property string $tech_land
 * @property string $tech_tel
 * @property string $tech_email
 * @property string $tld_es_admin_type_id
 * @property string $tld_es_admin_idnum
 * @property string $tld_es_tech_type_id
 * @property string $tld_es_tech_idnum
 * @property string $tld_es_bill_type_id
 * @property string $tld_es_bill_idnum
 * @property string $bill_id
 * @property string $autorenew
 * @property string $lock
 * @property string $ns_id
 * @property string $ns1
 * @property string $ns2
 * @property string $ns3
 * @property string $ns4
 * @property string $ns5
 * @property string $ns6
 * @property string $ns7
 * @property string $gebruik_dns
 * @property string $dns_template
 * @property string $authkey
 * @property string $verloopdatum
 * @property string $inaccountdatum
 * @property string $status
 * @property string $duur
 * @property string $datum
 * @property string $transfer_id
*/
class Domain extends Model
{
    protected array $fillable = [
        'domains',
        'registrant_id',
        'registrant_bedrijfsnaam',
        'registrant_rechtsvorm',
        'registrant_regnummer',
        'registrant_voorletter',
        'registrant_tussenvoegsel',
        'registrant_achternaam',
        'registrant_straat',
        'registrant_huisnr',
        'registrant_huisnrtoev',
        'registrant_postcode',
        'registrant_plaats',
        'registrant_land',
        'registrant_tel',
        'registrant_email',
        'admin_id',
        'admin_bedrijfsnaam',
        'admin_rechtsvorm',
        'admin_regnummer',
        'admin_voorletter',
        'admin_tussenvoegsel',
        'admin_achternaam',
        'admin_straat',
        'admin_huisnr',
        'admin_huisnrtoev',
        'admin_postcode',
        'admin_plaats',
        'admin_land',
        'admin_tel',
        'admin_email',
        'tech_id',
        'tech_bedrijfsnaam',
        'tech_rechtsvorm',
        'tech_regnummer',
        'tech_voorletter',
        'tech_tussenvoegsel',
        'tech_achternaam',
        'tech_straat',
        'tech_huisnr',
        'tech_huisnrtoev',
        'tech_postcode',
        'tech_plaats',
        'tech_land',
        'tech_tel',
        'tech_email',
        'tld_es_admin_type_id',
        'tld_es_admin_idnum',
        'tld_es_tech_type_id',
        'tld_es_tech_idnum',
        'tld_es_bill_type_id',
        'tld_es_bill_idnum',
        'bill_id',
        'domein',
        'tld',
        'autorenew',
        'lock',
        'ns_id',
        'ns1',
        'ns2',
        'ns3',
        'ns4',
        'ns5',
        'ns6',
        'ns7',
        'gebruik_dns',
        'dns_template',
        'authkey',
        'verloopdatum',
        'inaccountdatum',
        'status',
        'duur',
        'datum',
        'transfer_id',
    ];

    public function get(): array
    {
        $result = $this->client->get('domain_list');

        if (isset($result['items'])) {
            $result = $this->processDomains($result);

            return $result['items'];
        }

        return [];
    }

    public function getDeleted(): array
    {
        $result = $this->client->get('domain_list_delete');

        if (isset($result['items'])) {
            $result = $this->processDomains($result);

            return $result['items'];
        }

        return [];
    }

    public function find(string $domain, string $tld): self
    {
        $result = $this->client->get('domain_get_details', [
            'domein' => $domain,
            'tld' => $tld,
        ]);

        return $this->createObjectFromResponse($result);
    }

    public function register(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->put('domain_register', $this->attributes);
        }

        throw new InvalidArgumentException();
    }

    public function transfer(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->put('domain_transfer', $this->attributes);
        }

        throw new InvalidArgumentException();
    }

    public function delete(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->put('domain_delete', [
                'domein' => $this->domein,
                'tld' => $this->tld,
            ]);
        }

        throw new InvalidArgumentException();
    }

    public function authInfo(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->get('domain_auth_info', [
                'domein' => $this->domein,
                'tld' => $this->tld,
            ]);
        }

        throw new InvalidArgumentException();
    }

    public function updateContacts(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->get('domain_modify_contacts', $this->attributes);
        }

        throw new InvalidArgumentException();
    }

    public function trade(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->get('domain_trade', $this->attributes);
        }

        throw new InvalidArgumentException();
    }

    public function updateNameservers(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->get('domain_modify_ns', $this->attributes);
        }

        throw new InvalidArgumentException();
    }

    public function pushRequest(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld && $this->authkey) {
            return $this->client->get('domain_push_request', [
                'domein' => $this->domein,
                'tld' => $this->tld,
                'authkey' => $this->authkey,
            ]);
        }

        throw new InvalidArgumentException();
    }

    public function renew(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld && $this->duur) {
            return $this->client->get('domain_renew', [
                'domein' => $this->domein,
                'tld' => $this->tld,
                'duur' => $this->duur,
            ]);
        }

        throw new InvalidArgumentException();
    }

    public function restore(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld) {
            return $this->client->get('domain_restore', [
                'domein' => $this->domein,
                'tld' => $this->tld,
            ]);
        }

        throw new InvalidArgumentException();
    }

    public function setAutoRenew(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld && $this->autorenew) {
            return $this->client->get('domain_set_autorenew', [
                'domein' => $this->domein,
                'tld' => $this->tld,
                'autorenew' => $this->autorenew,
                'registrant_approve' => $this->registrant_approve,
            ]);
        }

        throw new InvalidArgumentException();
    }

    public function setLock(array $attributes = []): array
    {
        $this->fill($attributes);

        if ($this->domein && $this->tld && $this->set_lock) {
            return $this->client->get('domain_set_lock', [
                'domein' => $this->domein,
                'tld' => $this->tld,
                'set_lock' => $this->set_lock,
            ]);
        }

        throw new InvalidArgumentException();
    }

    protected function processDomains(array $result): array
    {
        if (isset($result['items']) && count($result['items'])) {
            foreach ($result['items'] as $id => $item) {
                $result['items'][$id] = new self($this->client, $item);
            }
        }

        return $result;
    }
}
