# Aj Kya Pakae (What to Cook Today)

A comprehensive meal planning and recipe management application built with Laravel.

## Overview

Aj Kya Pakae is a web application designed to simplify meal planning, recipe management, and grocery shopping. The application allows users to discover recipes, create meal plans, manage their pantry, and generate shopping lists based on their meal plans.

## Features

- **Recipe Management**: Browse, search, create, and edit recipes with ingredients, instructions, and images
- **Meal Planning**: Create weekly meal plans by selecting recipes for different days
- **Shopping List**: Automatically generate shopping lists based on meal plans
- **Pantry Management**: Keep track of ingredients you have at home
- **User Authentication**: Secure login and registration system
- **Admin Dashboard**: Comprehensive admin panel for managing recipes, ingredients, categories, and users
- **Favorites**: Save your favorite recipes for quick access
- **Multi-language Support**: Available in English and Urdu

## Installation

### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL or compatible database
- Node.js and NPM

### Setup Instructions

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/aj_kya_pakae.git
   cd aj_kya_pakae
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Create a copy of the environment file:
   ```
   cp .env.example .env
   ```

5. Generate application key:
   ```
   php artisan key:generate
   ```

6. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations and seeders:
   ```
   php artisan migrate --seed
   ```

8. Create a symbolic link for storage:
   ```
   php artisan storage:link
   ```

9. Compile assets:
   ```
   npm run dev
   ```

10. Start the development server:
    ```
    php artisan serve
    ```

11. Access the application at `http://localhost:8000`

## Project Structure

### Key Directories

- `app/` - Contains the core code of the application
  - `Http/Controllers/` - Controllers for handling HTTP requests
  - `Models/` - Eloquent models representing database tables
- `resources/views/` - Blade templates for the frontend
  - `admin/` - Admin panel views
  - `recipes/` - Recipe-related views
  - `mealplanner/` - Meal planning views
  - `pantry/` - Pantry management views
- `routes/` - Application routes
  - `web.php` - Web routes
  - `auth.php` - Authentication routes
- `database/` - Database migrations and seeders
- `public/` - Publicly accessible files
  - `storage/` - Symbolic link to `storage/app/public` for storing user uploads

### Key Models

- `User` - User accounts and authentication
- `Recipe` - Recipe information including title, description, instructions
- `Ingredient` - Ingredients used in recipes
- `Category` - Recipe categories
- `MealPlan` - User meal plans
- `PantryItem` - User pantry items
- `Favorite` - User favorite recipes

## Usage

### User Roles

- **Regular Users**: Can browse recipes, create meal plans, manage their pantry, and save favorites
- **Admin Users**: Have access to the admin dashboard to manage all aspects of the application

### Admin Dashboard

Access the admin dashboard at `/admin` with admin credentials. The dashboard provides:

- Recipe management
- Ingredient management
- Category management
- User management
- Analytics and reporting

## Development

### Key Technologies

- **Laravel**: PHP framework for backend
- **Bootstrap**: Frontend framework for responsive design
- **MySQL**: Database for storing application data
- **Blade**: Templating engine for views

### Coding Standards

- Follow PSR-12 coding standards for PHP
- Use Laravel naming conventions for controllers, models, and views
- Write descriptive commit messages

### Common Issues and Solutions

- **Images not displaying**: Ensure you've run `php artisan storage:link` to create the symbolic link
- **Route not found errors**: Check route definitions in `routes/web.php`
- **Database connection issues**: Verify database credentials in `.env` file

## License

This project is licensed under the MIT License - see the LICENSE file for details.
