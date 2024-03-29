# Project Setup

## 1. Install Dependencies

To install project dependencies, run the following command:

```bash
composer install
```

## 2. Migrate the Database

To migrate the database and create necessary tables, run:

```bash
php artisan migrate
```

## 3. Set up Laravel Passport Client

To set up Laravel Passport for API authentication, run:

```bash
php artisan passport:client --personal
```

## 4. Set up Laravel Passport Keys

Generate encryption keys required for secure token generation and management, run:

```bash
php artisan passport:keys
```

## 5. Run Redis Server

Ensure that Redis server is running to enable authorization. You can download and install Redis from [here](https://redis.io/download) if you haven't already installed it.

## 6. Setup Task Scheduling

To enable task scheduling, follow these steps:

### Locally:

Run the following command in your terminal:

```bash
php artisan schedule:work
```
### On the Server:

Add the following cron job to your server's crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Replace /path-to-your-project with the actual path to your Laravel project directory on the server. This cron job will execute the Laravel scheduler every minute.

### Testing Schedule:

To test your schedule configuration, run:

```bash
php artisan schedule:test
```

## Generating Swagger Documentation

To generate Swagger documentation for your API, you can use the following command:

```bash
php artisan l5-swagger:generate
```

Once generated, you can access the Swagger documentation by navigating to the following path in your browser:

```
{hostname}/api/documentation
```

This will open the Swagger UI interface where you can explore and test your API endpoints interactively.
