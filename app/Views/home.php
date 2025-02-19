<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KVK Bedrijfszoeker</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center">KVK Bedrijfszoeker</h1>
            
            <div class="input-group mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Voer bedrijfsnaam of KVK-nummer in">
                <button id="searchButton" class="btn btn-primary">Zoeken</button>
            </div>

            <div id="results" class="mt-3"></div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>
</html>
