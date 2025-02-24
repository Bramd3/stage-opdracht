<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- TailwindCSS via CDN -->
</head>
<body class="bg-gradient-to-br from-white to-blue-50 min-h-screen flex items-center justify-center">
    <!-- Login formulier container -->
    <div class="max-w-md w-full p-10 bg-white shadow-xl rounded-lg">
        <h2 class="text-3xl font-bold text-center text-blue-900 mb-6">🔑 Inloggen</h2>

        <!-- Foutmelding tonen als die er is -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="text-red-500 text-center mb-4"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Loginformulier -->
        <form method="post" action="<?= site_url('loginProcess') ?>">
            <input type="text" name="username" placeholder="Gebruikersnaam" required
                class="w-full p-3 mb-4 border rounded-lg">
            <input type="password" name="password" placeholder="Wachtwoord" required
                class="w-full p-3 mb-4 border rounded-lg">
            <button type="submit" class="w-full bg-blue-900 text-white p-3 rounded-lg">Login</button>
        </form>
    </div>
</body>
</html>
