# Utiliser une image de base PHP avec Apache
FROM php:8.3-apache

# Installer les bibliothèques de développement PostgreSQL
# libicu-dev : for intl
RUN apt-get update && apt-get install -y libpq-dev curl unzip git libicu-dev

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pgsql intl

# Copier le code de votre application dans le répertoire approprié
COPY ./src /var/www/

WORKDIR "/var/www"

RUN chown -R www-data:www-data /var/www/
RUN chmod -R 775 /var/www/writable/
RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN echo "$DOTENV" > .env
RUN composer install
RUN php spark optimize

CMD ["php", "spark", "serve", "--host", "0.0.0.0", "--port", "7860"]
