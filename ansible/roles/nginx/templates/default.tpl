{% if tls_ready %}
server {
    listen 80;
    server_name {{ server_name }};

    location /.well-known/acme-challenge/ {
        root {{ acme_root }};
    }

    location / {
        return 301 https://$host$request_uri;
    }
}

{% endif %}
server {
{% if tls_ready %}
    listen 443 ssl;
    http2 on;
    ssl_certificate {{ tls_cert_dir }}/fullchain.pem;
    ssl_certificate_key {{ tls_cert_dir }}/privkey.pem;
{% else %}
    listen 80;
{% endif %}

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
        try_files $uri /index.php$is_args$args;
    }

    error_page 404 /404.html;

    error_page 500 502 504 /50x.html;
        location = /50x.html {
        root /usr/share/nginx/html;
    }

    location = /index.php {
        fastcgi_pass unix:/run/php/php{{ php_version }}-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        internal;
    }

    location ~ \.php$ {
        return 404;
    }
}
