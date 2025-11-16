# Notioneers App

Brief description of your app.

## Requirements

- PHP 8.1+
- Composer
- SQLite

## Installation

1. Clone this repository
2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Create SQLite database:
```bash
touch data/app.sqlite
```

5. Run migrations (if applicable)

## Development

Start the development server:
```bash
composer start
```

Visit: http://localhost:8000

## Project Structure

```
.
├── public/           # Web root
│   └── index.php     # Entry point
├── src/
│   ├── Controllers/  # Request handlers
│   ├── Models/       # Database models
│   ├── Middleware/   # Middleware
│   └── routes.php    # Route definitions
├── views/            # Templates
├── data/             # SQLite database
└── tests/            # Tests
```

## Design System

This app uses the Notioneers design system. To include the custom theme:

1. Copy CSS from `design-system/css/theme.css`
2. Update the HTML to use local theme instead of CDN

## Testing

Run tests:
```bash
composer test
```

## Deployment

TODO: Add deployment instructions
