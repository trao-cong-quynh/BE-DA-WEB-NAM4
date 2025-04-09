FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY . .

# Laravel setup
RUN composer install --no-dev --optimize-autoloader && \
    chmod -R 775 storage bootstrap/cache

# Expose correct port
EXPOSE 8080

# Start Laravel using built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
