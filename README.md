# Odin Patient Lab

A local Laravel/MySQL sandbox with fictional patient data for Project Odin recording tasks. It is designed for practising search, filtering, empty states, responsive UI, accessibility, database changes, and automated testing.

## Requirements

- PHP 8.3+
- Composer
- MySQL on `127.0.0.1:3306`

## First run

The local `.env` is already configured on this Mac. Create the database if it does not exist, then run only non-destructive migrations and the idempotent seeder:

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS odin_patient_lab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
php artisan migrate
php artisan db:seed
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Safety

- All included patient records are fictional.
- Do not enter real patient information.
- Do not run `migrate:fresh`, `db:wipe`, or destructive SQL against this database.
- The seeder uses `updateOrCreate`, so it can be run again without duplicating the sample records.

## Tests

```bash
php artisan test
```
