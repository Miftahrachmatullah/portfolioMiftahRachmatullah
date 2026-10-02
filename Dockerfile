FROM node:22-alpine AS frontend

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js .
RUN npm run build

FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev unzip \
    && docker-php-ext-install pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=frontend /app/public/build public/build

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
    && chown -R www-data:www-data storage bootstrap/cache \
    && printf '%s\n' '<VirtualHost *:80>' '    DocumentRoot /var/www/html/public' '    <Directory /var/www/html/public>' '        AllowOverride All' '        Require all granted' '    </Directory>' '</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

CMD ["bash", "-lc", "php artisan migrate --force && php artisan storage:link || true; apache2-foreground"]
