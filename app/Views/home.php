<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVK Zoeken</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- TailwindCSS via CDN -->
</head>
<body class="bg-gradient-to-br from-white to-blue-50 min-h-screen flex items-center justify-center">

    <div class="max-w-3xl w-full p-10 bg-white bg-opacity-80 backdrop-blur-xl shadow-2xl rounded-3xl border border-gray-300">
        <h1 class="text-5xl font-extrabold text-center text-blue-900 mb-8">🔎 KVK Bedrijvengids</h1>

        <!-- Zoekformulier -->
        <form method="get" action="<?= site_url('kvk') ?>" class="flex justify-center mb-8">
            <input type="text" name="q" placeholder="Voer KVK-nummer of bedrijfsnaam in" required
                class="border border-gray-400 p-4 w-2/3 text-lg rounded-l-lg bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-md">
            <button type="submit" class="bg-blue-900 text-white px-6 py-4 rounded-r-lg text-lg font-bold hover:bg-blue-800 transition duration-300 shadow-md">
                Zoek 🔍
            </button>
        </form>

        <!-- Foutmelding weergeven indien aanwezig -->
        <?php if (isset($error)): ?>
            <div class="text-red-500 text-center text-lg mb-6"><?= esc($error); ?></div>
        <?php endif; ?>

        <!-- Zoekresultaten weergeven indien beschikbaar -->
        <?php if (isset($results) && count($results) > 0): ?>
            <h3 class="text-2xl font-semibold text-center text-blue-800 mb-4">🏆 Zoekresultaten:</h3>
            <div class="space-y-6">
                <?php foreach ($results as $result): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
                        <h4 class="text-2xl font-semibold text-blue-900"><?= esc($result['naam'] ?? 'Onbekende Naam'); ?></h4>
                        <p class="text-gray-700 text-lg"><strong>📌 KVK Nummer:</strong> <?= esc($result['kvkNummer']); ?></p>
                        <p class="text-gray-700 text-lg"><strong>🏢 Vestigingsnummer:</strong> <?= esc($result['_embedded']['hoofdvestiging']['vestigingsnummer'] ?? 'N/A'); ?></p>
                        <p class="text-gray-700 text-lg"><strong>💼 Activiteit:</strong> <?= esc($result['sbiActiviteiten'][0]['sbiOmschrijving'] ?? 'Geen informatie beschikbaar'); ?></p>
                        <div class="mt-4 text-right">
                            <a href="<?= site_url('company/' . esc($result['kvkNummer'])) ?>" 
                                class="bg-blue-900 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 transition duration-300 shadow-md">
                                ℹ️ Meer Informatie
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
