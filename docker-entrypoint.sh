#!/usr/bin/env bash
set -e

# 1) Wait for MariaDB to be ready
until mysqladmin ping -h mariadb -P 3306 --silent; do
  echo "Waiting for mariadb…"
  sleep 2
done

# 2) Create the database if it doesn’t exist
mysql -h mariadb -P 3306 \
  -u root -p"$MYSQL_ROOT_PASSWORD" \
  -e "CREATE DATABASE IF NOT EXISTS \`$MYSQL_DATABASE\` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

# 3) cd into the app folder (which is a host bind-mount)
cd /var/www/html

# 4) If vendor/ is missing (i.e. first run), do a composer install
if [ ! -d vendor ]; then
  echo "Installing Composer dependencies…"
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 5) Run migrations
php /var/www/html/yii migrate --interactive=0

# 6) Start Apache
exec apache2-foreground
