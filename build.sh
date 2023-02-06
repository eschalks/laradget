composer install --no-dev -o
php artisan migrate --force
php artisan config:cache
php artisan route:cache
