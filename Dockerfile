FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git
RUN docker-php-ext-install pdo pdo_mysql gd

# Aktifkan mod_rewrite Apache untuk Laravel
RUN a2enmod rewrite

# Salin seluruh kode proyek ke direktori web server
COPY . /var/www/html

# Ubah DocumentRoot Apache ke folder public Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Atur hak akses folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
