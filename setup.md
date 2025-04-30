# Time and Productivity Analysis System - Setup Guide

## Prerequisites
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7
- Git

## Installation Steps

1. Clone the repository:
```bash
git clone https://github.com/suprimraja/Time-and-Productivity-Analysis-System.git
cd Time-and-Productivity-Analysis-System
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. Start the development server:
```bash
php artisan serve
```

9. In a separate terminal, start the Vite development server:
```bash
npm run dev
```

## Environment Configuration

Create a `.env` file in the root directory with the following content:

```
APP_NAME="Time and Productivity Analysis System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

## Security Notes
- Never commit your `.env` file to version control
- Keep your database credentials secure
- Generate a new application key for production use
- Set `APP_DEBUG=false` in production

## Troubleshooting

If you encounter any issues:
1. Clear the cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

2. Check your PHP version:
```bash
php -v
```

3. Verify database connection:
```bash
php artisan migrate:status
```

4. Check Laravel logs:
```bash
tail -f storage/logs/laravel.log
``` 