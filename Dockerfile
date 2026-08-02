FROM dunglas/frankenphp:php8.2

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP extensions
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

RUN npm install

RUN npm run build

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
