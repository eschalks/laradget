composer install --no-dev -o
php artisan migrate
php artisan config:cache
php artisan route:cache
