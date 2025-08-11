<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

- Clone Repository / Download ZIP file

```
composer update
```

- Configuring the .env file
- Create Database 'web-desa'
- Migrate and Seeder Database

```
php artisan migrate:refresh --seed
```

- Filament Shield Configuration

```
php artisan shield:setup --fresh
php artisan shield:install admin
php artisan shield:generate --panel=admin
php artisan shield:super-admin --user=1
php artisan users:assign-roles --super-admin-id=1
```

- Select Bakukele User as super_admin
  Once the database is seeded and install shield, you can login at /admin using the default super_admin user:

```
email: superadnmin@gmail.com
Password: superadmin
```

### Build Asset

```
npm install
npm run build
```
