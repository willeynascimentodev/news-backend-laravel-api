composer install
docker compose up -d
docker compose exec -i news-laravel-api cp .env.example .env
docker compose exec -i news-laravel-api php artisan key:generate
docker compose exec -i news-laravel-api php artisan config:clear
