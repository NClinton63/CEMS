# CEMS Quick Start Guide

## ✅ What's Been Updated

1. **Database**: Switched from PostgreSQL to MySQL 8.0
2. **Test Data**: Enhanced seeder with 33 users and 25 diverse events
3. **Views**: Created simple, clean Blade templates with Tailwind CSS

---

## 🚀 Setup Instructions

### 1. Start Docker Containers

```bash
cd /Users/clintonngwa/Documents/github/CEMS
docker-compose up -d --build
```

### 2. Install PHP Dependencies

```bash
docker-compose exec app composer install
```

### 3. Generate Application Key

```bash
docker-compose exec app php artisan key:generate
```

### 4. Run Database Migrations & Seed Data

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

This will create:
- **3 Administrators**: admin@cems.local, john.admin@cems.local, sarah.manager@cems.local
- **30 Students**: student@cems.local, emma.smith@cems.local, liam.johnson@cems.local, etc.
- **25 Events**: Various categories (Workshop, Seminar, Conference, Social, Sports, Cultural, Academic, Career)
- **Registrations**: Realistic registration data with some past events marked as attended

### 5. Install Frontend Dependencies & Build Assets

```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

### 6. Set Permissions

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### 7. Access the Application

Open your browser: **http://localhost:8000**

---

## 🔑 Test Credentials

### Administrator Account
- **Email**: admin@cems.local
- **Password**: password
- **Access**: Can create, edit, and manage all events

### Student Account
- **Email**: student@cems.local
- **Password**: password
- **Access**: Can browse and register for events

### Additional Test Accounts
- john.admin@cems.local / password (Administrator)
- sarah.manager@cems.local / password (Administrator)
- emma.smith@cems.local / password (Student)
- liam.johnson@cems.local / password (Student)
- olivia.williams@cems.local / password (Student)

---

## 📊 Test Data Overview

### Users
- 3 Administrators
- 30 Students with realistic names

### Events (25 total)
- **Workshops**: Web Development, Python Programming, Cybersecurity, Public Speaking
- **Seminars**: AI & Machine Learning, Climate Change
- **Conferences**: Entrepreneurship, Sustainability Summit
- **Cultural**: Music Festival, Photography Exhibition, Film Screening, Art Fair
- **Sports**: Basketball Tournament, Gaming Tournament
- **Social**: Mental Health Awareness, Yoga & Meditation, Volunteer Day
- **Academic**: Research Symposium, Science Fair
- **Career**: Career Fair, Alumni Networking, Mock Interviews

### Event Distribution
- Past events (with attendance records)
- Upcoming events (available for registration)
- Draft events (not visible to students)
- Cancelled events

### Registrations
- 30-80% capacity filled for published events
- Past events have attendance marked
- Realistic registration patterns

---

## 🎨 Available Pages

### Public Pages
- **/** - Browse all events (with search and category filter)
- **/events/{id}** - Event details page
- **/login** - Login page
- **/register** - User registration page

### Authenticated Pages
- **/dashboard** - User dashboard with registration history and stats
- **/admin/events** - Event management (Administrators only)

---

## 🛠️ Useful Commands

### View Application Logs
```bash
docker-compose logs -f app
```

### Access Container Shell
```bash
docker-compose exec app bash
```

### Clear Cache
```bash
docker-compose exec app php artisan optimize:clear
```

### Rebuild Frontend Assets (during development)
```bash
docker-compose exec app npm run dev
```

### Reset Database & Reseed
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### Stop Containers
```bash
docker-compose down
```

### Completely Reset (including volumes)
```bash
docker-compose down -v
docker-compose up -d --build
```

---

## 🧪 Testing the Application

### 1. Browse Events
- Visit http://localhost:8000
- Use search to find events
- Filter by category

### 2. Student Registration Flow
- Login as student@cems.local
- Click on an event
- Register for the event
- View dashboard to see registrations

### 3. Admin Event Management
- Login as admin@cems.local
- Go to "Manage Events"
- Create a new event
- Edit existing events
- View registrations

### 4. API Testing
```bash
# Login via API
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@cems.local","password":"password"}'

# List events (use token from login response)
curl -X GET http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📝 Database Configuration

The application now uses **MySQL 8.0** with the following settings:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=cems
DB_USERNAME=cems_user
DB_PASSWORD=secret
```

---

## ✨ Features to Test

- ✅ Event browsing with search and filters
- ✅ User authentication (login/register)
- ✅ Event registration with capacity enforcement
- ✅ Registration cancellation
- ✅ Admin event creation and management
- ✅ Dashboard with registration history
- ✅ Responsive design (mobile-friendly)
- ✅ Role-based access control
- ✅ Past event attendance tracking

---

## 🐛 Troubleshooting

### Port 8000 already in use
```bash
# Stop any process using port 8000
lsof -ti:8000 | xargs kill -9
# Or change port in docker-compose.yml
```

### Database connection errors
```bash
# Check if MySQL container is running
docker-compose ps
# Restart database
docker-compose restart db
```

### Permission errors
```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

---

## 🎯 Next Steps

1. Customize event categories
2. Add event banner images
3. Configure email notifications
4. Set up production environment
5. Add more test scenarios

Enjoy testing CEMS! 🎉
