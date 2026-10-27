FROM php:8.2-apache

# Install system dependencies
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

# Install Node.js (untuk compile Vite assets)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html

# Install package PHP & Node.js, lalu build Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Setting Apache document root ke folder public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
