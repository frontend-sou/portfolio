# ベースイメージとして公式PHPイメージを使用
FROM php:8.3-fpm AS runner

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
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Install nodejs
COPY --from=node:20-slim /usr/local/bin /usr/local/bin
COPY --from=node:20-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

# NPMでフロントエンド依存関係をインストール
RUN npm install && npm run build

# Laravelの設定
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Nginxステージ
RUN apt install nginx -y

# Nginxの設定をコピー
COPY nginx.conf /etc/nginx/nginx.conf

# ポートを公開
EXPOSE 80

RUN chown -R www-data:www-data /var/www/html
# RUN chown www-data:www-data /var/www/html/storage
# RUN chown www-data:www-data /var/www/html/bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# コンテナ起動時のコマンドを設定
# CMD ["nginx", "-g", "daemon off;"]
ENTRYPOINT [ "docker-entrypoint.sh" ]
# CMD ["php-fpm", "daemonize"]
