FROM php:8.3-apache

# Instalar extensiones necesarias para Laravel y SQLite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_sqlite

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Cambiar la raíz de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Asegurar que el archivo de base de datos exista si no lo subiste
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite

# ¡CRUCIAL! Dar permisos a storage, cache Y a la carpeta de la base de datos
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/database

# Exponer el puerto por defecto
EXPOSE 80

CMD ["apache2-foreground"]