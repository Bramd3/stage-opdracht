<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVK Zoeken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-bold text-gray-700 mb-4 text-center">Zoek een KVK-bedrijf</h1>

        <!-- Zoekformulier -->
        <form method="get" action="<?= site_url('kvk') ?>" class="mb-4 flex">
            <input type="text" name="q" class="border border-gray-300 p-2 rounded-l w-full focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Voer KVK-nummer in" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">Zoek</button>
        </form>

        <!-- Foutmelding weergeven -->
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4 text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <!-- Resultaten weergeven -->
        <?php if (isset($result)): ?>
            <div class="bg-green-100 p-4 rounded-md">
                <h3 class="text-lg font-semibold text-gray-700">Bedrijfsgegevens</h3>
                <p><strong>Naam:</strong> <?= $result['naam']; ?></p>
                <p><strong>KVK-nummer:</strong> <?= $result['kvkNummer']; ?></p>
                <p><strong>Registratiedatum:</strong> <?= $result['formeleRegistratiedatum']; ?></p>
                <p><strong>Vestigingsadres:</strong> <?= $result['_embedded']['hoofdvestiging']['adressen'][0]['volledigAdres'] ?? 'Niet beschikbaar'; ?></p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
