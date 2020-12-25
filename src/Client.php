<?php

namespace IntVent\MijnDomeinReseller;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use IntVent\MijnDomeinReseller\Exceptions\ApiException;
use IntVent\MijnDomeinReseller\Models\Contact;
use IntVent\MijnDomeinReseller\Models\Dns;
use IntVent\MijnDomeinReseller\Models\DnsRecord;
use IntVent\MijnDomeinReseller\Models\DnsSec;
use IntVent\MijnDomeinReseller\Models\DnsSecRecord;
use IntVent\MijnDomeinReseller\Models\Domain;
use IntVent\MijnDomeinReseller\Models\Nameserver;
use IntVent\MijnDomeinReseller\Models\Templates;
use IntVent\MijnDomeinReseller\Models\Tld;
use IntVent\MijnDomeinReseller\Models\Transfer;
use IntVent\MijnDomeinReseller\Models\Whois;

class Client
{
    protected string $apiUrl = 'https://manager.mijndomeinreseller.nl/api/';
    protected GuzzleClient $client;
    protected string $username;
    protected string $password;
    protected array $responseData;

    /**
     * Client constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = md5($password);
        $this->client = new GuzzleClient([
            'http_errors' => true,
        ]);
    }

    public function get(string $command, array $additionalParams = [])
    {
        $this->responseData = $additionalParams;

        $request = $this->createRequest($command, $additionalParams);
        $response = $this->client->send($request);

        return $this->parseResponse($response);
    }

    public function put(string $command, array $attributes)
    {
        $request = $this->createRequest($command, $attributes);
        $response = $this->client->send($request);

        return $this->parseResponse($response);
    }

    public function createRequest(string $command, array $additionalParams = [], $method = 'GET')
    {
        $url = $this->generateUrl($command, $additionalParams);

        $request = new Request($method, $url);

        return $request;
    }

    public function generateUrl($command, array $additionalParams = [])
    {
        $params = [
            'user' => $this->username,
            'pass' => $this->password,
            'authtype' => 'md5',
            'command' => $command,
        ];

        $params = array_merge($params, $additionalParams);

        return $this->apiUrl . '?' . http_build_query($params);
    }

    public function parseResponse(Response $response)
    {
        try {
            $content = $response->getBody()->getContents();

            $lines = explode(PHP_EOL, $content);

            if ($lines && $this->parseResponseLines($lines)) {
                return $this->responseData;
            } else {
                throw new ApiException('No response');
            }
        } catch (Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function parseResponseLines(array $lines)
    {
        $errors = [];

        foreach ($lines as $line) {
            $exp = explode('=', $line, 2);

            if (count($exp) == 2) {
                if (strpos($exp[0], 'errnotxt') === 0) {
                    $errors[] = $exp[1];
                } elseif ($exp[0] != 'errcount' && $exp[0] != 'done' && strpos($exp[0], 'errno') === false) {
                    $this->parseLine($exp);
                }
            }
        }

        if (! $errors) {
            return true;
        } else {
            throw new ApiException(implode('|', $errors));
        }
    }

    public function parseLine(array $line)
    {
        if (preg_match('/^([A-Za-z_]+)\[(\d+)\]/', $line[0], $matches) && count($matches) == 3) {
            $this->responseData['items'][$matches[2]][$matches[1]] = trim($line[1]);
        } else {
            $this->responseData[$line[0]] = trim($line[1]);
        }
    }

    /**
     * @param array $attributes
     *
     * @return Contact
     */
    public function contact(array $attributes = [])
    {
        return new Contact($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Dns
     */
    public function dns(array $attributes = [])
    {
        return new Dns($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return DnsRecord
     */
    public function dnsRecord(array $attributes = [])
    {
        return new DnsRecord($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return DnsSec
     */
    public function dnsSec(array $attributes = [])
    {
        return new DnsSec($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return DnsSecRecord
     */
    public function dnsSecRecord(array $attributes = [])
    {
        return new DnsSecRecord($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Domain
     */
    public function domain(array $attributes = [])
    {
        return new Domain($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Nameserver
     */
    public function nameserver(array $attributes = [])
    {
        return new Nameserver($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Templates
     */
    public function templates(array $attributes = [])
    {
        return new Templates($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Tld
     */
    public function tld(array $attributes = [])
    {
        return new Tld($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Transfer
     */
    public function transfer(array $attributes = [])
    {
        return new Transfer($this, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Whois
     */
    public function whois(array $attributes = [])
    {
        return new Whois($this, $attributes);
    }
}
