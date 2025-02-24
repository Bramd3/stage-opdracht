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
            // Als ingelogd, doorverwijzen naar de homepagina
            return redirect()->to('/'); 
        }
        // Toon de loginpagina als de gebruiker niet ingelogd is
        return view('auth/login');
    }
    
    // Methode om de registratiepagina weer te geven
    public function register()
    {
        // Controleer of de gebruiker al ingelogd is
        if (session()->get('logged_in')) {
            // Als ingelogd, doorverwijzen naar de homepagina
            return redirect()->to('/');
        }
        // Toon de registratiepagina als de gebruiker niet ingelogd is
        return view('auth/register');
    }

    // Verwerkingsmethode voor de login
    public function loginProcess()
    {
        $session = session(); // Verkrijg de sessie
        $model = new UserModel(); // Laad het UserModel

        $username = $this->request->getPost('username'); // Verkrijg de gebruikersnaam uit het formulier
        $password = $this->request->getPost('password'); // Verkrijg het wachtwoord uit het formulier

        // Verkrijg de gebruiker op basis van de gebruikersnaam
        $user = $model->getUserByUsername($username);

        // Controleer of de gebruiker bestaat en of het wachtwoord correct is
        if ($user && password_verify($password, $user['password'])) {
            // Zet sessievariabelen in om aan te geven dat de gebruiker ingelogd is
            $session->set([
                'logged_in' => true,
                'username' => $user['username'],
            ]);
        }   
    }

    // Verwerkingsmethode voor registratie
    public function registerProcess()
    {
        $session = session(); // Verkrijg de sessie
        $model = new UserModel(); // Laad het UserModel
        
        // Verkrijg gegevens uit het registratieformulier
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        // Controleer of de wachtwoorden overeenkomen
        if ($password !== $passwordConfirm) {
            // Als wachtwoorden niet overeenkomen, geef foutmelding en stuur terug naar registratiepagina
            return redirect()->to('/register')->with('error', 'Wachtwoorden komen niet overeen.');
        }

        // Controleer of gebruikersnaam al bestaat
        if ($model->getUserByUsername($username)) {
            // Als gebruikersnaam al bestaat, geef foutmelding en stuur terug naar registratiepagina
            return redirect()->to('/register')->with('error', 'Gebruikersnaam is al in gebruik.');
        }

        // Hash het wachtwoord voor veilige opslag
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Sla de nieuwe gebruiker op in de database
        $model->insert(['username' => $username, 'password' => $hashedPassword]);

        // Stuur de gebruiker naar de loginpagina met een succesmelding
        return redirect()->to('/login')->with('success', 'Registratie gelukt! Log nu in.');
    }

    // Methode voor uitloggen
    public function logout()
    {
        // Vernietig de sessie en log de gebruiker uit
        session()->destroy();
        
        // Stuur de gebruiker terug naar de loginpagina
        return redirect()->to('/login');
    }
}
