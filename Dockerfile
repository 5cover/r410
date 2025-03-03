# Utiliser une image de base PHP avec Apache
FROM php:8.0-apache

# Installer les bibliothèques de développement PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pgsql

# Copier le code de votre application dans le répertoire approprié
COPY ./src /var/www/

# Configurer les permissions si nécessaire
RUN chown -R www-data:www-data /var/www/html/

CMD ["php", "src/spark", "optimize"]
CMD ["php", "src/spark", "serve", "--host", "0.0.0.0", "--port", "7860"]
