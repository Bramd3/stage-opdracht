<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-10 bg-white shadow-xl rounded-lg">
        <h2 class="text-3xl font-bold text-center text-blue-900 mb-6">📊 Dashboard</h2>
        <p class="text-center">Welkom, <?= session('username'); ?>!</p>
        <div class="mt-6 text-center">
            <a href="<?= site_url('logout') ?>" class="bg-red-500 text-white px-6 py-2 rounded-lg">Uitloggen</a>
        </div>
    </div>
</body>
</html>
