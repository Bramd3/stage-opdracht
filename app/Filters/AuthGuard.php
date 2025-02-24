<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    // Methode die wordt uitgevoerd voordat de aanvraag wordt verwerkt
    public function before(RequestInterface $request, $arguments = null)
    {
        // Lijst van toegestane routes die geen authenticatie vereisen
        $allowedRoutes = ['login', 'register', 'loginProcess', 'registerProcess']; 

        // Haal de huidige route op die wordt benaderd
        $currentRoute = service('router')->getMatchedRoute()[0] ?? service('uri')->getPath();

        // Controleer of de gebruiker ingelogd is en of de huidige route niet in de toegestane lijst staat
        if (!session()->get('logged_in') && !in_array($currentRoute, $allowedRoutes)) {
            // Redirect naar de inlogpagina als de gebruiker niet is ingelogd en een beveiligde pagina probeert te openen
            return redirect()->to('/login');
        }
    }

    // Methode die wordt uitgevoerd na de response
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Geen verdere actie nodig na het versturen van de response
    }
}
