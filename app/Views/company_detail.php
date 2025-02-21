<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedrijfsdetails</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- TailwindCSS via CDN -->
</head>
<body class="bg-gradient-to-br from-white to-blue-50 min-h-screen flex items-center justify-center">

    <div class="max-w-3xl w-full p-10 bg-white bg-opacity-80 backdrop-blur-xl shadow-2xl rounded-3xl border border-gray-300">
        <h1 class="text-4xl font-extrabold text-center text-blue-900 mb-6">📊 Bedrijfsdetails</h1>

        <?php if (isset($error)): ?> 
            <!-- Foutmelding weergeven als er een error is -->
            <div class="text-red-500 text-center text-lg mb-6"><?= esc($error); ?></div>
        <?php else: ?>
            <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
                <h2 class="text-3xl font-bold text-blue-900"><?= esc($company['naam'] ?? 'Onbekende Naam'); ?></h2>
                <p class="text-gray-700 text-lg mt-2"><strong>📌 KVK Nummer:</strong> <?= esc($company['kvkNummer']); ?></p>
                <p class="text-gray-700 text-lg mt-2"><strong>🏢 Vestigingsnummer:</strong> <?= esc($company['_embedded']['hoofdvestiging']['vestigingsnummer'] ?? 'N/A'); ?></p>
                <p class="text-gray-700 text-lg mt-2"><strong>📍 Adres:</strong> <?= esc($adres); ?></p>
                <p class="text-gray-700 text-lg mt-2"><strong>💼 Activiteit:</strong> <?= esc($company['sbiActiviteiten'][0]['sbiOmschrijving'] ?? 'Geen informatie beschikbaar'); ?></p>

                <!-- Home knop -->
                <div class="mt-6 text-center">
                    <a href="<?= site_url('/') ?>" 
                        class="bg-blue-900 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-800 transition duration-300 shadow-md">
                        ⬅️ Terug naar Home
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
