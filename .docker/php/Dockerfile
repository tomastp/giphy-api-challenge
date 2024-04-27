FROM php:8.2-fpm

# Set working directory
WORKDIR /application

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN pecl install redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for application
RUN useradd -G www-data,root -u 1000 -d /home/deploy deploy

RUN mkdir -p /home/deploy/.composer && \
    chown -R deploy:deploy /home/deploy && \
    chown -R deploy:deploy /application

# Copy existing application directory contents
COPY . .

# Change current user to www
USER deploy
