FROM httpd:2.4
WORKDIR /UTU-project
EXPOSE 8080
COPY ./interfaz /usr/local/apache2/htdocs/
COPY ./mYhttpd.conf /usr/local/apache2/conf/httpd.conf
VOLUME [ "/var/log/apache2", "var/www" ]