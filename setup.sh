#!/bin/bash

echo "🚀 Setting up CEMS - Campus Event Management System"

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker Desktop and try again."
    exit 1
fi

echo "📦 Building Docker containers..."
docker-compose up -d --build

echo "⏳ Waiting for containers to be ready..."
sleep 10

echo "📥 Installing Laravel..."
docker-compose exec -T app composer create-project laravel/laravel . "10.*" --prefer-dist

echo "📥 Installing Livewire..."
docker-compose exec -T app composer require livewire/livewire

echo "📥 Installing Laravel Sanctum..."
docker-compose exec -T app composer require laravel/sanctum

echo "📥 Installing additional dependencies..."
docker-compose exec -T app composer require intervention/image
docker-compose exec -T app composer require spatie/laravel-permission

echo "🔧 Setting up environment..."
docker-compose exec -T app cp .env.example .env
docker-compose exec -T app php artisan key:generate

echo "📊 Publishing vendor assets..."
docker-compose exec -T app php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
docker-compose exec -T app php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

echo "🗄️ Running migrations..."
docker-compose exec -T app php artisan migrate

echo "🌱 Seeding database..."
docker-compose exec -T app php artisan db:seed

echo "📦 Installing Node dependencies..."
docker-compose exec -T app npm install
docker-compose exec -T app npm install -D tailwindcss postcss autoprefixer alpinejs
docker-compose exec -T app npx tailwindcss init -p

echo "🎨 Building assets..."
docker-compose exec -T app npm run build

echo "✅ Setup complete! Access the application at http://localhost:8000"
