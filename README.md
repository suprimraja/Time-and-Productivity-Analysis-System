# Time-and-Productivity-Analysis-System
2. General Description The Time and Productivity Analysis System (TPAS) is a web-based tool designed to help individuals and organizations track time, manage tasks, and analyze productivity. It provides features for logging tasks, setting goals, and generating performance reports.

## Features

- Task Management
  - Create, edit, and delete tasks
  - Assign tasks to projects
  - Set task priorities and due dates
  - Track task status (todo, in progress, review, completed)
  - Parent-child task relationships
  - Time tracking and billable hours
- Project Management
  - Organize tasks by projects
  - Project-based task filtering
- User Authentication
  - Secure user authentication
  - User-specific task management
- Time Tracking
  - Track time spent on tasks
  - Billable vs non-billable hours
  - Time entry management

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (or any other supported database)

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd [project-directory]
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

6. Create database:
```bash
touch database/database.sqlite
```

7. Run migrations:
```bash
php artisan migrate
```

8. Start the development server:
```bash
php artisan serve
```

9. In a separate terminal, start Vite:
```bash
npm run dev
```

## Development

The project uses Laravel's built-in development tools and follows Laravel best practices. For development, you can use the following commands:

- Run tests: `php artisan test`
- Code style checking: `php artisan pint`
- Start development environment: `composer dev`

## Project Structure

- `app/Http/Controllers/` - Contains all application controllers
- `app/Models/` - Contains all Eloquent models
- `resources/views/` - Contains all Blade templates
- `database/migrations/` - Contains database migrations
- `routes/` - Contains all application routes
- `public/` - Contains publicly accessible files
- `tests/` - Contains all application tests

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
