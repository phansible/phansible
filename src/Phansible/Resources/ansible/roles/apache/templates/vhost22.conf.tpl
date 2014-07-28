# Default Apache virtualhost template



<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot {{ doc_root }}

    <Directory {{doc_root}}>

    AllowOverride All
    Order allow,deny
    Allow from all
    </Directory>

</VirtualHost>
