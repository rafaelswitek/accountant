# Usa a imagem oficial do PHP como base
FROM php:8.3-fpm

ARG user=switek
ARG uid=1000

# Instala dependências
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    nano

# Instala extensões PHP necessárias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip mbstring exif pcntl bcmath opcache

# Instale a extensão MongoDB para PHP
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Instalação do servidor Nginx
RUN apt-get install -y nginx

# Configura o diretório de trabalho
WORKDIR /var/www/html

# Copia o código da aplicação
COPY . .

# Instala as dependências do Composer
RUN composer install --no-scripts --no-autoloader

# Copia o arquivo de configuração do ambiente
COPY .env.example .env

# Gera a chave da aplicação
RUN php artisan key:generate

# Configura permissões de escrita
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expõe a porta 9000 para o PHP-FPM
EXPOSE 9000

# Comando padrão
CMD ["php-fpm"]

USER $user