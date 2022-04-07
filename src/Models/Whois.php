<?php

namespace IntVent\MijnDomeinReseller\Models;

class Whois extends Model
{
    /**
     * Advanced domain whois.
     */
    public function advanced(string $domain): string
    {
        $result = $this->client->get('whois', [
            'type' => 'uitgebreid',
            'domein' => $domain,
        ]);

        return $this->formatAdvancedWhoisResult($result['result']);
    }

    /**
     * Check for available domains.
     *
     * @param array<int,string> $domains
     */
    public function bulk(array $domains): array
    {
        return $this->client->get('whois', [
            'type' => 'bulk',
            'domeinen' => implode(';', $domains),
        ]);
    }

    /**
     * Retrieve information from internal registered domain.
     */
    public function internal(string $domain): array
    {
        return $this->client->get('whois', [
            'type' => 'intern',
            'domein' => $domain,
        ]);
    }

    private function formatAdvancedWhoisResult(string $result): string
    {
        return urldecode($result);
    }
}
