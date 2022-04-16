FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    openssl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

RUN docker-php-ext-configure gd \
        --with-jpeg \
        NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
        && docker-php-ext-install -j$(nproc) gd

WORKDIR /project

# Add user for application
#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /project

# Copy existing application directory permissions
#COPY --chown=www:www . /template

# Change current user to www
#USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
