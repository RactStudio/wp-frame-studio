# WP Frame Studio

`WP Frame Studio` is the modern Laravel-inspired core builder framework for WordPress. It serves as the foundation for `WP Plugin Frame` and `WP Theme Frame`, providing a unified ecosystem for building robust plugins and themes with clarity, structure, and modern practices.

With a clean, modular architecture, `WP Frame Studio` reimagines WordPress development — bringing Laravel-like organization, advanced tooling, and smooth workflows to the WordPress world.

It's the framework behind the frameworks — built for humans who love clean, modern, and scalable WordPress development.

## Installation

```bash
composer require ractstudio/wp-frame-studio
```

## Quick Start

```php
<?php
// In your plugin or theme's main file

require_once __DIR__ . '/vendor/autoload.php';

$app = RactStudio\FrameStudio\FrameStudio::bootstrap(__DIR__);
```

## Features

- **Service Container**: Dependency Injection container for managing services
- **Service Providers**: Modular, opt-in architecture for features
- **REST API Router**: Clean, expressive routing for WordPress REST API
- **Cache System**: WordPress Transients-based caching with extensible drivers
- **Queue System**: Background job processing with WP-Cron integration
- **Security**: Built-in sanitization, validation, nonce verification, and authorization
- **Form Requests**: Request validation and authorization layer
- **CLI Tools**: Symfony Console integration for custom commands
- **Facades**: Static access to container-bound services
- **Error Handling**: Whoops integration for detailed error reporting in development

## Documentation

For full documentation, see the [Developer Guide](idea/WP%20Frame%20Studio%20Developer%20Guide.txt) and [Ecosystem Overview](idea/The%20WP%20Frame%20Studio%20Ecosystem.txt).

## Links

- [Composer Package](https://packagist.org/packages/ractstudio/wp-frame-studio)
- [WP Plugin Frame](https://github.com/RactStudio/wp-plugin-frame)
- [WP Theme Frame](https://github.com/RactStudio/wp-theme-frame)

## License

MIT
