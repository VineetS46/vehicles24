FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

# Copy code
COPY . /var/www/html/


RUN mkdir -p /var/www/html/upload
RUN chown -R www-data:www-data /var/www/html/upload
RUN chmod -R 755 /var/www/html/upload


EXPOSE 80