# YourMenuPage - Online Menu Platform

An online menu platform for meals, coffee, and drinks, organized by city locations. Built with Laravel, Inertia.js, and Tailwind CSS for a modern, responsive user experience.

## Features

- **City-Based Menus**: Browse restaurants and menus by city location
- **Restaurant Management**: Add and manage restaurants with their details
- **Menu Items**: Create and categorize food and drink items
- **User Authentication**: Secure user registration and login
- **Responsive Design**: Mobile-friendly interface using Tailwind CSS
- **Modern Frontend**: Single-page application experience with Inertia.js

## Technologies Used

- **Backend**: Laravel (PHP Framework)
- **Frontend**: Inertia.js (React/Vue integration with Laravel)
- **Styling**: Tailwind CSS
- **Database**: MySQL/PostgreSQL/SQLite (configurable)
- **Build Tool**: Vite
- **Testing**: PHPUnit

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js 16 or higher
- NPM or Yarn
- MySQL/PostgreSQL/SQLite database

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/yourusername/yourmenupage-inertia.git
   cd yourmenupage-inertia
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install Node.js dependencies**

   ```bash
   npm install
   ```

4. **Environment Configuration**
   - Copy `.env.example` to `.env`
   - Configure your database settings in `.env`
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

5. **Database Setup**

   ```bash
   php artisan migrate
   php artisan db:seed  # Optional: seed with sample data
   ```

6. **Build Assets**

   ```bash
   npm run build
   # Or for development:
   npm run dev
   ```

7. **Start the Application**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

## Usage

### For Users

- Browse cities and restaurants
- View detailed menus with items
- Search for specific food or drinks

### For Restaurant Owners

- Register and manage restaurant profiles
- Add menu categories and items
- Update pricing and availability

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
# Run PHP CS Fixer
./vendor/bin/php-cs-fixer fix

# Run ESLint
npm run lint
```

### Building for Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Project Structure

```
app/
├── Http/Controllers/     # Controllers
├── Models/              # Eloquent models
├── Policies/            # Authorization policies
└── Providers/           # Service providers

resources/
├── js/                  # Frontend JavaScript/Vue components
├── css/                 # Stylesheets
└── views/               # Blade templates

database/
├── migrations/          # Database migrations
├── seeders/            # Database seeders
└── factories/          # Model factories

routes/
├── web.php             # Web routes
└── api.php             # API routes
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the GNU License - see the [LICENSE](LICENSE) file for details.

## Support

If you have any questions or need help, please open an issue on GitHub.

---

Built with ❤️ using Laravel and Inertia.js
