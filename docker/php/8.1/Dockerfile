FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG USER
ARG ID
ARG GROUP

# Install system dependencies
RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mariadb-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Setup working directory
WORKDIR /var/www/

# Create system user to run Composer and Artisan Commands
RUN groupadd -g 1000 ${GROUP} && useradd -u ${ID} -ms /bin/bash -g ${GROUP} ${USER}
RUN mkdir -p /home/${USER}/.composer && \
    chown -R ${USER}:${GROUP} /home/${USER}

# Select User
USER ${USER}

# Copy permission to selected user
COPY --chown=${USER}:${GROUP} . .

EXPOSE 9000

CMD ["php-fpm"]
