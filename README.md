# student-rating

- Introduction : https://gist.github.com/tomsihap/5a0d0a69f891a2c57d4d815c216c22e9
- Complete API specs (Swagger) : https://app.swaggerhub.com/apis-docs/tomsihap/student-notation/0.0.0

## Setup

1. Remplissez le fichier `.env.local`

2. Dans un terminal ouvert dans le dossier du projet :
```sh
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migration
symfony server:start --no-tls # serveur de test sans support SS
```