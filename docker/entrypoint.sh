#!/usr/bin/env sh
set -e

if [ ! -d vendor ]; then
  composer install --no-interaction
fi

mkdir -p var
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console app:create-admin-user admin@example.com admin123

exec php -S 0.0.0.0:8000 -t public
