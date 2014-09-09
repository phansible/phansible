server {
    listen   80;
    server_name  {{ item.hostname }};
    access_log /var/log/phpmyadminaccess.log;
    error_log /var/log/phpmyadminierror.log;
    root /usr/share/nginx/www/phpmyadmin;

    location / {
        index  index.php;
    }

    ## Images and static content is treated different
    location ~* ^.+.(jpg|jpeg|gif|css|png|js|ico|xml)$ {
    access_log        off;
    expires           360d;
    }

    location ~ /\.ht {
        deny  all;
    }

    location ~ /(libraries|setup/frames|setup/libs) {
        deny all;
        return 404;
    }

    location ~ \.php$ {
        include /etc/nginx/fastcgi_params;
        fastcgi_pass unix:/var/run/php5-fpm.sock;

        #check your /etc/php5/fpm/pool.d/www.conf to see if fpm is listening on a socket or a port.
        #;listen = /var/run/php5-fpm.sock
        #listen = 127.0.0.1:9000

        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME /usr/share/nginx/www/phpmyadmin$fastcgi_script_name;
    }
}