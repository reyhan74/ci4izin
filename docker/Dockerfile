FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip \
    unzip \
    git \
    libpng-dev \
    && docker-php-ext-install intl pdo pdo_mysql mysqli \
    && docker-php-ext-enable intl mysqli

# Enable Apache rewrite (Penting untuk URL CI4)
RUN a2enmod rewrite

# Set document root ke folder public CI4
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY . .

# Set permission agar folder writable (writable/ & public/uploads/)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/writable