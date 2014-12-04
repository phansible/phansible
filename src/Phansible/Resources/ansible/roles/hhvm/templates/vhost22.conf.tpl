# Default Apache hhvm virtualhost template

<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot {{ apache.docroot }}
    ServerName {{ apache.servername }}

    <Directory {{ apache.docroot }}>
        AllowOverride All
        Options -Indexes FollowSymLinks
        Order allow,deny
        Allow from all
    </Directory>

    <IfModule mod_fastcgi.c>
        <FilesMatch \.php$>
            SetHandler hhvm-php-extension
        </FilesMatch>

        <FilesMatch \.hh$>
            SetHandler hhvm-hack-extension
        </FilesMatch>

        Alias /hhvm /hhvm
        Action hhvm-php-extension /hhvm virtual
        Action hhvm-hack-extension /hhvm virtual

        FastCgiExternalServer /hhvm -host 127.0.0.1:9000 -pass-header Authorization -idle-timeout 300
    </IfModule>
</VirtualHost>
