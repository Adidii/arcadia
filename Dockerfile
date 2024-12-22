# Use an official PHP image as the base image
FROM php:8.1-fpm

# Install the necessary tools and libraries
RUN apt-get update && apt-get install -y \
    libz-dev \
    libssl-dev \
    libprotobuf-dev \
    protobuf-compiler \
    autoconf \
    automake \
    libtool \
    make \
    g++


   
    RUN pecl install grpc
    RUN docker-php-ext-enable grpc
    
    RUN pecl install protobuf
    RUN docker-php-ext-enable protobuf
    
    
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]
