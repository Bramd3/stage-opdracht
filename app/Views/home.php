<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVK Zoeken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Zoeken naar KVK Bedrijven</h1>

        <!-- Zoekformulier -->
        <form method="get" action="<?= site_url('kvk') ?>" class="mb-4 flex">
            <input type="text" name="q" placeholder="Voer KVK-nummer of naam in" required 
                class="border border-gray-300 p-2 flex-1 rounded-l">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r">
                Zoek
            </button>
        </form>

        <!-- Foutmelding -->
        <?php if (isset($error)): ?>
            <p class="text-red-500"><?= $error; ?></p>
        <?php endif; ?>

        <!-- Zoekresultaten weergeven -->
        <?php if (isset($results) && count($results) > 0): ?>
            <h3 class="text-xl font-semibold mt-4">Zoekresultaten:</h3>
            <ul class="mt-2">
                <?php foreach ($results as $result): ?>
                    <li class="bg-gray-200 p-3 mt-2 rounded">
                        <strong><?= esc($result['naam'] ?? 'Onbekende Naam'); ?></strong><br>
                        KVK Nummer: <?= esc($result['kvkNummer']); ?><br>
                        Vestigingsnummer: <?= esc($result['_embedded']['hoofdvestiging']['vestigingsnummer'] ?? 'N/A'); ?><br>
                        Activiteit: <?= esc($result['sbiActiviteiten'][0]['sbiOmschrijving'] ?? 'Geen info'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
