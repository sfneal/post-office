# Base PHP image tags & Laravel .env file
ARG php_composer_tag=8.0-v1

# Build temp image to install composer dependencies
FROM stephenneal/php-composer:${php_composer_tag} AS composer
WORKDIR /var/www
ARG composer_flags=""

# Copy composer & phpunit files
COPY ["composer.json", "phpunit.xml.dist", "/var/www/"]

# Install composer dependencies
RUN composer update --no-scripts --no-autoloader ${composer_flags}



# Build final image
FROM stephenneal/php-composer:${php_composer_tag}
WORKDIR /var/www

# Copy relevant files from base image
COPY --from=composer /var/www .

# Copy Package source
COPY config  /var/www/config/
COPY src  /var/www/src/
COPY tests  /var/www/tests/

# Install composer dependencies
RUN composer dump-autoload

ENTRYPOINT ["vendor/bin/phpunit"]
