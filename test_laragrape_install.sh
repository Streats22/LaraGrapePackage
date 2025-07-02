#!/bin/bash

# Automated test for LaraGrape package installation in a fresh Laravel app

set -e

# 1. Create a fresh Laravel project
echo "[1/6] Creating fresh Laravel project..."
composer create-project laravel/laravel test-laragrape
cd test-laragrape || exit 1

# 2. Require the LaraGrape package
echo "[2/6] Requiring streats22/laragrape package..."
composer require streats22/laragrape:dev-main

# 3. Run the setup command
echo "[3/6] Running LaraGrape setup command..."
php artisan laragrape:setup --migrate

# 4. Create a Filament admin user (interactive)
echo "[4/6] Creating Filament admin user (follow the prompts)..."
php artisan make:filament-user

# 5. Install and build frontend assets if needed
if [ -f package.json ]; then
    echo "[5/6] Installing and building frontend assets..."
    npm install
    npm run build
else
    echo "[5/6] No package.json found, skipping frontend build."
fi

# 6. Serve the application
echo "[6/6] Serving the application at http://localhost:8000 ..."
php artisan serve 