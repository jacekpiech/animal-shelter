<?php
// Użyj PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Wczytaj autoloader PHPMailer
require __DIR__ . '/vendor/autoload.php';
require 'email_config.php'; // Wczytaj konfigurację e-mail

// Sprawdzenie, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);
    try {
        // Ustawienia serwera SMTP
        $mail->isSMTP();
        $mail->Host = $mailHost; // Użyj ustawienia z pliku konfiguracyjnego
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername; // Użyj ustawienia z pliku konfiguracyjnego
        $mail->Password = $mailPassword; // Użyj ustawienia z pliku konfiguracyjnego
        $mail->SMTPSecure = 'tls';
        $mail->Port = $mailPort; // Użyj ustawienia z pliku konfiguracyjnego

        // Odbiorcy
        $mail->setFrom('kontakt@animalsearch.pl', 'Schronisko'); // Ustawienie nadawcy na dozwolony adres
        $mail->addAddress('kontakt@animalsearch.pl'); // Zmień na adres, na który chcesz wysłać zapytania
        $mail->addReplyTo($email); // Ustawienie pola Reply-To

        $mail->CharSet = 'UTF-8'; // Ustaw kodowanie na UTF-8

        // Treść wiadomości
        $mail->isHTML(true);
        $mail->Subject = 'Nowa wiadomość kontaktowa';
        $mail->Body = "Imię: $firstName<br>" .
                      "Nazwisko: $lastName<br>" .
                      "Telefon: $phone<br>" .
                      "E-mail: $email<br>" .
                      "Wiadomość: $message<br>";

        // Wysłanie wiadomości
        $mail->send();
        echo 'Wiadomość została wysłana!';
    } catch (Exception $e) {
        echo 'Wystąpił problem z wysłaniem wiadomości. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="contact.php">Kontakt</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Kontakt</h1>
        <form method="POST" action="contact.php">
            <div class="form-group">
                <label for="firstName">Imię</label>
                <input type="text" class="form-control" id="firstName" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="lastName">Nazwisko</label>
                <input type="text" class="form-control" id="lastName" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefon</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Wiadomość</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Wyślij</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>