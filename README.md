Krótki opis aplikacji

Aplikacja wykorzystuje bazę danych oraz API Xano, co pozwoliło na skrócenie czasu developmentu. W przypadku większej skali aplikacji istnieje możliwość przygotowania własnej bazy danych (PostgreSQL/MySQL) oraz zapytań CRUD, co zmniejszy koszty utrzymania.

Backend został opracowany w PHP, a layout oraz style zaimplementowano przy użyciu biblioteki Bootstrap. Aplikacja umożliwia wyszukiwanie, sortowanie oraz dodawanie nowych zwierzaków.

Dodatkowym ułatwieniem dla użytkownika jest formularz kontaktowy, który automatycznie przekazuje nazwę zwierzaka – użytkownik musi jedynie podać swoje dane kontaktowe i krótką notatkę.

Komunikacja e-mail odbywa się za pomocą własnego serwera SMTP, co pozwala na ograniczenie kosztów i większą swobodę w dalszej automatyzacji. Możliwe jest testowe wysłanie zapytania. Dodatkowo, zastosowanie rekordów DKIM i DMARC zapewnia skuteczne dostarczanie e-maili.

Możliwości ulepszenia

Aplikację można by przygotować przy użyciu dowolnego frameworka JavaScript, co pozwoliłoby na uniknięcie przeładowań i uzyskanie efektu bardziej dynamicznej aplikacji.

Automatyzacja z wykorzystaniem make

Scenariusz monitoruje skrzynkę mailową kontakt@animalsearch.pl, sprawdzając wiadomości co 5 minut.

Po otrzymaniu nowego maila wysyłane jest żądanie HTTP do bazy Xano, a następnie konwertowana jest odpowiedź na format JSON.

Integracja z OpenAI umożliwia sprawdzenie dostępności zwierzaka oraz zasugerowanie innego w przypadku, gdy zwierzak został adoptowany. OpenAI przygotowuje również personalizowaną treść odpowiedzi.

Ostatecznie e-mail jest wysyłany pod wskazany adres za pomocą własnego serwera IMAP.

Alternatywnie, zamiast cyklicznego sprawdzania skrzynki, można wykorzystać webhook do natychmiastowego odpowiadania na e-maile w momencie wysłania formularza ze strony. Dodatkowo, ta automatyzacja pozwala odpowiadać także na inne e-maile, które trafią na skrzynkę z różnych formularzy dostępnych na stronie.

Wymagania

composer

xano

bootstrap

make

OpenAI

imap/smtp
