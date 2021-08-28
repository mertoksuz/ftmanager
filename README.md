# Welcome to Football Manager
You can list leagues and manage teams belongs that leagues. Manager gives you abilities to create, read, list and delete teams.
## Tech Stack
 - PHP 8.0
   - Symfony 5
 - MySQL 8.0
 - nGinx
 - Docker
 - Git

# How to Run ?

If requires
`chmod +x ./deploy/run.sh` and just type and enter -> `./deploy/run.sh`

# How to Run Tests ?
`./vendor/bin/phpunit`


# Run Migrations 
`docker exec -it php bin/console doctrine:migrations:migrate`

Migrations will provide sample User, Team and League data.

# Sample Login

You can use below data in request body as JSON to get a JWT Token

`
{
"username": "mert",
"password": "mert"
}
`

_Thanks for read and check._