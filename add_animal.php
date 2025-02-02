<?php
// Sprawdzenie, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $name = htmlspecialchars(trim($_POST['name']));
    $species = htmlspecialchars(trim($_POST['species']));
    $adoption_status = htmlspecialchars(trim($_POST['adoption_status']));
    $description = htmlspecialchars(trim($_POST['description']));
    $image_url = htmlspecialchars(trim($_POST['image_url']));

    // Ustawienia API Xano
    $apiUrl = 'xxxxxxxxxxxxxxx'; // Zmień na swój endpoint


    // Przygotowanie danych do wysłania
    $data = [
        'name' => $name,
        'species' => $species,
        'adoption_status' => $adoption_status,
        'description' => $description,
        'image_url' => $image_url,
    ];

    // Wysłanie danych do API
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                         "Authorization: Bearer your_api_token\r\n", // Jeśli potrzebujesz autoryzacji
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);

    if ($result === FALSE) {
        echo "Wystąpił błąd podczas dodawania zwierzęcia.";
    } else {
        echo "Zwierzę zostało dodane pomyślnie!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Zwierzę</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="add_animal.php">Dodaj Zwierzę</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Kontakt</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Dodaj Nowe Zwierzę</h1>
        <form method="POST" action="add_animal.php">
            <div class="form-group">
                <label for="name">Imię</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="species">Gatunek</label>
                <input type="text" class="form-control" id="species" name="species" required>
            </div>
            <div class="form-group">
                <label for="adoption_status">Status Adopcyjny</label>
                <input type="text" class="form-control" id="adoption_status" name="adoption_status" required>
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image_url">URL Obrazka</label>
                <input type="url" class="form-control" id="image_url" name="image_url" required>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj Zwierzę</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>