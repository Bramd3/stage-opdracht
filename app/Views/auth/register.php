<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- TailwindCSS via CDN -->
</head>
<body class="bg-gradient-to-br from-white to-green-50 min-h-screen flex items-center justify-center">
    <!-- Registratieformulier container -->
    <div class="max-w-md w-full p-10 bg-white shadow-xl rounded-lg">
        <h2 class="text-3xl font-bold text-center text-green-900 mb-6">📝 Registreren</h2>

        <!-- Foutmelding tonen als die er is -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="text-red-500 text-center mb-4"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Registratieformulier -->
        <form method="post" action="<?= site_url('registerProcess') ?>">
            <input type="text" name="username" placeholder="Gebruikersnaam" required class="w-full p-3 mb-4 border rounded-lg">
            <input type="password" name="password" placeholder="Wachtwoord" required class="w-full p-3 mb-4 border rounded-lg">
            <input type="password" name="password_confirm" placeholder="Herhaal Wachtwoord" required class="w-full p-3 mb-4 border rounded-lg">
            <button type="submit" class="w-full bg-green-900 text-white p-3 rounded-lg">Registreren</button>
        </form>
    </div>
</body>
</html>
