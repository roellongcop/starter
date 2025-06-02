FROM php:8.1-apache

# 1) Install OS packages (including default-mysql-client for mysqladmin)
#    plus libraries needed by GD, zip, and other extensions.
RUN apt-get update && \
    apt-get install -y \
      default-mysql-client \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libzip-dev \
      unzip \
      libonig-dev \
      libxml2-dev \
      curl \
    && docker-php-ext-configure gd \
         --with-freetype=/usr/include/ \
         --with-jpeg=/usr/include/ \
    && docker-php-ext-install \
         gd \
         pdo \
         pdo_mysql \
         mysqli \
         zip

# 2) Enable Apache rewrite module
RUN a2enmod rewrite

# 3) Change Apache document root to Yii2’s web/ folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/web
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
     /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
     /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4) Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# 5) Set working directory for Composer
WORKDIR /var/www/html

# 6) Copy only composer files first, then install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# 7) Copy the rest of your application code
COPY . /var/www/html

# 8) Copy entrypoint script and make it executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
