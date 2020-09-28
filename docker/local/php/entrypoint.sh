#!/usr/bin/env bash
set -e

# Step 1
if [[ -z "${DOCKER_WITH_MAC}" ]]; then
  # Not Mac, so determine actual docker container IP address
  HOST=`/sbin/ip route|awk '/default/ { print $3 }'`
else
  # Otherwise use special value, which works wit Mac
  HOST="docker.for.mac.localhost"
fi

sed -i "s/xdebug\.remote_host \=.*/xdebug\.remote_host\=$HOST/g" /usr/local/etc/php/php.ini

export DOCKER_IP=`/sbin/ip route|awk '/default/ { print $3 }'`

# Step 2
COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader

# Step 3

php /app/artisan key:generate

# Step 4
make setup-git-hooks

# Step 5 (wait mysql container)
/wait

# Step 6
php /app/artisan cache:clear
php /app/artisan config:clear
php /app/artisan route:clear
php /app/artisan view:clear

chmod -R gu+w /app/storage
chmod -R guo+w /app/storage

# Step 7
php /app/artisan migrate:refresh --seed

exec "$@"
