# Staff Portal - Commands to Run

## 🎯 Quick Start Commands (Run in Order)

### 1. Install PHP Dependencies
```bash
composer install
```

### 2. Install Node Dependencies
```bash
npm install
```

### 3. Copy Environment File
```bash
copy .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Create Storage Symlink
```bash
php artisan storage:link
```

### 6. Run Database Migrations
```bash
php artisan migrate
```

### 7. Seed Database (Creates Admin User)
```bash
php artisan db:seed
```

### 8. Build Frontend Assets
```bash
npm run build
```

### 9. Start Development Server
```bash
php artisan serve
```

### 10. Access the Portal
Open browser and go to:
```
http://localhost:8000/admin
```

Login with:
- **Email**: admin@staffportal.com
- **Password**: password

---

## 🔧 Additional Useful Commands

### Clear All Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database (WARNING: Deletes all data)
```bash
php artisan migrate:fresh --seed
```

### Watch Frontend Assets (For Development)
```bash
npm run dev
```

### Run Specific Seeder
```bash
php artisan db:seed --class=AdminUserSeeder
```

### Create New Admin User Manually
```bash
php artisan tinker
```
Then run:
```php
\App\Models\User::create([
    'name' => 'Your Name',
    'email' => 'youremail@example.com',
    'password' => bcrypt('your-password'),
    'role' => 'admin',
    'is_active' => true
]);
```

### Create New Staff User Manually
```bash
php artisan tinker
```
Then run:
```php
$user = \App\Models\User::create([
    'name' => 'Staff Name',
    'email' => 'staff@example.com',
    'password' => bcrypt('password'),
    'role' => 'staff',
    'is_active' => true
]);

$user->staffProfile()->create([
    'employee_id' => 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
    'designation' => 'Developer',
    'employment_status' => 'active',
]);
```

### Check Routes
```bash
php artisan route:list
```

### Optimize for Production
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

---

## 📦 Package Installation (Already in composer.json)

These packages are already included, but if you need to add them manually:

```bash
# Filament (already installed)
composer require filament/filament:"^5.7"

# Laravel Framework (already installed)
composer require laravel/framework:"^12.0"
```

---

## 🎨 Frontend Commands

### Build for Production
```bash
npm run build
```

### Development Mode (Hot Reload)
```bash
npm run dev
```

### Check Node Version
```bash
node --version
npm --version
```

---

## 🗄️ Database Commands

### Check Database Connection
```bash
php artisan db:show
```

### Show Migrations Status
```bash
php artisan migrate:status
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

### Rollback All Migrations
```bash
php artisan migrate:reset
```

---

## 🐛 Debugging Commands

### Check Laravel Version
```bash
php artisan --version
```

### List All Artisan Commands
```bash
php artisan list
```

### Check Environment
```bash
php artisan env
```

### Run Queue Worker (if using queues)
```bash
php artisan queue:work
```

---

## 📁 File Permissions (For Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

## 🚀 Quick Reset & Restart

If something goes wrong, run these commands:

```bash
# Clear everything
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reset database
php artisan migrate:fresh --seed

# Rebuild frontend
npm run build

# Restart server
php artisan serve
```

---

## ✅ Verification Steps

After running setup commands:

1. ✅ Check if server is running: `http://localhost:8000`
2. ✅ Check if admin panel loads: `http://localhost:8000/admin`
3. ✅ Try logging in with: admin@staffportal.com / password
4. ✅ Check if dashboard loads
5. ✅ Try creating a new staff member
6. ✅ Log out and log in as staff to test staff portal

---

## 📝 Notes

- All commands should be run from the project root directory: `d:\xampp\htdocs\staff-portal`
- Make sure PHP, Composer, and Node.js are installed
- SQLite database file will be created at: `database/database.sqlite`
- Uploaded files will be stored in: `storage/app/public/`
- After running `storage:link`, files will be accessible via: `public/storage/`

---

**Need Help?**
- Laravel Docs: https://laravel.com/docs
- Filament Docs: https://filamentphp.com/docs
- Run `php artisan` to see all available commands
