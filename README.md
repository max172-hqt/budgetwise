<p align="center">
  BudgetWise is a small PHP web application to track expenses and debts
  quickly within a trip with your friends - A clone of SplitWise
</p>

## Introduction

This application is built up from scratch with Composer autoload features and various PHP packages
for the learning purpose of backend-dev with PHP.

## Screenshots
<img width="1464" alt="Screenshot 2023-07-21 at 6 33 40 PM" src="https://github.com/max172-hqt/budgetwise/assets/55776151/bd34c00f-ceeb-436f-b927-1776ab831a32">

## Features
- Authentication with sessions
- A user can add trips and add users to the trips
- A user can log transactions to a trip
- Users can see the trip expense summary and how to resolve debts with other members in the trip
 
## Project Libraries
- `symfony/http-kernel`
  - Main application shell (See `Router.php`), processing requests and produce responses
- `symfony/http-foundation`
  - Sensible wrapper around PHP globals such as `$_GET`, `$_POST`, `$_SERVER` with `Request` object
- `twig/twig`
  - Template library
- `doctrine ORM`
  - Database stuff
- `php-di/php-di`
  - Service container and handle dependency injections (see different Controller class and `bootstrap.php`)
- `moneyphp/money`
  - Library for monetary calculation

## Installation

- By default, the application uses sqlite, feel free to load you own db configuration using in
config/database.php

```
composer install

# Database initialization with doctrine ORM
php bin/doctrine orm:schema-tool:update -f --dump-sql

# Execute fixtures to produce some fake data
php bin/execute_fixture.php

# Run local server
php -S localhost:8000 -t public/
```

## Database Design

### Tables
- users: User information and credentials, used for authentication
  - name
  - email
  - password
- trips: Trip expenses
  - name
- transaction
  - name
  - amount
  - currency

### Table Relationships
- One user can belong to many trips
- One trip can have many users
- One trip can have many transactions
- One transaction belongs to one user
 
## TODO
- [ ] Build error page corresponding to HTTP error code (i.e. 403, 404)
- [ ] Session flash error messages
- [ ] Delete / Update transactions
- [ ] Add new members to an existing trip
- [ ] Handle redirect better

## Disclaimer
- This project is for my learning purpose of PHP to see how different pieces are glued together. 
And it could be helpful to someone who wants to see how to set up a PHP projects 
from scratch with composer and standalone libraries. Therefore, it's not ready for production.
