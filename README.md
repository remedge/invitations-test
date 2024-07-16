# Description

Example of Symfony console command and web page to generate invitations for a party with specific radius and coordinates.

# Requirements

- composer
- php 8.2

# Setup

```composer install```

# Run

## Web version

1. Run the server

```symfony serve```

or

```php -S localhost:8000 public/index.php```

2. Open  http://127.0.0.1:8000

## Console command

```bin/console app:invitations```

# Tests & code-style check

## Run tests

```composer tests```

## Run code-style check

```composer ecs ```

```composer phpstan```

```composer psalm```

## Altogether

```composer check-all```