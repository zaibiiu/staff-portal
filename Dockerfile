FROM dunglas/frankenphp:php8.2

RUN install-php-extensions \
    intl \
    zip \
    pdo_mysql \
    mbstring \
    xml \
    curl \
    fileinfo \
    gd \
    exif \
    pcntl \
    bcmath

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN php artisan storage:link || true

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
