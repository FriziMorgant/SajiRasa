FROM php:8.2-apache
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libpq-dev zip unzip git curl
RUN docker-php-ext-install pdo pdo_pgsql gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN a2enmod rewrite
WORKDIR /var/www/html
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN echo '#!/bin/bash' > /entrypoint.sh \
    && echo 'php artisan config:clear' >> /entrypoint.sh \
    && echo 'php artisan cache:clear' >> /entrypoint.sh \
    && echo 'php artisan migrate --seed --force' >> /entrypoint.sh \
    && echo 'apache2-foreground' >> /entrypoint.sh \
    && chmod +x /entrypoint.sh
EXPOSE 80
CMD ["/entrypoint.sh"]
