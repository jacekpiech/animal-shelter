<?php
// Ustawienia API
$apiUrl = 'xxxxxxxxxxxxxxxxxxxxxxxxx'; // Zmień na swój endpoint

// Funkcja do pobierania danych z API
function fetchAnimals($url) {
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Pobierz dane o zwierzętach
$animals = fetchAnimals($apiUrl);

// Obsługa wyszukiwania
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = strtolower(trim($_POST['search']));
    $animals = array_filter($animals, function($animal) use ($searchTerm) {
        return strpos(strtolower($animal['name']), $searchTerm) !== false || 
               strpos(strtolower($animal['description']), $searchTerm) !== false; // Wyszukiwanie po opisie
    });
}

// Obsługa sortowania
$sortColumn = 'name'; // Domyślna kolumna do sortowania
$sortOrder = 'asc'; // Domyślny porządek sortowania

if (isset($_GET['sort'])) {
    $sortColumn = $_GET['sort'];
}

if (isset($_GET['order'])) {
    $sortOrder = $_GET['order'];
}

// Funkcja do sortowania
usort($animals, function($a, $b) use ($sortColumn, $sortOrder) {
    if ($sortOrder === 'asc') {
        return strcmp($a[$sortColumn], $b[$sortColumn]);
    } else {
        return strcmp($b[$sortColumn], $a[$sortColumn]);
    }
});
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie Zwierzętami w Schronisku</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Schronisko</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
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
        <h1>Zwierzęta w Schronisku</h1>
        <form method="POST" class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Szukaj zwierząt..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><a href="?sort=name&order=<?php echo $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">Imię</a></th>
                    <th><a href="?sort=species&order=<?php echo $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">Gatunek</a></th>
                    <th>Obrazek</th>
                    <th><a href="?sort=adoption_status&order=<?php echo $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">Status Adopcyjny</a></th>
                    <th><a href="?sort=description&order=<?php echo $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">Opis</ th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($animals)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Brak zwierząt do wyświetlenia.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($animals as $animal): ?>
                        <tr>
                            <td><a href="animal_detail.php?id=<?php echo $animal['id']; ?>"><?php echo htmlspecialchars($animal['name']); ?></a></td>
                            <td><?php echo htmlspecialchars($animal['species']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" style="width: 100px;"></td>
                            <td><?php echo htmlspecialchars($animal['adoption_status']); ?></td>
                            <td><?php echo htmlspecialchars($animal['description']); ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inquiryModal" data-animal-name="<?php echo htmlspecialchars($animal['name']); ?>" data-animal-species="<?php echo htmlspecialchars($animal['species']); ?>">Zapytaj</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

   <!-- Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryModalLabel">Wyślij zapytanie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="send_inquiry.php" method="POST">
                    <div class="form-group">
                        <label for="firstName">Imię</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Nazwisko</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <input type="hidden" id="animalName" name="animal_name">
                    <input type="hidden" id="animalSpecies" name="animal_species">
                    <div class="form-group">
                        <label for="message">Wiadomość</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Wyślij</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#inquiryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var animalName = button.data('animal-name');
            var animalSpecies = button.data('animal-species');
            var modal = $(this);
            modal.find('#animalName').val(animalName);
            modal.find('#animalSpecies').val(animalSpecies);
        });
    </script>
</body>
</html>