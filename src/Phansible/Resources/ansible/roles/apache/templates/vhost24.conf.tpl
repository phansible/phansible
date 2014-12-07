# Default Apache virtualhost template

<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot {{ apache.docroot }}
    ServerName {{ apache.servername }}

    <Directory {{ apache.docroot }}>
        AllowOverride All
        Options -Indexes +FollowSymLinks
        Require all granted
    </Directory>
</VirtualHost>
