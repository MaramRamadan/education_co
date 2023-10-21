# Base image
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# Enable required Apache modules
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath xml zip

# Copy the project files to the container
COPY . .

# Set file permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy the .env.example file to the container
COPY .env.example .env

# Check if .env file already exists
RUN test -f .env || cp .env.example .env

# Generate application key
RUN php artisan key:generate

# Clear configuration cache
RUN php artisan config:cache

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
