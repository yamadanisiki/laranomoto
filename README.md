# laranomoto
docker on laravel quick starter🐇
dockerとdocker comporseを入れたら動くよ！

## 構成
laravelでウェブアプリを作るベース。
入ってるものは以下の通り。
- nginx
- mysql
- phpmyadmin
- php-fpm
  - bootstrap4
  - laravel/ui
  - laravel/sosialite
    - twitter
    - google(仕様変更には未対応)

## phpサーバー初回設定
ヘルパースクリプトが上手く起動できない・・・
phpが落ちちゃうので、今んところ初回起動時はphpコンテナに入って初回起動用のバッシュを動かしたいです

    docker container exec -it laranomoto_php_1 bash
    sh /root/docker-entrypoint.sh

参考：http://docs.docker.jp/engine/articles/dockerfile_best-practice.html