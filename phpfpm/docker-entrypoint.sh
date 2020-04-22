#!/bin/sh

#初回起動時のみlaravelインストール
if [ ! -d "/var/www/laravel/vendor" ]; then
  cd /var/www/laravel
  composer install
  #npmの準備
  npm install
  npm run dev
fi

#sosilite googleproviderのエンドポイント変更
sed -i -e "s|https://www.googleapis.com/plus/v1/people/me|https://accounts.google.com/o/oauth2/auth|g" vendor/socialiteproviders/google/Provider.php

#envファイルの生成
cd /var/www/laravel
cp .env.example .env
php artisan key:generate

#マイグレーション
php artisan migrate

#パーミッション設定
chmod 777 -R storage/