# CEMS Installation Guide

## Prerequisites

- Docker Desktop (latest version)
- Docker Compose
- Git
- At least 4GB RAM available for Docker

## Quick Start

### 1. Clone and Setup

```bash
cd /Users/clintonngwa/Documents/github/CEMS
```

### 2. Start Docker Containers

```bash
docker-compose up -d --build
```

This will start:
- **app**: PHP 8.2-FPM with Laravel
- **nginx**: Web server on port 8000
- **db**: PostgreSQL 15 database
- **redis**: Redis cache/queue server

### 3. Install PHP Dependencies

```bash
docker-compose exec app composer install
```

### 4. Setup Environment

```bash
cp .env.example .env
docker-compose exec app php artisan key:generate
```

### 5. Run Database Migrations

```bash
docker-compose exec app php artisan migrate --seed
```

This creates:
- Database tables (users, events, registrations, audit_logs)
- Admin user: `admin@cems.local` / `password`
- Student user: `student@cems.local` / `password`
- Sample events and registrations

### 6. Install Frontend Dependencies

```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

### 7. Create Storage Link

```bash
docker-compose exec app php artisan storage:link
```

### 8. Set Permissions

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### 9. Access Application

Open your browser and navigate to:
- **Web Interface**: http://localhost:8000
- **API Base URL**: http://localhost:8000/api

## Default Credentials

### Administrator Account
- **Email**: admin@cems.local
- **Password**: password
- **Role**: administrator

### Student Account
- **Email**: student@cems.local
- **Password**: password
- **Role**: student

## Useful Commands

### View Logs
```bash
docker-compose logs -f app
```

### Access Container Shell
```bash
docker-compose exec app bash
```

### Run Artisan Commands
```bash
docker-compose exec app php artisan [command]
```

### Clear Cache
```bash
docker-compose exec app php artisan optimize:clear
```

### Run Tests
```bash
docker-compose exec app php artisan test
```

### Stop Containers
```bash
docker-compose down
```

### Rebuild Containers
```bash
docker-compose down
docker-compose up -d --build
```

## Troubleshooting

### Port 8000 Already in Use
```bash
# Change port in docker-compose.yml
ports:
  - "8080:80"  # Changed from 8000:80
```

### Database Connection Issues
```bash
# Check if database container is running
docker-compose ps

# Restart database
docker-compose restart db

# Check database logs
docker-compose logs db
```

### Permission Errors
```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Clear All Data and Start Fresh
```bash
docker-compose down -v
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan migrate:fresh --seed
docker-compose exec app npm install && npm run build
```

## Development Workflow

### Making Code Changes

1. Edit files in your local directory
2. Changes are automatically reflected (volumes are mounted)
3. For CSS/JS changes, rebuild assets:
   ```bash
   docker-compose exec app npm run build
   ```

### Database Changes

1. Create migration:
   ```bash
   docker-compose exec app php artisan make:migration create_table_name
   ```

2. Run migration:
   ```bash
   docker-compose exec app php artisan migrate
   ```

### Creating New Features

1. **Model**: `docker-compose exec app php artisan make:model ModelName -m`
2. **Controller**: `docker-compose exec app php artisan make:controller ControllerName`
3. **Livewire Component**: `docker-compose exec app php artisan make:livewire ComponentName`
4. **Policy**: `docker-compose exec app php artisan make:policy PolicyName`

## API Testing

### Using cURL

```bash
# Register User
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "Password123!",
    "password_confirmation": "Password123!",
    "role": "student"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@cems.local",
    "password": "password"
  }'

# List Events (with token)
curl -X GET http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Production Deployment

### Environment Variables

Update `.env` for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_HOST=your-production-db-host
DB_DATABASE=your-production-db-name
DB_USERNAME=your-production-db-user
DB_PASSWORD=your-secure-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
```

### Optimization Commands

```bash
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app npm run build
```

## Security Checklist

- [ ] Change all default passwords
- [ ] Set `APP_DEBUG=false` in production
- [ ] Use HTTPS in production
- [ ] Set strong `APP_KEY`
- [ ] Configure proper CORS settings
- [ ] Enable rate limiting
- [ ] Set up proper backup strategy
- [ ] Configure firewall rules
- [ ] Use environment-specific `.env` files
- [ ] Enable Laravel's built-in CSRF protection

## Support

For issues or questions:
1. Check logs: `docker-compose logs -f app`
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check database connectivity
4. Verify environment variables

## Next Steps

1. Customize the application branding
2. Configure email settings for notifications
3. Set up automated backups
4. Configure monitoring and logging
5. Implement additional features as needed
