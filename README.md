### init
- `docker-compose up -d`
- `docker-compose run shipmonk-packing-app bash`
- `composer install`
- `vendor/bin/doctrine orm:schema-tool:create`

### run
- `php run.php "$(cat input.json)"`

### adminer
- Open `http://localhost:8080/?pgsql=postgres:5432&username=root&db=postgres`
- Password: secret

### check
- `php vendor/bin/phpstan analyse src`
