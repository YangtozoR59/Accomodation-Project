FROM php:8.3-fpm

# Arguments
ARG user=laravel
ARG uid=1000

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Création d'un utilisateur système pour exécuter les commandes Composer et Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de l'application
COPY --chown=$user:$user . /var/www

# Changer l'utilisateur
USER $user

# Exposer le port 9000
EXPOSE 9000

CMD ["php-fpm"]