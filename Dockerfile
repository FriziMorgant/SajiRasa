FROM php:8.2-apache

# 1. Install system dependencies yang dibutuhkan Laravel & PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# 2. Install PHP extensions untuk PDO PostgreSQL dan GD (gambar)
RUN docker-php-ext-install pdo pdo_pgsql gd

# 3. Install Composer resmi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Aktifkan modul rewrite Apache agar routing Laravel (.htaccess) berfungsi
RUN a2enmod rewrite

# 5. Atur Document Root Apache ke folder /public milik Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# 6. Izinkan AllowOverride agar file .htaccess dibaca oleh Apache
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf \
    && echo '    Options Indexes FollowSymLinks' >> /etc/apache2/apache2.conf \
    && echo '    AllowOverride All' >> /etc/apache2/apache2.conf \
    && echo '    Require all granted' >> /etc/apache2/apache2.conf \
    && echo '</Directory>' >> /etc/apache2/apache2.conf

# 7. Tentukan working directory
WORKDIR /var/www/html

# 8. Salin seluruh file project ke dalam kontainer
COPY . /var/www/html

# 9. Atur hak akses (permission) folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# 10. Install package vendor menggunakan Composer
RUN composer install --no-dev --optimize-autoloader

# 11. Buat entrypoint script untuk menjalankan perintah otomatis saat kontainer menyala
RUN echo '#!/bin/bash' > /entrypoint.sh \
    && echo 'php artisan config:clear' >> /entrypoint.sh \
    && echo 'php artisan cache:clear' >> /entrypoint.sh \
    && echo 'php artisan route:clear' >> /entrypoint.sh \
    && echo 'php artisan storage:link' >> /entrypoint.sh \
    && echo 'php artisan migrate --force' >> /entrypoint.sh \
    && echo 'apache2-foreground' >> /entrypoint.sh \
    && chmod +x /entrypoint.sh

# 12. Buka port 80 dan jalankan entrypoint
EXPOSE 80
CMD ["/entrypoint.sh"]
