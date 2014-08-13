server {
    listen  80;

    root {{ doc_root }};
    index index.html index.php;

    server_name {{ server_name }};

    if (-f {{ doc_root }}/maintenance.html) {
        return 503;
    }

    error_page 503 @maintenance;

    location @maintenance {
        rewrite ^(.*)$ /maintenance.html break;
    }

    location / {
        try_files $uri $uri/ /index.php;
    }

    error_page 404 /404.html;

    error_page 500 502 504 /50x.html;
        location = /50x.html {
        root /usr/share/nginx/www;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
