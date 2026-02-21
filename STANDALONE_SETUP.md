# CEMS - Standalone Setup Guide

This guide will help you run the CEMS application standalone with just MySQL in Docker and Apache/PHP on your local machine.

## 🎯 Architecture

- **Laravel Application**: Runs standalone on your local machine
- **MySQL Database**: Runs in Docker container
- **Apache Server**: Runs on your local machine (or use PHP built-in server)

---

## 📋 Prerequisites

### Required Software
1. **PHP 8.2+** with extensions:
   - pdo_mysql
   - mbstring
   - xml
   - bcmath
   - gd
   - curl

2. **Composer** (PHP dependency manager)

3. **Node.js & NPM** (for frontend assets)

4. **Docker** (for MySQL only)

5. **Apache** (optional - can use PHP built-in server)

---

## 🚀 Installation Steps

### 1. Start MySQL Database

```bash
# Start MySQL container
docker-compose up -d

# Verify MySQL is running
docker ps
```

### 2. Install PHP Dependencies

```bash
# Install Composer dependencies
composer install
```

### 3. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Setup Database

```bash
# Run migrations and seed data
php artisan migrate:fresh --seed
```

### 5. Install Frontend Dependencies

```bash
# Install NPM packages
npm install

# Build assets
npm run build

# Or for development with hot reload
npm run dev
```

### 6. Set Permissions

```bash
# Make storage and cache writable
chmod -R 775 storage bootstrap/cache
```

---

## 🌐 Running the Application

### Option A: PHP Built-in Server (Recommended for Development)

```bash
php artisan serve
```

Access the application at: **http://localhost:8000**

### Option B: Apache Server

1. **Copy Apache configuration:**
   ```bash
   # On macOS
   sudo cp apache-config.conf /etc/apache2/sites-available/cems.conf
   
   # On Ubuntu/Debian
   sudo cp apache-config.conf /etc/apache2/sites-available/cems.conf
   sudo a2ensite cems
   ```

2. **Update the DocumentRoot** in `apache-config.conf` to match your project path

3. **Enable mod_rewrite:**
   ```bash
   sudo a2enmod rewrite
   ```

4. **Restart Apache:**
   ```bash
   # macOS
   sudo apachectl restart
   
   # Ubuntu/Debian
   sudo systemctl restart apache2
   ```

5. **Add to hosts file** (optional):
   ```bash
   echo "127.0.0.1 cems.local" | sudo tee -a /etc/hosts
   ```

Access the application at: **http://localhost** or **http://cems.local**

---

## 🔑 Test Credentials

### Administrator Account
- **Email**: admin@cems.local
- **Password**: password

### Student Account
- **Email**: student@cems.local
- **Password**: password

### Additional Test Accounts
- john.admin@cems.local / password (Admin)
- sarah.manager@cems.local / password (Admin)
- emma.smith@cems.local / password (Student)
- liam.johnson@cems.local / password (Student)

---

## 🎨 Custom Brutalist Theme

The application features a unique **brutalist-inspired design** with:
- Bold 3px borders
- Hard shadows (8px offset)
- Uppercase typography
- Monospace fonts for data
- High contrast colors
- No rounded corners
- Geometric layouts

**Color Palette:**
- Dark: `#1a1a1a`
- Accent Orange: `#ff6b35`
- Accent Yellow: `#f7b731`
- Accent Teal: `#20bf6b`
- Accent Purple: `#8854d0`

---

## 📊 Database Information

**MySQL Container Details:**
- Host: `127.0.0.1`
- Port: `3306`
- Database: `cems`
- Username: `cems_user`
- Password: `secret`

**Connect to MySQL:**
```bash
docker exec -it cems_db mysql -u cems_user -psecret cems
```

---

## 🛠️ Common Commands

```bash
# Stop MySQL
docker-compose down

# Start MySQL
docker-compose up -d

# Clear Laravel cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Fresh migration with seed
php artisan migrate:fresh --seed

# Build frontend assets
npm run build

# Watch for frontend changes
npm run dev
```

---

## 📁 Project Structure

```
CEMS/
├── app/                    # Laravel application code
├── config/                 # Configuration files
├── database/              # Migrations and seeders
├── public/                # Public web directory
├── resources/
│   ├── css/              # Tailwind CSS
│   ├── js/               # JavaScript
│   └── views/            # Blade templates
├── routes/               # Route definitions
├── docker-compose.yml    # MySQL container config
├── .env.example          # Environment template
└── apache-config.conf    # Apache configuration
```

---

## 🐛 Troubleshooting

### MySQL Connection Issues
```bash
# Check if MySQL is running
docker ps

# Check MySQL logs
docker logs cems_db

# Restart MySQL
docker-compose restart db
```

### Permission Errors
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

### Asset Build Errors
```bash
# Clear node modules and reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Apache Issues
```bash
# Check Apache error logs
tail -f /var/log/apache2/error.log

# Test Apache configuration
sudo apachectl configtest
```

---

## 🎯 Features

- ✅ Event browsing and search
- ✅ Event registration system
- ✅ Admin event management
- ✅ User dashboard
- ✅ Role-based access (Admin/Student)
- ✅ Email notifications
- ✅ Audit logging
- ✅ RESTful API with Sanctum authentication
- ✅ Livewire components for dynamic UI
- ✅ Custom brutalist theme design

---

## 📝 Development Workflow

1. **Start MySQL**: `docker-compose up -d`
2. **Run Laravel**: `php artisan serve`
3. **Watch Assets**: `npm run dev` (in another terminal)
4. **Code & Test**: Make changes and refresh browser
5. **Stop MySQL**: `docker-compose down` (when done)

---

## 🔒 Security Notes

- Change default passwords in production
- Update `.env` with secure values
- Never commit `.env` file
- Use HTTPS in production
- Keep dependencies updated

---

## 📚 Additional Resources

- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com
- Livewire: https://livewire.laravel.com
- MySQL: https://dev.mysql.com/doc

---

**Enjoy building with CEMS! 🎉**
