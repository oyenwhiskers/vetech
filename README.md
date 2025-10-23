# VETech - Sandakan Veterinar Management System

A comprehensive web-based management system for Sandakan Veterinar Department to manage customer records, pet information, treatments, bookings, collaborators, and QR-based pet identification tags.

## Features

### 1. **Dashboard**
- Overview of total customers, pets, and collaborators
- Today's bookings and pending appointments
- Recent treatments and bookings
- Statistical insights

### 2. **Customer Management (Manage Records)**
- Register and manage customer information
- View customer profiles with all their pets
- Track customer contact details and IC numbers
- Each customer can have multiple pets

### 3. **Pet Management**
- Register pets with detailed information (species, breed, age, weight, etc.)
- Access complete treatment history for each pet
- Add new treatment records directly from pet profiles
- Track microchip numbers and special notes

### 4. **Collaborator Management (Klinik Swasta)**
- Register private clinics as collaborators
- Create user accounts for collaborators to login
- Collaborators can add treatment records for pets they treat
- Track treatments performed by collaborators vs government clinic
- Manage collaborator status (active/inactive)

### 5. **Booking Management**
- Create and manage appointment bookings
- Automatic queue number generation
- Filter bookings by status and date
- Track booking status (pending, confirmed, completed, cancelled)
- Service type categorization

### 6. **Tag & QR Code Management**
- Generate unique QR codes for pet identification
- Download QR codes for printing on pet collars
- Scan QR codes to view pet information and treatment history
- Public scan page (no login required) for emergency access
- Track tag status (active, inactive, lost)

## Technology Stack

- **Framework**: Laravel 11.x
- **Database**: MySQL (via XAMPP - database: vetech)
- **Frontend**: Blade Templates with TailwindCSS
- **QR Code**: Endroid QR Code Library
- **Authentication**: Laravel Breeze

## Default Login Credentials
- **Email**: admin@vetech.com
- **Password**: password

## Running the Application
The server is currently running at: **http://127.0.0.1:8000**

To start the server manually:
```bash
php artisan serve
```

## User Roles

### Admin
- Full access to all features
- Can manage collaborators
- Can view and manage all records

### Collaborator
- Can add treatment records for pets
- Cannot manage other collaborators
- Limited to treatment-related operations

---

**Developed for Sandakan Veterinar Department**


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

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
