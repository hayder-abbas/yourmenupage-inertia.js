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
- **Frontend**: Inertia.js (Vue.js)
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Build Tool**: Vite
- **Testing**: PHPUnit

## Prerequisites

- Docker 29.7 or higher

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
    sail npm install
    ```

4. **Environment Configuration**
    - Copy `.env.example` to `.env`
    - Configure your database settings in `.env`
    - Generate application key:
        ```bash
        sail artisan key:generate
        ```

5. **Database Setup**

    ```bash
    sail artisan migrate
    ```

6. **Build Assets**

    ```bash
    sail npm run build
    # Or for development:
    sail npm run dev
    ```

7. **Start the Application**

    ```bash
    sail up -d
    sail npm run dev
    ```

    Visit `http://localhost` in your browser.

8. **Stop the Application**

    ```bash
    crtl + c # for npm run dev
    sail stop
    # or
    sail down -v
    ```

## Usage

### For Users

- Browse cities and restaurants
- View detailed menus with items
- Search for specific food or drinks

### For Restaurant Owners

- Register and manage restaurant profile
- Add menu categories and items
- Update pricing and availability

## Development

### Running Tests

```bash
sail test
```

### Building for Production

```bash
sail npm run build
sail artisan config:cache
sail artisan route:cache
sail artisan view:cache
```

## Project Structure

```
app/
├── Http/Controllers/    # Controllers
├── Models/              # Eloquent models
├── Policies/            # Authorization policies
└── Providers/           # Service providers
└── Rules/
└── Services/

resources/
├── js/                  # Frontend JavaScript/Vue components
├── css/                 # Stylesheets
└── views/               # Blade templates

database/
├── migrations/          # Database migrations
├── seeders/             # Database seeders
└── factories/           # Model factories

routes/
├── web.php              # Web routes
└── auth.php             # Auth routes
└── console.php
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the GNU License - see the [LICENSE](LICENSE) file for details.

---

Built with ❤️ using Laravel and Inertia.js
