# Krótki opis aplikacji

Aplikacja wykorzystuje bazę danych oraz API Xano, co pozwoliło na skrócenie czasu developmentu. W przypadku większej skali aplikacji istnieje możliwość przygotowania własnej bazy danych (PostgreSQL/MySQL) oraz zapytań CRUD, co zmniejszy koszty utrzymania.

Backend został opracowany w PHP, a layout oraz style zaimplementowano przy użyciu biblioteki Bootstrap. Aplikacja umożliwia wyszukiwanie, sortowanie oraz dodawanie nowych zwierzaków.

Dodatkowym ułatwieniem dla użytkownika jest formularz kontaktowy, który automatycznie przekazuje nazwę zwierzaka – użytkownik musi jedynie podać swoje dane kontaktowe i krótką notatkę.

Komunikacja e-mail odbywa się za pomocą własnego serwera SMTP, co pozwala na ograniczenie kosztów i większą swobodę w dalszej automatyzacji. Możliwe jest testowe wysłanie zapytania. Dodatkowo, zastosowanie rekordów DKIM i DMARC zapewnia skuteczne dostarczanie e-maili.

## Możliwości ulepszenia

Aplikację można by było przygotować za pomocą dowolnego frameworka JS. Wtedy można uniknąć przeładowań i uzyskać efekt bardziej dynamicznej aplikacji.
Utrzymanie aplikacji w procesie CI/CD za pomocą git i github actions pozwoli na szybsze wprowadzanie zmian na serwer produkcyjny.

## Automatyzacja z wykorzystaniem make

1. Scenariusz nasłuchuje na skrzynce mailowej kontakt@animalsearch.pl. Wiadomości są sprawdzane co 15 minut.
2. Po otrzymaniu nowego maila uruchamiane jest http request do bazy Xano pobierający aktualne rekordy, następnie konwertujemy odpowiedź do formatu JSON.
3. Integracja z OpenAI pozwala na sprawdzenie dostępności zwierzaka i zasugerowanie innego w przypadku gdy zwierzak został adoptowany. OpenAI przygotowuje również personalizowaną treść odpowiedzi.
4. Na końcu wysyłka e-maila pod podany adres w formularz,  za pomocą własnego serwera imap.
5. Alternatywnie do wywołania akcji odpowiedzi można użyć webhooka i odpowiadać na maila w momencie wysłania formularza ze strony.
Natomiast ta automatyzacja jest w stanie odpowiedzieć na różne inne maile które trafią na naszą skrzynkę z innych dostępnyc formularzy.

Alternatywnie, zamiast cyklicznego sprawdzania skrzynki, można wykorzystać webhook do natychmiastowego odpowiadania na e-maile w momencie wysłania formularza ze strony. Dodatkowo, ta automatyzacja pozwala odpowiadać także na inne e-maile, które trafią na skrzynkę z różnych formularzy dostępnych na stronie.

## Wymagania

- `composer`
- `xano`
- `bootstrap`
- `make`
- `OpenAI`
- `imap/smtp`
- `PHPMailer`
