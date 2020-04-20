#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
	echo "Waiting for db to be ready..."
	until bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; do
		sleep 1
	done

  bin/console doctrine:migrations:migrate --no-interaction

  bin/console app:create-first-user
fi

exec docker-php-entrypoint "$@"
