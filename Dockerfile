FROM php:8.3-cli-alpine

# Install necessary dependencies
RUN apt-get update && apt-get install -y libpq-dev curl unzip git libicu-dev

RUN docker-php-ext-install pgsql intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Copy only composer files first to leverage cache
COPY ./src/composer.json ./src/composer.lock ./

# Install dependencies (CodeIgniter will optimize during php spark anyway)
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-progress

# Copy app source code
COPY ./src ./

# Permissions
RUN chown -R www-data:www-data /var/www && chmod -R ugo+w /var/www/writable

# Env file
# RUN --mount=type=secret,id=DOTENV,mode=0444,required=true cp /run/secrets/DOTENV .env
COPY ./src/env .env

# Optimize CodeIgniter
RUN php spark optimize || echo "spark optimize failed"

CMD ["php", "spark", "serve", "--host", "0.0.0.0", "--port", "7860"]
