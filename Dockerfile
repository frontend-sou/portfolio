# ベースイメージの設定
FROM php:8.3-fpm

# 必要なビルド依存関係をインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    curl \
    libonig-dev \
    libzip-dev \
    nodejs \
    npm \
    apache2 \
    libapache2-mod-php8.3 && \
    docker-php-ext-install pdo_mysql

# Dockerコンテナの作業ディレクトリを設定
WORKDIR /var/www/html

# Composerのインストール
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# アプリケーションのコピー
COPY . .

# Composerを使用してPHP依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# npmを使用してフロントエンド依存関係をインストール
RUN npm install && npm run prod

# Apacheの設定
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ポート80を公開
EXPOSE 80

# サービスの起動コマンドを設定
CMD ["apache2-foreground"]
