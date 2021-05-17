### init
- `printf "UID=$(id -u)\nGID=$(id -g)" > .env`
- `docker-compose up -d`
- `docker-compose run shipmonk-packing-app bash`
- `composer install && vendor/bin/doctrine orm:schema-tool:create && vendor/bin/doctrine dbal:import data/packaging-data.sql`

### run
- `php run.php "$(cat sample.json)"`

### adminer
- Open `http://localhost:8080/?server=mysql&username=root&db=packing`
- Password: secret

### check
- `php vendor/bin/phpstan analyse src`
