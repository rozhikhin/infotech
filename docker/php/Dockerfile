FROM php:7.4-fpm

USER root

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libjpeg-dev \
    libwebp-dev \
    libxpm-dev \
    libfreetype6 \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libmemcached-dev \
    iputils-ping \
    libz-dev \
    libssl-dev \
    zlib1g \
    libmagickwand-6.q16 \
    ghostscript


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mysqli zip exif pcntl pdo pdo_pgsql

RUN docker-php-ext-configure gd \
    --with-webp \
    --with-jpeg \
    --with-freetype


RUN docker-php-ext-install gd

#RUN pecl install memcached

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN apt-get update && apt-get install -y libmagickwand-6.q16-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
#RUN printf "\n" | pecl install imagick
#RUN docker-php-ext-enable imagick


# Change current user to www-data
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

