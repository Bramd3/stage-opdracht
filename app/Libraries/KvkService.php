<?php

namespace App\Libraries;

use App\Config\KvkConfig;
use CodeIgniter\Config\Services;

class KvkService
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $config = new KvkConfig();
        $this->apiUrl = $config->apiUrl;
        $this->apiKey = $config->apiKey;
    }

    public function searchCompany($query)
    {
        $client = Services::curlrequest();
        $response = $client->get($this->apiUrl . "?q=" . urlencode($query), [
            'headers' => [
                'apikey' => $this->apiKey,
                'Accept' => 'application/json'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}