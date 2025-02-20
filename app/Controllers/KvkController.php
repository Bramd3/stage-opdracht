<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\Models\KvkModel;

class KvkController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        // Ophalen van zoekterm via GET (bijvoorbeeld ?q=69599084)
        $searchQuery = $this->request->getGet('q');

        if (!$searchQuery || !is_numeric($searchQuery)) {
            return view('home', ['error' => 'Voer een geldig KVK-nummer in.']);
        }

        // API URL en sleutel
        $url = "https://api.kvk.nl/test/api/v1/basisprofielen/{$searchQuery}";
        $apiKey = "l7xx1f2691f2520d487b902f4e0b57a0b197";

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'apikey' => $apiKey,
                    'X-Requested-With' => 'XMLHttpRequest'
                ]
            ]);

            // Controleer of de API een succesvolle respons geeft
            if ($response->getStatusCode() !== 200) {
                return view('home', ['error' => 'API-verzoek mislukt. Statuscode: ' . $response->getStatusCode()]);
            }

            // Decodeer de JSON-respons
            $data = json_decode($response->getBody(), true);

            // Controleer of de API een foutmelding geeft
            if (isset($data['fout'])) {
                return view('home', ['error' => "API-fout: " . $data['fout'][0]['omschrijving']]);
            }

            // Als er geen resultaat is gevonden
            if (!isset($data['kvkNummer'])) {
                return view('home', ['error' => "Geen resultaten gevonden voor KVK-nummer: $searchQuery"]);
            }

            // Stuur de resultaten naar de view
            return view('home', ['result' => $data]);

        } catch (\Exception $e) {
            log_message('error', 'API Error: ' . $e->getMessage());
            return view('home', ['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
    }
}
