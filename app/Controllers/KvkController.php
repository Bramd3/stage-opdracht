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
        $searchQuery = $this->request->getGet('q'); // Haal zoekopdracht op uit de GET-request

        if (!$searchQuery) {
            return view('home', ['error' => 'Voer een KVK-nummer in als zoekopdracht.']);
        }

        $url = "https://api.kvk.nl/test/api/v1/basisprofielen/" . urlencode($searchQuery);
        $apiKey = getenv('KVK_API_KEY'); // Haal API-key veilig op uit .env

        try {
            $client = \Config\Services::curlrequest(); // CodeIgniter cURL service
            $response = $client->request('GET', $url, [
                'headers' => [
                    'apikey' => $apiKey,
                    'X-Requested-With' => 'XMLHttpRequest'
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                return view('home', ['error' => 'De KVK API is tijdelijk niet beschikbaar. Probeer het later opnieuw.']);
            }

            $data = json_decode($response->getBody(), true); // Decode JSON-response

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

            return view('home', ['results' => [$data]]);
        } catch (\Exception $e) {
            log_message('error', 'API Error: ' . $e->getMessage()); // Log eventuele fouten
            return view('home', ['error' => 'Er is een probleem opgetreden met de API. Probeer het later opnieuw.']);
        }
    }

    public function show($kvkNummer)
    {
        $url = "https://api.kvk.nl/test/api/v1/basisprofielen/" . urlencode($kvkNummer);
        $apiKey = getenv('KVK_API_KEY');

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'apikey' => $apiKey,
                    'X-Requested-With' => 'XMLHttpRequest'
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                return view('company_detail', ['error' => 'Bedrijfsinformatie kon niet worden opgehaald.']);
            }

            $data = json_decode($response->getBody(), true);

            // Haal adresgegevens op, controleer of ze beschikbaar zijn
            $hoofdvestiging = $data['_embedded']['hoofdvestiging'] ?? null;
            $adres = $hoofdvestiging ? ($hoofdvestiging['straatnaam'] ?? 'Onbekend') . ' ' . 
                                    ($hoofdvestiging['huisnummer'] ?? '') . ', ' .
                                    ($hoofdvestiging['postcode'] ?? 'Onbekend') . ' ' .
                                    ($hoofdvestiging['plaats'] ?? 'Onbekend') : 'Adres niet beschikbaar';

            return view('company_detail', ['company' => $data, 'adres' => $adres]);
        } catch (\Exception $e) {
            log_message('error', 'API Error: ' . $e->getMessage());
            return view('company_detail', ['error' => 'Er is een fout opgetreden bij het ophalen van de gegevens.']);
        }
    }

}
