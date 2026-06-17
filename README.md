# Contao Backend User Style Bundle

Adds a checkbox to each backend user's profile to individually enable or disable custom CSS and JavaScript in the Contao 5 backend.

## Installation

```bash
composer require codesache/contao-backend-user-style-bundle
```

Run migrations after installation:

```bash
php bin/console contao:migrate
```

## Usage

The bundle ships with its own default backend styles. No configuration is required out of the box.

Each backend user will find a checkbox **„Backend-Anpassungen aktivieren"** in their profile under the *Backend-Theme* section.

## Custom CSS/JS

To use your own files instead of the bundled defaults, add to `config/config.yaml`:

```yaml
codesache_backend_user_style:
    css:
        - files/backend/my-custom.css
    js:
        - files/backend/my-custom.js
```

Paths are relative to the project's `public/` directory.

## Requirements

- PHP 8.2+
- Contao 5.3+

## License

MIT – see [LICENSE](LICENSE)
