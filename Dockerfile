 # Gunakan image PHP dengan ekstensi Laravel yang dibutuhkan
FROM php:8.2-apache

# Install ekstensi dan dependensi
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan mod_rewrite (penting untuk Laravel routing)
RUN a2enmod rewrite

# Copy semua file Laravel ke container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Jalankan composer install
RUN composer install --no-dev --optimize-autoloader

# Set permission untuk storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 untuk web
EXPOSE 80
