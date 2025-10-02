
# Task Manager

[![CI](https://github.com/josiahking/taskmanager/actions/workflows/ci.yml/badge.svg)](https://github.com/josiahking/taskmanager/actions)

A Laravel + Inertia.js + Vite + Pinia project for managing tasks and projects. This application allows users to create, update, delete, and organize tasks under different projects, with priorities and ordering.

## Features
- Project CRUD (Create, Read, Update, Delete)
- Task CRUD with priorities and project association
- Tasks grouped by project
- Unlink tasks from projects
- Responsive UI with Vite and Inertia.js
- State management with Pinia (Vue.js)
- PHPUnit and Pest feature tests

- GraphQL API support
- Personal Access Token authentication (Sanctum)

## Tech Stack
- Laravel (PHP backend)
- Inertia.js (SPA bridge)
- Vite (frontend build tool)
- Vue.js (frontend framework)
- Pinia (state management)
- Pest & PHPUnit (testing)
- GraphQL
- Sanctum

## Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm

### Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/josiahking/taskmanager.git
   cd taskmanager
   ```
2. Install PHP dependencies:
   ```sh
   composer install
   ```
3. Install JS dependencies:
   ```sh
   npm install
   ```
4. Copy and configure your environment:
   ```sh
   cp .env.example .env
   # Edit .env as needed
   php artisan key:generate
   ```
5. Run migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```
6. Build frontend assets:
   ```sh
   npm run build
   ```
7. Start the development server:
   ```sh
   php artisan serve
   ```

### Running Tests
- To run feature and unit tests:
  ```sh
  ./vendor/bin/pest
  # or
  php artisan test
  ```
- To run js tests:
  ```sh
  npm test
  ```

## Folder Structure
- `app/` - Laravel application code (Models, Controllers, Services, Repositories)
- `resources/js/` - Frontend code (Vue, Pinia, components, stores)
- `database/` - Migrations, seeders, factories
- `routes/` - Web and console routes
- `tests/` - Feature and unit tests

## API Endpoints
- `/projects` - List projects
- `/projects/store` - Create project
- `/projects/update` - Update project
- `/projects/delete/{id}` - Delete project
- `/tasks` - List tasks
- `/tasks/store` - Create task
- `/tasks/update` - Update task
- `/tasks/delete/{id}` - Delete task
- `/tasks/unlinkproject` - Unlink tasks from project
- `/graphiql` - GraphQL UI for authenticated users

## Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.


## Live Demo
Test the app here: [https://josiah-taskmanager.nue.dom.my.id/](https://josiah-taskmanager.nue.dom.my.id/)

## License
This project is open source and available under the MIT License.
