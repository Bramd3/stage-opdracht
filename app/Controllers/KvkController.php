<?php

namespace App\Controllers;

use App\Models\KvkModel;
use CodeIgniter\API\ResponseTrait;

class KvkController extends BaseController
{
    use ResponseTrait;

    public function fetchData()
    {
        $request = service('request');
        $searchQuery = $request->getGet('q'); // Zoeken op naam of KVK-nummer

        if (!$searchQuery) {
            return $this->fail("Voer een naam of KVK-nummer in als zoekopdracht.", 400);
        }

        $url = "https://api.kvk.nl/test/api/v2/zoeken?naam={$searchQuery}";
        $apiKey = "l7xx1f2691f2520d487b902f4e0b57a0b197";

        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url, [
            'headers' => [
                'apikey' => $apiKey,
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return $this->fail("API-verzoek mislukt", $response->getStatusCode());
        }

        $data = json_decode($response->getBody(), true);
        if (!isset($data['resultaten']) || empty($data['resultaten'])) {
            return $this->failNotFound("Geen resultaten gevonden voor: $searchQuery");
        }

        $kvkModel = new KvkModel();

        foreach ($data['resultaten'] as $item) {
            $kvkModel->insert([
                'kvk_number' => $item['kvkNummer'] ?? null,
                'branch_number' => $item['vestigingsnummer'] ?? null,
                'trade_name' => $item['naam'] ?? null,
                'business_activity' => isset($item['sbiActiviteiten']) ? json_encode($item['sbiActiviteiten']) : null
            ]);
        }

        return $this->respond([
            'message' => "Data opgehaald en opgeslagen voor: $searchQuery",
            'results' => $data['resultaten']
        ]);
    }
}
 