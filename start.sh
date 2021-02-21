sudo /usr/sbin/crond -l 8
php /var/www/app artisan queue:listen &
