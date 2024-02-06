#!/bin/bash

ENV_PATH=$1
if [[ -z "$ENV_PATH" ]]; then
    ENV_PATH=".env"
    echo "Empty ENV_PATH (arg 1). Using default: {$ENV_PATH}"
else
    mv .env .env.backup
    ln -s $ENV_PATH .env
fi

ENV=$2
if [[ -z "$ENV" ]]; then
    ENV="local"
    echo "Empty ENV (arg 2). Using default: {$ENV}"
fi

# Install dependencies
rm -rf ./vendor
rm ./composer.lock
composer install

# Configure app
rm -rf public/storage
php artisan --env=$ENV storage:link

# Create database
php artisan --env=$ENV migrate:fresh

# Rollback migrations
read -p "How many rollback steps? (0-10): " x
while [[ $x -lt 0 || $x -gt 10 ]]; do
    read -p "Enter a valid number between 0 and 10: " x
done
if [[ $x -gt 0 ]]; then
    php artisan --env=$ENV migrate:rollback --step=$x
    read -n 1 -s -r -p "Check database and press any key to continue..."
    php artisan --env=$ENV migrate
fi

# Seed database
php artisan --env=$ENV db:seed

# Tests
php artisan test tests/Feature/DbTest.php

# Deploy app
php artisan --env=$ENV serve