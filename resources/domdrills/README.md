# DomDrills

A trading education platform built with Laravel 11: articles, FAQ, a doubts forum, live 1-on-1 tutoring signup, a real-time live chat, and a personal trading journal.

## Why this isn't a ready-to-run folder

This project was generated in a sandbox with **no internet access**, so `composer install` couldn't be run here to pull down the Laravel framework itself. What you have is the complete **application layer** — models, controllers, migrations, routes, views — laid on top of the standard Laravel skeleton. You'll drop it into a fresh Laravel install locally. This takes about 5 minutes.

## 1. Create a fresh Laravel 11 app

```bash
composer create-project laravel/laravel:^11.0 domdrills
cd domdrills
```

## 2. Copy this project's files in

Copy the following folders/files from this download **into** the `domdrills/` folder you just created, overwriting where prompted:

```
app/            -> domdrills/app/
database/       -> domdrills/database/
resources/      -> domdrills/resources/
routes/         -> domdrills/routes/
bootstrap/app.php       -> domdrills/bootstrap/app.php
bootstrap/providers.php -> domdrills/bootstrap/providers.php
```

(`composer.json` and `.env.example` are included for reference — you can merge the `laravel/reverb` requirement into your existing `composer.json`, or just run the command in step 3.)

## 3. Install the extra package (Reverb, for live chat)

```bash
composer require laravel/reverb
php artisan reverb:install
```

## 4. Configure your environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). SQLite also works — just set `DB_CONNECTION=sqlite` and create an empty `database/database.sqlite` file.

## 5. Migrate & seed

```bash
php artisan migrate --seed
```

This creates demo accounts (password for all: `password`):
- `admin@domdrills.test` — full admin access at `/admin`
- `mentor@domdrills.test` — author of the sample articles
- `trader@domdrills.test` — a regular user

It also seeds 4 sample articles, 6 FAQs, and the "Live Help" chat room.

## 6. Run it

In separate terminals:

```bash
php artisan serve          # the app: http://localhost:8000
php artisan reverb:start   # websocket server, powers live chat
php artisan queue:work     # processes broadcast queue jobs
```

No frontend build step is needed — styling uses the Tailwind CDN directly in `resources/views/layouts/app.blade.php`, so there's no `npm install`/`npm run build` required to see the site working. (You can swap this for a compiled Tailwind + Vite setup later if you want smaller CSS payloads in production.)

## Feature map

| Feature | Routes | Notes |
|---|---|---|
| Articles / blog | `/blog`, `/blog/{slug}` | Category filter + search, managed at `/admin/posts` |
| FAQ | `/faq` | Grouped accordion, seeded with starter content |
| Doubts forum | `/forum`, `/forum/{slug}` | Public read, login required to post/reply |
| Tutoring | `/tutoring` | Pricing tiers + lead capture form, managed at `/admin/leads` |
| Live chat | `/chat` | Real-time via Laravel Reverb + Echo, requires login |
| Trading journal | `/journal` | Auto-calculates P&L from entry/exit price, per-user, requires login |
| Admin area | `/admin` | Gated by `role = admin`, dashboard + post/lead management |

## Notes & next steps

- **User roles**: `users.role` is `user`, `mentor`, or `admin`. Promote a user to admin via `php artisan tinker` → `User::where('email', 'you@example.com')->update(['role' => 'admin']);`
- **Mail**: currently logs to `storage/logs/laravel.log` (`MAIL_MAILER=log`). Swap in a real mail driver before going to production so tutoring lead notifications and password resets actually send.
- **File uploads**: `posts.cover_image` is in the schema but the admin post form doesn't yet handle image uploads — add a file input + `Storage::disk('public')` call if you want cover images.
- **Trading journal charts**: currently shows summary stats (total trades, wins/losses, net P&L). Equity curve charts can be added with Chart.js against the `trades` table.
- **Tests**: no test suite included yet — `tests/Feature` is a good place to start with auth, journal CRUD, and forum posting tests.
