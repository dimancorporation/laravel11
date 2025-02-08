#!/bin/sh

# Останавливаем выполнение при первой ошибке
set -e

echo "Клонирование репозитория..."
git clone --branch "$GIT_BRANCH" --single-branch "$GIT_REPO" /var/www/html

cd /var/www/html

echo "Установка зависимостей через Composer..."
composer install --no-dev --optimize-autoloader

echo "Генерация уникального ключа приложения..."
php artisan key:generate

echo "Установка зависимостей Node.js..."
npm ci

echo "Сборка фронтенд-ресурсов..."
npm run prod

echo "Настройка завершена."
