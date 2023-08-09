# Todo-co

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/068038d149ae45e7bcce911cf74e07d5)](https://app.codacy.com/gh/m-perraud/Todo-co/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

<a href="https://codeclimate.com/github/m-perraud/Todo-co/maintainability"><img src="https://api.codeclimate.com/v1/badges/f8356698a03e4721d780/maintainability" /></a>

### Install
In order to get started you first need to clone the project:
- `git clone https://github.com/m-perraud/bilemo-new.git`

We will need composer for the project. 
- `at the root, run composer install`

### Prerequisites

-   Composer **version 2** and superior
-   PHP 8.1 and superior
-   A MySQL Server up and running
-   Symfony 6.3 and superior

### Database

The database informations are stored in the .env file :
- `DATABASE_URL="mysql://root:@127.0.0.1:3306/todo-co"`

You have to modify those informations if you won't use the same. 
To set up the database, you will need to follow these steps : 

• Create the database if not already done : 
- `php bin/console doctrine:database:create`

• Make the migration : 
- `php bin/console doctrine:migrations:migrate`

• Get the data from the fixtures : 
- `php bin/console doctrine:fixtures:load`

If you want to log in with no specific account but depending on the role, we just created two users in the database thanks to the fixtures : 
- `ROLE_ADMIN` : username -> admin , password -> AppFixturesPass
- `ROLE_USER` : username -> anonyme , password -> AppFixturesPass

### Tests

To be able to test the app, you'll need to run one of these two commands :
- `vendor/bin/phpunit --testdox` to see if the tests are validated simply
- `vendor/bin/phpunit --coverage-html public/test-coverage` to get the details of the tests, and an html version
