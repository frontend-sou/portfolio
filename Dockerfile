# ベースイメージとして公式PHPイメージを使用
FROM php:8.3-fpm

# 必要なライブラリをインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Composerのインストール
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# 作業ディレクトリを設定
WORKDIR /var/www/html

# アプリケーションコードをコピー
COPY . .

# Composerで依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# NPMでフロントエンド依存関係をインストール
RUN npm install && npm run build

# Laravelの設定
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# ポートを公開
EXPOSE 9000

# コンテナ起動時のコマンドを設定
CMD ["php-fpm"]
