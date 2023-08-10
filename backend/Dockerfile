FROM composer:2.5.8

# Install dependencies
RUN apt-get update && apt-get install -y \
  build-essential \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  zip \
  unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Set up the application directory
RUN mkdir -p /var/www/app
WORKDIR /var/www/app

# Copy the application code
COPY . /var/www/app

# Install the application dependencies
RUN composer install --no-dev --optimize-autoloader

# Set the file permissions
RUN chmod -R 755 /var/www/app