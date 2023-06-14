@echo off

REM Step 1: Check if the test database already exists
php bin/console doctrine:query:sql "SELECT 1 FROM information_schema.schemata WHERE schema_name = 'event_app_test_database'" --env=test > nul 2>&1

REM Step 2: If the database doesn't exist, create it
IF %ERRORLEVEL% NEQ 0 (
    php bin/console doctrine:database:create --env=test
)

REM Step 3: Run database migrations
php bin/console doctrine:migrations:migrate --env=test --no-interaction

REM Step 4: Run command to create event data
php bin/console create:event --env=test

REM Step 5: Run tests
php bin/phpunit

REM Step 6: Clear event table
php bin/console doctrine:query:sql "TRUNCATE TABLE event" --env=test
