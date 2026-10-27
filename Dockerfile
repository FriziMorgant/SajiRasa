FROM php:8.2-apache

# 1. Install sistem dependensi yang dibutuhkan
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

# 2. Install Node.js 20.x untuk kompilasi Vite (Tailwind CSS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. Install ekstensi PHP (PostgreSQL & GD untuk gambar)
RUN docker-php-ext-install pdo pdo_pgsql gd

# 4. Install Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Aktifkan mod_rewrite Apache agar routing Laravel / URL tidak 404
RUN a2enmod rewrite

# 6. Set working directory
WORKDIR /var/www/html
COPY . /var/www/html

# 7. Install dependencies PHP & Build asset Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 8. Konfigurasi Apache Document Root agar langsung mengarah ke folder public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# 9. Izinkan Apache membaca file .htaccess (PENTING agar tidak 404)
RUN sed -i '/<Directory \/var/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 10. Berikan hak akses penuh ke folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Buat entrypoint script untuk otomatis migrasi & seeder database saat menyala
RUN echo '#!/bin/bash' > /entrypoint.sh \
    && echo 'php artisan config:clear' >> /entrypoint.sh \
    && echo 'php artisan cache:clear' >> /entrypoint.sh \
    && echo 'php artisan migrate --seed --force' >> /entrypoint.sh \
    && echo 'apache2-foreground' >> /entrypoint.sh \
    && chmod +x /entrypoint.sh

EXPOSE 80

CMD ["/entrypoint.sh"]
