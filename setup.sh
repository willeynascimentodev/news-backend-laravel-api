composer install
docker compose up -d
docker compose exec -i news-laravel-api cp .env.example .env
docker compose exec -i news-laravel-api php artisan key:generate
docker compose exec -i news-laravel-api php artisan jwt:secret
docker compose exec -i news-laravel-api php artisan config:clear

docker compose exec -i news-laravel-api php artisan migrate:fresh --env=local
docker compose exec -i news-laravel-api php artisan db:seed --env=local
