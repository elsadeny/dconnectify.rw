<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Legacy data import

This app now includes an importer that treats `data.sql` as the legacy source of truth and maps it into the Laravel schema used by the current platform.

Run it after your database is migrated:

```bash
php artisan migrate
php artisan legacy:import-data-sql data.sql --fresh
```

What gets imported:

- legacy `users` into the current `users` table
- legacy `cars` into current `listings` as published `vehicle` listings
- legacy `car_images` into listing galleries
- legacy `bookings` into the current `bookings` table
- legacy `wishlists` and `wishlist_cars` into `listing_user`

The importer stores `legacy_id` values on imported users, listings, and bookings so it can be re-run without losing the mapping.

## Database defaults

Local development now defaults to SQLite (`.env.example`):

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Production remains on MySQL. Both deployment scripts (`scripts/deploy.sh` and `scripts/deploy-ci.sh`) explicitly set `DB_CONNECTION=mysql` in production and keep MySQL credentials/config in `.env`.

If you want to use MySQL locally, set these values in your local `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=connectify
DB_USERNAME=connectify
DB_PASSWORD=connectify-password
```

## Fresh VPS deployment

This repository includes a provisioning script for a fresh Ubuntu VPS:

```bash
sudo MYSQL_DATABASE=connectify MYSQL_USER=connectify MYSQL_PASSWORD='change-me' bash scripts/deploy.sh your-domain-or-server-ip
```

What it does:

- installs Nginx, PHP, Composer, Node.js 22, MySQL Server, and required PHP extensions
- syncs the current repository into `/var/www/connectify`
- creates a production `.env` configured for MySQL
- creates the MySQL database and application user
- installs Composer and npm dependencies, builds Vite assets, and runs migrations
- configures Nginx plus systemd services for the queue worker and Laravel scheduler

Notes:

- run the script from this repository after the code is present on the VPS
- the generated `APP_URL` is `http://...`; update it to `https://...` after you add TLS
- if you want to deploy into a different path, pass it as the second argument

## GitHub Actions deployment

Pushes to the `main` branch deploy automatically through `.github/workflows/deploy.yml`.

Required GitHub repository secret:

- `PRODUCTION_SSH_PRIVATE_KEY`: private SSH key that can connect to the production server

Optional GitHub repository secrets if production changes:

- `PRODUCTION_SSH_HOST`: production server host or IP, defaults to `41.186.186.162`
- `PRODUCTION_SSH_PORT`: SSH port, currently `222`
- `PRODUCTION_SSH_USER`: SSH user, currently `root`

Recommended GitHub environment variables for the `production` environment:

- `PRODUCTION_APP_DIR`: app path on the server, currently `/var/www/connectify`
- `PRODUCTION_APP_URL`: public URL, currently `https://dev.connectify.rw`

The workflow syncs code to production, preserves `.env`, `storage`, `vendor`, `node_modules`, SQLite files, and Laravel cache files, then runs `scripts/deploy-ci.sh` on the server. The CI deploy script installs PHP dependencies, builds Vite assets, runs migrations, rebuilds Laravel caches, and restarts the queue worker without rewriting Nginx or rotating `APP_KEY`.
