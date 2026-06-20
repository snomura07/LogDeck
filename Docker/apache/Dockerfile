FROM httpd:2.4

RUN sed -i 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' /usr/local/apache2/conf/httpd.conf \
    && sed -i 's/^#LoadModule proxy_module/LoadModule proxy_module/' /usr/local/apache2/conf/httpd.conf \
    && sed -i 's/^#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' /usr/local/apache2/conf/httpd.conf \
    && sed -i 's#^DocumentRoot ".*"#DocumentRoot "/var/www/html/public"#' /usr/local/apache2/conf/httpd.conf \
    && sed -i 's#^<Directory ".*">#<Directory "/var/www/html/public">#' /usr/local/apache2/conf/httpd.conf \
    && echo "ServerName localhost" >> /usr/local/apache2/conf/httpd.conf

COPY Docker/apache/logdeck.conf /usr/local/apache2/conf/extra/logdeck.conf

RUN echo "Include /usr/local/apache2/conf/extra/logdeck.conf" >> /usr/local/apache2/conf/httpd.conf

WORKDIR /var/www/html
