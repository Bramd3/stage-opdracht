<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login'); // Laadt de login view
    }

    public function loginProcess()
{
    $session = session();
    $model = new UserModel();

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $user = $model->getUserByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        $session->set([
            'logged_in' => true,
            'username' => $user['username'],
        ]);

        return redirect()->to('/'); // 🚀 Verwijder "/dashboard" en stuur naar homepagina
    } else {
        return redirect()->to('/login')->with('error', 'Ongeldige inloggegevens.');
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    public function register()
{
    return view('auth/register');
}

public function registerProcess()
{
    $session = session();
    $model = new UserModel();
    
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    $passwordConfirm = $this->request->getPost('password_confirm');

    // Controleer of de wachtwoorden overeenkomen
    if ($password !== $passwordConfirm) {
        return redirect()->to('/register')->with('error', 'Wachtwoorden komen niet overeen.');
    }

    // Controleer of gebruikersnaam al bestaat
    if ($model->getUserByUsername($username)) {
        return redirect()->to('/register')->with('error', 'Gebruikersnaam is al in gebruik.');
    }

    // Wachtwoord hashen en opslaan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $model->insert(['username' => $username, 'password' => $hashedPassword]);

    return redirect()->to('/login')->with('success', 'Registratie gelukt! Log nu in.');
}

}
