#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

# Ensure Composer deps
if [ ! -d vendor ]; then
  echo "[entrypoint] Running composer install..."
  composer install --prefer-dist --no-interaction
fi

# Ensure .env exists
if [ ! -f .env ]; then
  if [ -f .env.docker ]; then
    cp .env.docker .env
  elif [ -f .env.example ]; then
    cp .env.example .env
  fi
fi

# Generate app key if missing
php artisan key:generate --force || true

# Run migrations (ignore if none)
php artisan migrate --force || true

# Serve the app
echo "[entrypoint] Starting Laravel dev server on 0.0.0.0:8000"
php artisan serve --host 0.0.0.0 --port 8000