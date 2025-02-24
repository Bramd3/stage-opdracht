<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    // Methode om de loginpagina weer te geven
    public function login()
    {
        // Controleer of de gebruiker al ingelogd is
        if (session()->get('logged_in')) {
            return redirect()->to('/'); // Doorverwijzen naar home als al ingelogd
        }
        return view('auth/login');
    }
    
    // Methode om de registratiepagina weer te geven
    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        return view('auth/register');
    }

    // Verwerkingsmethode voor de login
    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Zoek gebruiker op basis van de gebruikersnaam
        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Zet sessiegegevens
            $session->set([
                'logged_in' => true,
                'username' => $user['username'],
            ]);

            return redirect()->to('/'); // Na succes doorsturen naar homepagina
        } 

        return redirect()->to('/login')->with('error', 'Ongeldige gebruikersnaam of wachtwoord.');
    }

    // Verwerkingsmethode voor registratie
    public function registerProcess()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        if ($password !== $passwordConfirm) {
            return redirect()->to('/register')->with('error', 'Wachtwoorden komen niet overeen.');
        }

        if ($model->getUserByUsername($username)) {
            return redirect()->to('/register')->with('error', 'Gebruikersnaam is al in gebruik.');
        }

        // Hash het wachtwoord
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Sla de gebruiker op
        $model->insert(['username' => $username, 'password' => $hashedPassword]);

        return redirect()->to('/login')->with('success', 'Registratie gelukt! Log nu in.');
    }

    // Methode voor uitloggen
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
