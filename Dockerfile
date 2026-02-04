# Usamos PHP 7.3 porque Laravel 5.8 no es compatible con PHP 8
FROM php:7.3-fpm

# Instalamos dependencias del sistema necesarias para MySQL y Postgres
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Instalamos las extensiones de PHP para que Laravel hable con las bases de datos
RUN docker-php-ext-install pdo_mysql pdo_pgsql

# Instalamos Composer (el gestor de paquetes de PHP)
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Nos movemos a la carpeta de trabajo
WORKDIR /var/www