# Getting Started With Event API

## Brief description

The event api provides user with the ability to search for event in city, country and date in between which event starts and end. 

## Features
- Search for event based on date.
- Search for event based on terms and term lookup the city and country column.
- Search for event based on terms and date.

## Tools
- PHP 8
- Symfony framework
- mysql

## Login details

Application is not authenticated neither is authorization required

## Prerequisites

Before installing Symfony 6, ensure that you have the following prerequisites installed on your system:

- PHP 8.0 or higher with the necessary extensions (e.g., intl, pdo, curl)
- Composer (Dependency Manager for PHP)
- MySQL or any other supported database server

## Installation

Clone the repository

    git clone https://github.com/sprintcorp/EventApp.git

Switch to the folder directory

    cd EventApp

Install all the serverside dependencies using composer manager

    composer install

Create .env file if it does not exist and copy the .env.example to .env file and make the required configuration changes (DATABASE_URL)

    cp .env.example .env(WIndows)


Generate a new application key

    php bin/console secret:generate

Create database with this command

    php bin/console doctrine:database:
    
if migration does not exit create migration with this command

    php bin/console make:migration

Run the database migrations (**Set the database connection in .env before migrating**)

    php bin/console doctrine:migrations:migrate

Populate the database with json data in the project directory with custom command below

    php bin/console create:event

Start the local development server

    symfony server:start

You can now access the server at http://127.0.0.1:8000

To run test

    ./run_tests.bat or composer test

This will automate the whole test process by doing the following;

- Check if the test database already exists
- If the database doesn't exist, create it
- Run database migrations
- Run command to create event data
- Run tests
- Clear event table

## Postman documentation

`https://documenter.getpostman.com/view/7305732/2s93sdaCx8`


## Usage

- Get all events `localhost:8000/api/events` method `GET` 
#### Response

    {
    "data": [
        {
        "id": 1,
        "name": "Ex exercitation et occaecat excepteur nostrud aute voluptate elit.",
        "city": "Dupuyer",
        "country": "Bahamas",
        "startDate": "2024-04-07T00:00:00+02:00",
        "endDate": "2024-05-11T00:00:00+02:00"
        },
        {
        "id": 2,
        "name": "Laboris nostrud magna consectetur fugiat ea est ut ad id aliqua do aliqua labore sunt.",
        "city": "Gorham",
        "country": "Greece",
        "startDate": "2024-04-25T00:00:00+02:00",
        "endDate": "2024-05-15T00:00:00+02:00"
        },
        {
        "id": 3,
        "name": "Ad sit amet esse dolore fugiat consequat irure in consectetur cupidatat voluptate.",
        "city": "Somerset",
        "country": "Mayotte",
        "startDate": "2024-04-26T00:00:00+02:00",
        "endDate": "2024-05-12T00:00:00+02:00"
        },
        {
        "id": 4,
        "name": "Ex elit consequat laborum non ad ad commodo est ad fugiat eiusmod occaecat nulla magna.",
        "city": "Rose",
        "country": "Cambodia",
        "startDate": "2024-04-17T00:00:00+02:00",
        "endDate": "2024-05-30T00:00:00+02:00"
        },
        {
        "id": 5,
        "name": "Laborum mollit adipisicing nulla amet.",
        "city": "Vincent",
        "country": "Seychelles",
        "startDate": "2024-04-13T00:00:00+02:00",
        "endDate": "2024-05-23T00:00:00+02:00"
        },
        {
        "id": 6,
        "name": "Cupidatat veniam do adipisicing mollit esse laboris laboris tempor fugiat ex aliqua sint et commodo.",
        "city": "Chestnut",
        "country": "Gibraltar",
        "startDate": "2024-04-22T00:00:00+02:00",
        "endDate": "2024-05-23T00:00:00+02:00"
        },
        {
        "id": 7,
        "name": "Est deserunt sunt sunt consectetur sunt ex id ad in exercitation.",
        "city": "Norvelt",
        "country": "Nauru",
        "startDate": "2024-04-19T00:00:00+02:00",
        "endDate": "2024-05-27T00:00:00+02:00"
        },
        {
        "id": 8,
        "name": "Dolore cillum nisi consequat reprehenderit cupidatat do magna.",
        "city": "Jugtown",
        "country": "Somalia",
        "startDate": "2024-04-11T00:00:00+02:00",
        "endDate": "2024-05-18T00:00:00+02:00"
        },
        {
        "id": 9,
        "name": "Commodo est velit occaecat occaecat ullamco et ea.",
        "city": "Elfrida",
        "country": "Laos",
        "startDate": "2024-04-19T00:00:00+02:00",
        "endDate": "2024-05-14T00:00:00+02:00"
        },
        {
        "id": 10,
        "name": "Laborum incididunt labore et exercitation exercitation consequat velit tempor cupidatat excepteur incididunt do eu cupidatat.",
        "city": "Driftwood",
        "country": "Jamaica",
        "startDate": "2024-04-06T00:00:00+02:00",
        "endDate": "2024-05-09T00:00:00+02:00"
        }
    ],
    "page": 1,
    "perPage": 10,
    "totalPage": 8
    }


