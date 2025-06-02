# Dockerfile (updated)

FROM php:8.1-apache

# 1) Install system libraries needed by GD (and other PHP extensions)
RUN apt-get update && \
    apt-get install -y \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libzip-dev \
      unzip \
      libonig-dev \
      libxml2-dev \
    && docker-php-ext-configure gd \
         --with-freetype=/usr/include/ \
         --with-jpeg=/usr/include/ \
    && docker-php-ext-install \
         gd \
         pdo \
         pdo_mysql \
         mysqli

# 2) Enable Apache rewrite module (for pretty URLs)
RUN a2enmod rewrite

# 3) Change Apache document root to /var/www/html/web (Yii2’s “web” folder)
ENV APACHE_DOCUMENT_ROOT /var/www/html/web

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
     /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
     /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4) Copy application code into container
COPY . /var/www/html
