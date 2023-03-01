# Partimos de la imagen php en su versión 8.1 es suficiente para Laravel 9
FROM php:8.1-fpm

WORKDIR /var/www/

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get install -y    \
build-essential                         \
libzip-dev                              \
libpng-dev                              \
libjpeg62-turbo-dev                     \
libfreetype6-dev                        \
libonig-dev                             \
locales                                 \
zip                                     \
jpegoptim optipng pngquant gifsicle     \
vim                                     \
git                                     \
curl

# Instalamos extensiones de PHP
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

RUN pecl install xdebug \
&& docker-php-ext-enable xdebug

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Exponemos el puerto 9000 para nginx
EXPOSE 9000

# Corremos el comando php-fpm para ejecutar PHP
CMD ["php-fpm"]