- Get events by country and city filtering using term to filter `localhost:8000/api/events?term=greece` method `GET` 
#### Response

    {
    "data": [
        {
        "id": 2,
        "name": "Laboris nostrud magna consectetur fugiat ea est ut ad id aliqua do aliqua labore sunt.",
        "city": "Gorham",
        "country": "Greece",
        "startDate": "2024-04-25T00:00:00+02:00",
        "endDate": "2024-05-15T00:00:00+02:00"
        }
    ],
    "page": 1,
    "perPage": 10,
    "totalPage": 1
    }


- Get events within the range between startDate and endDate `localhost:8000/api/events?date=2024-04-11` method `GET` 
#### Response

    {
    "data": [
        {
        "id": 1,
        "name": "Ex exercitation et occaecat excepteur nostrud aute voluptate elit.",
        "city": "Dupuyer",
        "country": "Bahamas",
        "startDate": "2024-04-07T00:00:00+02:00",
        "endDate": "2024-05-11T00:00:00+02:00"
        },
        {
        "id": 8,
        "name": "Dolore cillum nisi consequat reprehenderit cupidatat do magna.",
        "city": "Jugtown",
        "country": "Somalia",
        "startDate": "2024-04-11T00:00:00+02:00",
        "endDate": "2024-05-18T00:00:00+02:00"
        },
        {
        "id": 10,
        "name": "Laborum incididunt labore et exercitation exercitation consequat velit tempor cupidatat excepteur incididunt do eu cupidatat.",
        "city": "Driftwood",
        "country": "Jamaica",
        "startDate": "2024-04-06T00:00:00+02:00",
        "endDate": "2024-05-09T00:00:00+02:00"
        },
        {
        "id": 11,
        "name": "Ex tempor exercitation nulla elit non minim deserunt aute in duis incididunt.",
        "city": "Eggertsville",
        "country": "Eritrea",
        "startDate": "2024-04-07T00:00:00+02:00",
        "endDate": "2024-05-09T00:00:00+02:00"
        },
        {
        "id": 20,
        "name": "Dolore in dolor ipsum aliquip deserunt nulla duis commodo esse laborum sunt.",
        "city": "Mayfair",
        "country": "Paraguay",
        "startDate": "2024-04-09T00:00:00+02:00",
        "endDate": "2024-05-22T00:00:00+02:00"
        },
        {
        "id": 23,
        "name": "Reprehenderit laborum ad cillum ullamco ad eiusmod cillum cillum dolore aliquip magna cupidatat.",
        "city": "Ladera",
        "country": "Swaziland",
        "startDate": "2024-04-10T00:00:00+02:00",
        "endDate": "2024-05-12T00:00:00+02:00"
        },
        {
        "id": 24,
        "name": "Enim esse ex ad amet id in commodo incididunt et excepteur consectetur sit.",
        "city": "Roosevelt",
        "country": "Cuba",
        "startDate": "2024-04-05T00:00:00+02:00",
        "endDate": "2024-05-01T00:00:00+02:00"
        },
        {
        "id": 25,
        "name": "Tempor quis quis Lorem ullamco minim commodo est laboris laborum duis in amet nostrud.",
        "city": "Grayhawk",
        "country": "Peru",
        "startDate": "2024-04-04T00:00:00+02:00",
        "endDate": "2024-05-11T00:00:00+02:00"
        },
        {
        "id": 28,
        "name": "Duis amet ipsum minim dolore.",
        "city": "Drytown",
        "country": "Suriname",
        "startDate": "2024-04-09T00:00:00+02:00",
        "endDate": "2024-05-18T00:00:00+02:00"
        },
        {
        "id": 29,
        "name": "Nostrud dolor mollit enim amet occaecat id officia voluptate excepteur.",
        "city": "Conway",
        "country": "Zimbabwe",
        "startDate": "2024-04-03T00:00:00+02:00",
        "endDate": "2024-05-08T00:00:00+02:00"
        }
    ],
    "page": 1,
    "perPage": 10,
    "totalPage": 4
    }


- Get events within the range between startDate and endDate and country and city is equal term `https://localhost:8000/api/events?term=greece&date=2024-04-26` method `GET` 
#### Response

    {
    "data": [
        {
        "id": 2,
        "name": "Laboris nostrud magna consectetur fugiat ea est ut ad id aliqua do aliqua labore sunt.",
        "city": "Gorham",
        "country": "Greece",
        "startDate": "2024-04-25T00:00:00+02:00",
        "endDate": "2024-05-15T00:00:00+02:00"
        }
    ],
    "page": 1,
    "perPage": 10,
    "totalPage": 1
    }