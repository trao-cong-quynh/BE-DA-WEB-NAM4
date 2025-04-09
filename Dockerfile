# Dockerfile

FROM php:8.2-fpm

# Cài các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo thư mục dự án
WORKDIR /var/www

COPY . .

# Cài đặt Laravel
RUN composer install --no-dev --optimize-autoloader

# Phân quyền thư mục storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Cổng cho Laravel
EXPOSE 8000

# Chạy Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000
