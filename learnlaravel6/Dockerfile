FROM richarvey/nginx-php-fpm

LABEL maintainer="lpy <yao50cn@163.com>" version="2.6"


ADD . /var/www/html

COPY ./default.conf /etc/nginx/sites-enabled/default.conf

WORKDIR /var/www/html

CMD ["sh", "/var/www/html/entrypoint.sh"]

#CMD ["sh", "/var/www/swoft2/entrypoint.sh"]

#CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=3000" ]

#CMD ["./start.sh"]
#CMD ["tail", "-f", "/src/Dockerfile"]

#CMD nohup sh -c '/opt/swoole/script/php/swoole_php /opt/swoole/node-agent/src/node.php & && php /var/www/swoft/bin/swoft http:start'
#CMD ["php", "/var/www/swoft/bin/swoft", "http:start"]