FROM php:8.2-apache

# 1. Install sistem dependensi
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg

# 2. Install ekstensi PHP
RUN docker-php-ext-install pdo pdo_pgsql gd

# 3. Install Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 5. Set working directory
WORKDIR /var/www/html
COPY . /var/www/html

# 6. Install package PHP saja (tanpa npm build di server karena sudah dibuild di lokal)
RUN composer install --no-dev --optimize-autoloader

# 7. Konfigurasi Document Root Apache ke folder public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# 8. Berikan izin hak akses folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Buat entrypoint otomatis untuk migrasi & seeder
RUN echo '#!/bin/bash' > /entrypoint.sh \
    && echo 'php artisan config:clear' >> /entrypoint.sh \
    && echo 'php artisan cache:clear' >> /entrypoint.sh \
    && echo 'php artisan migrate --seed --force' >> /entrypoint.sh \
    && echo 'apache2-foreground' >> /entrypoint.sh \
    && chmod +x /entrypoint.sh

EXPOSE 80

CMD ["/entrypoint.sh"]
