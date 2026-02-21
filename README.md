# CEMS - Campus Event Management System

A production-grade, full-stack campus event platform enabling discovery, registration, management, and analytics of campus events.

## Features

- **Multi-Role Access**: Students and Administrators with role-based permissions
- **Event Management**: Create, edit, publish, and manage campus events
- **Registration System**: Capacity-enforced event registration with attendance tracking
- **Secure Authentication**: JWT-based authentication with Laravel Sanctum
- **Real-time Updates**: Livewire-powered interactive UI
- **Email Notifications**: Automated notifications for registrations and updates
- **Audit Logging**: Complete audit trail of all system actions

## Technology Stack

- **Backend**: Laravel 10.x (PHP 8.2)
- **Frontend**: Livewire 3.x, Alpine.js, Tailwind CSS
- **Database**: PostgreSQL 15
- **Cache/Queue**: Redis
- **Web Server**: Nginx
- **Containerization**: Docker & Docker Compose

## Prerequisites

- Docker Desktop
- Docker Compose
- Git

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd CEMS
```

### 2. Build and start Docker containers

```bash
d
```

### 3. Install dependencies

```bash
docker-compose exec app composer install
```

### 4. Set up environment

```bash
cp .env.example .env
docker-compose exec app php artisan key:generate
```

### 5. Run migrations and seeders

```bash
docker-compose exec app php artisan migrate --seed
```

### 6. Install frontend dependencies

```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

### 7. Access the application

Open your browser and navigate to: `http://localhost:8000`

## Default Credentials

### Administrator
- Email: admin@cems.local
- Password: password

### Student
- Email: student@cems.local
- Password: password

## API Documentation

### Authentication Endpoints

- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login user
- `POST /api/auth/logout` - Logout user
- `POST /api/auth/refresh` - Refresh token

### Event Endpoints

- `GET /api/events` - List all events
- `GET /api/events/{id}` - Get event details
- `POST /api/events` - Create event (Admin only)
- `PUT /api/events/{id}` - Update event (Admin only)
- `DELETE /api/events/{id}` - Delete event (Admin only)

### Registration Endpoints

- `POST /api/events/{id}/register` - Register for event
- `DELETE /api/events/{id}/register` - Cancel registration
- `GET /api/events/{id}/registrations` - List registrations (Admin only)
- `POST /api/events/{id}/attendance` - Mark attendance (Admin only)

## Development

### Running tests

```bash
docker-compose exec app php artisan test
```

### Code style

```bash
docker-compose exec app ./vendor/bin/pint
```

### Clear cache

```bash
docker-compose exec app php artisan optimize:clear
```

## Deployment

### Production Environment Variables

Update the following in your production `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-secure-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
```

### Build for production

```bash
docker-compose exec app npm run build
docker-compose exec app php artisan optimize
```

## Security

- All passwords are hashed using bcrypt
- JWT tokens expire after 60 minutes
- CSRF protection enabled
- SQL injection prevention via Eloquent ORM
- XSS protection via Laravel's Blade templating
- Rate limiting on API endpoints

## License

Proprietary - All rights reserved

## Support

For support, email support@cems.local
# CEMS
