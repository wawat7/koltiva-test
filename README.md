<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# HOW TO RUN WITH DOCKER
- Setup file .env (the example .env will be like this)
```javascript
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:ebcXdznCy+9I/1F66JhZ0cabVnLtmWZKUgymj9dQ+to=
APP_DEBUG=true
APP_URL=http://localhost

JWT_SECRET=3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTY3NzkxNTEyOCwiaW

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=laravel-mysql
DB_PORT=3306
DB_DATABASE=koltiva
DB_USERNAME=koltiva
DB_PASSWORD=koltiva
```
- Run docker compose
```
docker-compose up -d --build --remove-orphans
```
- Your app will be run on port **8000**


# HOW TO UPDATE SWAGGER
```
php artisan l5-swagger:generate
```

# HOW TO ACCESS SWAGGER
```
http://localhost:8000/api/documentation
```

# HOW TO SYMLINK FOLDER STORAGE TO PUBLIC
```
php artisan storage:link
```
