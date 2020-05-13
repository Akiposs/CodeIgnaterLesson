FROM php:7.4.3-fpm-alpine3.11

# COPYはCOPY先が/付き出ないとエラー起きる
# またボリュームはホスト側のディレクトリ構造で上書きしてしまうので、コンテナ生成時に出来たものをそのまま
# 使いたい場合は、一部を予め用意し、COPYで渡してあげるのがベターなのではないか
# COPY ./phpfpm/initialize/php.ini /etc/php7/
COPY ./phpfpm/initialize/php-fpm.conf /usr/local/etc/
COPY ./phpfpm/initialize/www.conf /usr/local/etc/php-fpm.d/

RUN apk --no-cache update && \
  apk --no-cache add \
  sudo \
  vim \
  composer &&\
  adduser -D nginx

CMD [ "/bin/sh" ]

# 新規環境構築時は、.envの手渡し、「 chmod 777 -R storage」コマンド要実行
# [php -m | grep pdo] でmysql_pdoがインストールされているか確認すること
# [composer install]コマンドが初期は必要

# laravelの.envファイルでDB_HOSTは「mysql」で名前解決できる