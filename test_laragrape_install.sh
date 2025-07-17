#!/bin/bash

# Automated test for LaraGrape package installation in a fresh Laravel app

set -e

# 1. Create a fresh Laravel project
echo "[1/6] Creating fresh Laravel project..."
composer create-project laravel/laravel test-laragrape
cd test-laragrape || exit 1

# 2. Require the LaraGrape package from local path
echo "[2/6] Requiring LaraGrape package from local path..."
composer config repositories.laragrape-local path .
composer require streats22/laragrape:dev-Development

# 3. Run the setup command
echo "[3/7] Running LaraGrape setup command..."
php artisan laragrape:setup --migrate

# 4. Run the seeders
echo "[4/7] Running database seeders..."
php artisan db:seed

# 5. Create a Filament admin user (interactive)
echo "[5/7] Creating Filament admin user (follow the prompts)..."
php artisan make:filament-user

# 6. Install and build frontend assets if needed
if [ -f package.json ]; then
    echo "[6/7] Installing and building frontend assets..."
    npm install
    npm run build
else
    echo "[6/7] No package.json found, skipping frontend build."
fi

# 7. Serve the application
echo "[7/7] Serving the application at http://localhost:8000 ..."