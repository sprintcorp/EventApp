FROM php:8.0-apache

# Install dependencies including MySQL client
RUN a2enmod rewrite
 
RUN apt-get update \
  && apt-get install -y libzip-dev git wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
 
RUN docker-php-ext-install pdo mysqli pdo_mysql zip;
 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www

COPY . /var/www

RUN composer install

RUN a2enmod rewrite

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Copy entrypoint.sh
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Add entrypoint command
ENTRYPOINT ["entrypoint.sh"]

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD [ "apache2-foreground" ]