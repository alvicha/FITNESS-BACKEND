# Usa la imagen oficial de PHP con FPM y las extensiones necesarias
FROM php:8.2-fpm

# Configurar entorno a producción
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instala paquetes necesarios
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia solo composer.json y composer.lock para instalar dependencias primero (optimización de caché)
COPY --chown=www-data:www-data composer.json composer.lock symfony.lock /var/www/html/

# Instala dependencias de Composer sin ejecutar auto-scripts
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts

# Copia el resto de archivos de la aplicación
COPY --chown=www-data:www-data . /var/www/html

# Ejecuta cache:clear en entorno prod (y evita fallos si falta el directorio cache)
RUN mkdir -p var/cache var/log && chown -R www-data:www-data var/cache var/log \
    && php bin/console cache:clear --env=prod || true

# Ajusta permisos finales
RUN chown -R www-data:www-data /var/www/html

# Define el comando de inicio
CMD ["php-fpm"]