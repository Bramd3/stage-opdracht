<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\SearchHistoryModel;
use App\Libraries\KvkService;
use CodeIgniter\RESTful\ResourceController;

class CompanyController extends ResourceController
{
    private $kvkService;
    private $companyModel;
    private $searchHistoryModel;

    public function __construct()
    {
        $this->kvkService = new KvkService();
        $this->companyModel = new CompanyModel();
        $this->searchHistoryModel = new SearchHistoryModel();
    }

    public function search()
    {
        $query = $this->request->getGet('query');

        if (!$query) {
            return $this->fail('Geen zoekterm opgegeven.', 400);
        }

        // KVK API aanroepen
        $results = $this->kvkService->searchCompany($query);

        if (!isset($results['items']) || empty($results['items'])) {
            return $this->failNotFound('Geen resultaten gevonden.');
        }

        // Zoekresultaten opslaan in database
        foreach ($results['items'] as $item) {
            $companyData = [
                'kvk_nummer' => $item['kvkNummer'],
                'bedrijfsnaam' => $item['handelsnaam'],
                'adres' => $item['straatnaam'] . ' ' . $item['huisnummer'] . ', ' . $item['plaats']
            ];

            // Opslaan als het nog niet bestaat
            if (!$this->companyModel->find($companyData['kvk_nummer'])) {
                $this->companyModel->insert($companyData);
            }

            $this->searchHistoryModel->insert($companyData);
        }

        return $this->respond($results);
    }

    public function getCompany($kvkNummer)
    {
        $company = $this->companyModel->find($kvkNummer);
        if (!$company) {
            return $this->failNotFound('Bedrijf niet gevonden.');
        }

        return $this->respond($company);
    }
}
