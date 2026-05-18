FROM php:8.3-apache

# Instalar extensiones necesarias para Laravel, SQLite y Node.js
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_sqlite

# Instalar Node.js sin "creatividad" extra, solo el software real
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Cambiar la raíz de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Instalar Composer (Backend)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Instalar dependencias de JS y compilar Vite (Frontend)
RUN npm install
RUN npm run build

# Asegurar que el archivo de base de datos exista si no lo subiste
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite

# Dar permisos a las carpetas correspondientes
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/database

EXPOSE 80

# Ejecutar migraciones automáticas al iniciar el contenedor
CMD php artisan migrate:fresh --seed --force && apache2-foreground