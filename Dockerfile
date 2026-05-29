FROM php:8.2-apache

# Install PHP extensions yang dibutuhkan CI4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        intl \
        mbstring \
        zip \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Apache vhost config dengan AllowOverride All
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set document root ke public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Copy project
WORKDIR /var/www/html
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader 2>/dev/null || true

# Permission writable folder
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 755 /var/www/html/writable \
    && mkdir -p /var/www/html/public/uploads \
    && chown -R www-data:www-data /var/www/html/public/uploads \
    && chmod -R 755 /var/www/html/public/uploads

EXPOSE 80
