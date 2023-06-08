#!/bin/bash

# Wait for the database to start
until nc -z -v -w30 mysql 3306
do
  echo "Waiting for database connection..."
  sleep 5
done

# Create the database if it doesn't exist
php bin/console doctrine:database:create --if-not-exists

# Run database migrations
php bin/console doctrine:migrations:migrate --no-interaction

symfony server:start

# Start PHP-FPM server
php-fpm
