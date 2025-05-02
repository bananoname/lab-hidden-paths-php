FROM php:8.1-apache

# Cài thêm extension nếu cần (ví dụ: mysqli)
RUN docker-php-ext-install mysqli

# Bật mod_rewrite để hỗ trợ .htaccess
RUN a2enmod rewrite

# Copy Virtual Host
COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy source code
COPY . /var/www/html

# Cấp quyền cho Apache user
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
