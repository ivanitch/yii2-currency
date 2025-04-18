FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        nano wget cron htop unzip git curl jq mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install php extensions
# @see https://github.com/mlocati/docker-php-extension-installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions calendar gettext mbstring zip imap exif intl mysqli pdo_mysql pdo_sqlite xsl yaml sysvmsg gmagick bcmath

#COPY conf.d/* ${PHP_INI_DIR}/conf.d/

# Install xdebug
#RUN pecl install xdebug \
# && docker-php-ext-enable xdebug

# Add Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add user
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
RUN chown -R www:www /var/www/html
USER www

# Set working directory
WORKDIR /var/www/html

EXPOSE 80/tcp
EXPOSE 443/tcp
EXPOSE 9000

CMD ["php-fpm"]
