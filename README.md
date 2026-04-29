## Cara Menjalankan Project

### == Masuk ke masing-masing service ==

### == Install dependency ==
1. composer install
2. copy .env.example .env
3. php artisan key:generate
4. php artisan migrate

### == Jalankan ==
1. user-service → port 8001
2. book-serivce → port 8002
3. loan-service → port 8003
4. gateway-perpus → port 8000
