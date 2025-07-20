Aplikacja do zarządzania wynajmem hal sportowych i organizacji treningów zespołowych. Projekt oparty na Laravel 12, wykorzystujący wzorzec MVC.

Główne funkcjonalności
- Rejestracja i logowanie użytkowników (Laravel Breeze)
- Role: administrator, trener, uczestnik (Spatie Permissions)
- Dodawanie i zarządzanie obiektami sportowymi
- Tworzenie programów treningowych
- Kalendarz treningów (FullCalendar)

Wymagania systemowe
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL

Instrukcja instalacji (dev)
git clone https://github.com/twoj-user/ArenaApp.git
cd ArenaApp
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
