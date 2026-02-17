# Symfony EasyAdmin User List App

This repository contains a Symfony application configured with EasyAdmin and authentication.

After startup, you can log in and access the EasyAdmin panel to see a list of users.

## What is included

- Symfony app skeleton (PHP 8.2+)
- Doctrine ORM using SQLite by default
- `User` entity wired to Symfony Security
- Login form at `/login`
- EasyAdmin dashboard at `/admin`
- User CRUD/list page in EasyAdmin
- Dockerfile + docker-compose setup
- Bootstrap command for default admin account

## Default credentials

- Email: `admin@example.com`
- Password: `admin123`

## Run with Docker Compose

1. Build and start containers:

   ```bash
   docker compose up --build
   ```

2. Open in your browser:

   - App login: http://localhost:8000/login
   - EasyAdmin: http://localhost:8000/admin

The container entrypoint automatically:

- installs Composer dependencies (if `vendor/` is missing)
- runs migrations
- creates the default admin user (if it does not already exist)

## Run locally (without Docker)

1. Install dependencies:

   ```bash
   composer install
   ```

2. Prepare database and admin user:

   ```bash
   php bin/console doctrine:migrations:migrate --no-interaction
   php bin/console app:create-admin-user admin@example.com admin123
   ```

3. Start Symfony local server:

   ```bash
   symfony server:start
   ```

   or PHP built-in server:

   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

## Notes

- This project is scaffolded manually because dependency download from Packagist may be restricted in some CI/sandbox environments.
- On a normal machine with internet access, `composer install` in Docker/local should fetch all packages and run normally.
