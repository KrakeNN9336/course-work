# course-work

Курсова робота по WEB — Laravel магазин для навчального проєкту.

## Як запустити локально

1. Скопіювати репозиторій:

   git clone https://github.com/KrakeNN9336/course-work.git

2. Встановити залежності:

   composer install

3. Створити файл середовища і згенерувати ключ:

   cp .env.example .env
   php artisan key:generate

4. Налаштувати базу даних у `.env` (в цьому проєкті є SQLite у `database/database.sqlite`).

5. Запустити міграції і наповнити тестовими даними (опціонально):

   php artisan migrate --seed

6. Запустити локальний сервер:

   php artisan serve

## Корисні примітки

- Не додавайте файл `.env` у репозиторій.
- Щоб працювати з npm/vite: `npm install` і `npm run dev`.

## Автор

KrakeNN9336

## Запуск у Laragon (Windows)

Якщо ви використовуєте Laragon, можна швидко підключити проєкт як локальний сайт:

1. Скопіюйте проєкт у папку `C:\laragon\www` (як у тебе `C:\laragon\www\course-work`).
2. В Laragon натисніть правою кнопкою на іконці → "Web > Auto Virtual Hosts" чи просто "Start All" — Laragon автоматично згенерує vhost.
3. Відкрий у браузері `http://course-work.test` або інший домен, який Laragon показує.
4. Переконайтесь, що в `.env` вказана правильна база даних (для Laragon можна використовувати MySQL або SQLite).

Порада: якщо використовується SQLite, переконайтесь, що файл `database/database.sqlite` існує і має права на запис.
