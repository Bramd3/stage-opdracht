<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $allowedRoutes = ['login', 'register', 'loginProcess', 'registerProcess']; 
        $currentRoute = service('router')->getMatchedRoute()[0] ?? service('uri')->getPath();

        if (!session()->get('logged_in') && !in_array($currentRoute, $allowedRoutes)) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after response
    }
}
