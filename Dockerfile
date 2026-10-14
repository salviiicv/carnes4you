FROM php:8.2-apache

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
RUN mkdir -p storage/framework/views storage/framework/sessions storage/framework/cache bootstrap/cache
RUN composer install --no-dev --no-scripts --prefer-dist --ignore-platform-reqs

# Generar el autoloader sin ejecutar scripts automáticos de descubrimiento
RUN composer dump-autoload --optimize --no-dev --no-scripts

# Ajustar permisos para almacenamiento y caché
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80