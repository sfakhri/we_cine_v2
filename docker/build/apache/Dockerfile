FROM php:8.1-apache

ARG TIMEZONE="Europe/Paris"
ENV ACCEPT_EULA=Y
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    zip \
    wget \
    ssh \
    libssl-dev \
    libffi-dev \
    ca-certificates \
    nano

# Apache SSL
RUN a2enmod ssl rewrite headers
RUN a2ensite default-ssl

# Install SQL Server Driver
RUN apt-get update && apt-get install -y \
    gnupg \
    gnupg2 \
    unixodbc-dev \
    freetds-dev \
    && apt-get update && apt-get install -y \
    && docker-php-ext-install pdo pdo_mysql opcache \
    && docker-php-ext-enable opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
# RUN wget https://get.symfony.com/cli/installer -O - | bash
# RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Set working directory
WORKDIR /var/www/symfony

# Expose port 80 443
EXPOSE 80 443

# Start Apache
CMD ["apache2-foreground"]