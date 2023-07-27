cd /var/www/pokersocial
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan optimize
chown -R www-data:www-data /var/www/pokersocial
chmod -R 777 storage/
