### install
- `docker run --rm --interactive --tty --volume $PWD:/app composer install`

### run
- `docker run --interactive --rm --name shipmonk-box --volume "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.4-cli php run.php "$(cat input.json)"`

### check
- `docker run --interactive --rm --name shipmonk-box --volume "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.4-cli php vendor/bin/phpstan analyse src`
