FROM php:8.4-apache

# Instalar dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    sqlite3 \
    libsqlite3-dev

RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Activar mod_rewrite de Apache para Laravel
RUN a2enmod rewrite

# Configurar Apache para apuntar a la carpeta public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Crear la estructura de almacenamiento e instalar dependencias
ENV COMPOSER_MEMORY_LIMIT=-1
RUN mkdir -p storage/framework/views storage/framework/sessions storage/framework/cache bootstrap/cache database

# Crear el archivo sqlite si no existe
RUN touch database/database.sqlite

# Instalar dependencias y optimizar autoloader
RUN composer install --no-dev --no-scripts --prefer-dist --ignore-platform-reqs
RUN composer dump-autoload --optimize --no-dev --no-scripts

# Otorgar permisos a la carpeta de almacenamiento y a la base de datos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80