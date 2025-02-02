<?php
// Ustawienia API
$apiUrl = 'xxxxxxxxxxxxxxxxxxxxxx'; // Zmień na swój endpoint

// Sprawdzenie, czy id zwierzęcia zostało przekazane
if (!isset($_GET['id'])) {
    echo "Brak identyfikatora zwierzęcia.";
    exit;
}

// Pobierz dane o zwierzęciu
$animalId = intval($_GET['id']);
$response = file_get_contents($apiUrl . '/' . $animalId);
$animal = json_decode($response, true);

// Sprawdzenie, czy zwierzę zostało znalezione
if (!$animal) {
    echo "Zwierzę nie zostało znalezione.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły Zwierzęcia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Schronisko</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Przegląd Zwierząt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_animal.php">Dodaj Zwierzę</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Kontakt</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($animal['name']); ?></h1>
        <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" style="width: 300px;">
        <p><strong>Gatunek:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
        <p><strong>Status Adopcyjny:</strong> <?php echo htmlspecialchars($animal['adoption_status']); ?></p>
        <p><strong>Opis:</strong> <?php echo nl2br(htmlspecialchars($animal['description'])); ?></p>
        <a href="index.php" class="btn btn-secondary">Powrót do listy zwierząt</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>