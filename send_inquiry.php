<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email'])); // Nowe pole e-mail
    $phone = htmlspecialchars(trim($_POST['phone']));
    $animalName = htmlspecialchars(trim($_POST['animal_name']));
    $animalSpecies = htmlspecialchars(trim($_POST['animal_species']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);
    try {
        // Ustawienia serwera SMTP
        $mail->isSMTP();
        $mail->Host = 'xxxxxxxxxxxxxx'; // Zmień na swój serwer SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'kontakt@animalsearch.pl'; // Zmień na swój adres e-mail
        $mail->Password = 'xxxxxxxxxxxxxxxx'; // Zmień na swoje hasło
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

       // Odbiorcy
       $mail->setFrom('kontakt@animalsearch.pl', 'Schronisko'); // Ustawienie nadawcy na dozwolony adres
       $mail->addAddress('kontakt@animalsearch.pl'); // Zmień na adres, na który chcesz wysłać zapytania
       $mail->addReplyTo($email); // Ustawienie pola Reply-To


       $mail->CharSet = 'UTF-8'; // Ustaw kodowanie na UTF-8
    
       // Treść wiadomości
       $mail->isHTML (true);
       $mail->Subject = 'Zapytanie o zwierzę: ' . $animalName;
       $mail->Body    = "Imię: $firstName<br>" .
                        "Nazwisko: $lastName<br>" .
                        "Nazwa zwierzaka: $animalName<br>" .
                        "E-mail: $email<br>" .
                        "Telefon: $phone<br>" .
                        "Typ zwierzęcia: $animalSpecies<br>" .
                        "Wiadomość: $message<br>";

       // Wysłanie wiadomości
       $mail->send();
       echo 'Zapytanie zostało wysłane!';
   } catch (Exception $e) {
       echo 'Wystąpił problem z wysłaniem zapytania. Mailer Error: ' . $mail->ErrorInfo;
   }
} else {
   echo 'Nieprawidłowe żądanie.';
}
?>