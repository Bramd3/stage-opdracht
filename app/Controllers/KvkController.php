<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\Models\SearchHistoryModel;

class KvkController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $searchQuery = $this->request->getGet('q');

        if (!$searchQuery) {
            return view('home', ['error' => 'Voer een KVK-nummer in als zoekopdracht.']);
        }

        $url = "https://api.kvk.nl/test/api/v1/basisprofielen/" . urlencode($searchQuery);
        $apiKey = "l7xx1f2691f2520d487b902f4e0b57a0b197";

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'apikey' => $apiKey,
                    'X-Requested-With' => 'XMLHttpRequest'
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                return view('home', ['error' => 'API-verzoek mislukt. Statuscode: ' . $response->getStatusCode()]);
            }

            $data = json_decode($response->getBody(), true);

            if (!isset($data['kvkNummer'])) {
                return view('home', ['error' => "Geen resultaten gevonden voor: $searchQuery"]);
            }

            // Opslaan in de database
            $historyModel = new SearchHistoryModel();
            $historyModel->insert([
                'kvk_number'       => $data['kvkNummer'],
                'branch_number'    => $data['_embedded']['hoofdvestiging']['vestigingsnummer'] ?? null,
                'trade_name'       => $data['naam'] ?? null,
                'business_activity'=> $data['sbiActiviteiten'][0]['sbiOmschrijving'] ?? null,
            ]);

            // Resultaat tonen op het scherm
            return view('home', ['results' => [$data]]);
        } catch (\Exception $e) {
            log_message('error', 'API Error: ' . $e->getMessage());
            return view('home', ['error' => 'Er is een fout opgetreden: ' . $e->getMessage()]);
        }
    }
}
