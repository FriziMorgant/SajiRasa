FROM php:8.2-apache

# 1. Install sistem dependensi & curl
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

# 2. Install Node.js 20.x (PENTING untuk build asset CSS/JS Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. Install ekstensi PHP untuk PostgreSQL & GD
RUN docker-php-ext-install pdo pdo_pgsql gd

# 4. Install Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Aktifkan mod_rewrite Apache (PENTING agar routing tombol tidak 404)
RUN a2enmod rewrite

# 6. Tentukan direktori kerja
WORKDIR /var/www/html
COPY . /var/www/html

# 7. Install package PHP dan BUILD aset Vite (CSS/JS agar tampilan rapi)
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 8. Atur Document Root Apache ke folder public Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# 9. Berikan izin hak akses folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Buat entrypoint otomatis untuk migrasi database dan seeding data awal
RUN echo '#!/bin/bash' > /entrypoint.sh \
    && echo 'php artisan config:clear' >> /entrypoint.sh \
    && echo 'php artisan cache:clear' >> /entrypoint.sh \
    && echo 'php artisan migrate --seed --force' >> /entrypoint.sh \
    && echo 'apache2-foreground' >> /entrypoint.sh \
    && chmod +x /entrypoint.sh

EXPOSE 80

CMD ["/entrypoint.sh"]
