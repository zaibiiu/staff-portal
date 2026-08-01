# Staff Management Portal - Setup Guide

## 📋 Overview
A complete, professional, production-ready Staff Management Portal built with Laravel 12 and Filament 5.7.

## ✨ Features

### Admin Features
- **Staff Management**: Create, edit, view, and manage staff accounts
- **Department Management**: Organize staff into departments
- **Salary Management**: Track salary history and current salaries
- **Document Management**: Upload and manage employee documents (CNIC, contracts, certificates)
- **Project Management**: Create projects, assign team members, track progress
- **Task Management**: Assign tasks to staff, set priorities, track completion
- **Commission Management**: Manually add and track staff commissions
- **Attendance Management**: Record and monitor staff attendance
- **Dashboard**: Beautiful overview with stats and recent activities

### Staff Features
- **Personal Dashboard**: Overview of projects, tasks, and statistics
- **Profile Management**: Update personal information
- **View Documents**: Access uploaded documents
- **View Salary**: Check current salary and history
- **View Commissions**: Track earned commissions
- **View Attendance**: Monitor attendance records
- **My Projects**: View assigned projects
- **My Tasks**: View and update task status

## 🚀 Installation Steps

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
# Copy the environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Create Storage Link
```bash
php artisan storage:link
```

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Seed Database (Creates Admin & Sample Data)
```bash
php artisan db:seed
```

### 6. Build Frontend Assets
```bash
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

## 🔐 Default Login Credentials

### Admin Account
- **Email**: admin@staffportal.com
- **Password**: password

### Staff Accounts (Sample)
- **Email**: john@staffportal.com | **Password**: password
- **Email**: jane@staffportal.com | **Password**: password

## 📁 Project Structure

```
app/
├── Filament/
│   ├── Pages/           # Custom dashboard and staff portal pages
│   │   ├── Dashboard.php
│   │   ├── MyProfile.php
│   │   ├── MyDocuments.php
│   │   ├── MySalary.php
│   │   ├── MyCommissions.php
│   │   ├── MyAttendance.php
│   │   ├── MyProjects.php
│   │   └── MyTasks.php
│   ├── Resources/       # Admin resources for CRUD operations
│   │   ├── UserResource.php
│   │   ├── DepartmentResource.php
│   │   ├── ProjectResource.php
│   │   └── TaskResource.php
│   └── Widgets/         # Dashboard widgets
│       ├── StatsOverview.php
│       ├── RecentTasksWidget.php
│       ├── StaffStatsWidget.php
│       └── StaffTasksWidget.php
├── Models/              # Eloquent models
│   ├── User.php
│   ├── StaffProfile.php
│   ├── Department.php
│   ├── Salary.php
│   ├── Document.php
│   ├── Project.php
│   ├── Task.php
│   ├── Commission.php
│   └── Attendance.php
└── Policies/            # Authorization policies
    ├── UserPolicy.php
    ├── DepartmentPolicy.php
    ├── ProjectPolicy.php
    └── TaskPolicy.php

database/
├── migrations/          # Database migrations
└── seeders/            # Database seeders
    ├── DatabaseSeeder.php
    └── AdminUserSeeder.php
```

## 🗄️ Database Schema

### Users Table
- Basic user authentication (email, password, role, is_active)

### Staff Profiles Table
- employee_id, phone, address, designation, department_id
- joining_date, date_of_birth, cnic, emergency contacts
- profile_photo, employment_status, notes

### Departments Table
- name, description, is_active

### Salaries Table
- user_id, amount, effective_date, end_date
- is_current (marks current salary), remarks

### Documents Table
- user_id, title, document_type, file_path
- file_name, file_size, description

### Projects Table
- name, description, start_date, deadline
- stage (pending, planning, in_progress, review, completed)
- status (active, on_hold, completed, cancelled)
- Many-to-many relationship with users

### Tasks Table
- project_id, user_id, title, description
- priority (low, medium, high, urgent)
- due_date, status (pending, in_progress, completed)

### Commissions Table
- user_id, amount, commission_date
- commission_month, description

### Attendances Table
- user_id, date, status (present, absent, leave, late)
- check_in, check_out, remarks

## 🎨 UI/UX Features

- Modern, responsive design
- Clean professional layout
- Role-based navigation (Admin sees admin features, Staff sees staff features)
- Dashboard widgets with statistics
- Inline actions for quick operations
- Searchable and filterable tables
- Sortable columns
- Badge colors for different statuses
- File upload with image editor
- Date pickers and time pickers
- Rich form components

## 🔒 Security & Authorization

- Role-based access control (Admin/Staff)
- Policy-based authorization
- Staff cannot access admin resources
- Staff can only view/update their own information
- Admins have full control over all resources
- Password hashing with bcrypt
- CSRF protection
- SQL injection protection via Eloquent ORM

## 📊 Key Relationships

- **User** → hasOne StaffProfile
- **User** → hasMany Salaries
- **User** → hasOne CurrentSalary (current salary)
- **User** → hasMany Documents
- **User** → belongsToMany Projects
- **User** → hasMany Tasks
- **User** → hasMany Commissions
- **User** → hasMany Attendances
- **Department** → hasMany StaffProfiles
- **Project** → belongsToMany Users
- **Project** → hasMany Tasks
- **Task** → belongsTo Project
- **Task** → belongsTo User

## 🛠️ Customization

### Adding New Fields
1. Create migration: `php artisan make:migration add_field_to_table`
2. Update model's `$fillable` array
3. Update Filament resource form schema
4. Update Filament resource table columns

### Adding New Resources
```bash
php artisan make:filament-resource ResourceName --generate
```

### Custom Theme Colors
Edit `app/Providers/Filament/AdminPanelProvider.php`:
```php
->colors([
    'primary' => Color::Blue,
])
```

## 📝 Usage Guide

### Admin Workflow
1. Login with admin credentials
2. Navigate to "Staff Management" to create staff accounts
3. View staff details and add:
   - Staff profile information
   - Salary records
   - Documents
   - Tasks
   - Commissions
   - Attendance
4. Create departments and assign staff
5. Create projects and assign team members
6. Create tasks and assign to staff
7. Monitor progress via dashboard

### Staff Workflow
1. Login with staff credentials
2. View personalized dashboard
3. Update profile in "My Profile"
4. View documents in "My Documents"
5. Check salary in "My Salary"
6. View commissions in "My Commissions"
7. Monitor attendance in "My Attendance"
8. View projects in "My Projects"
9. View and update task status in "My Tasks"

## 🚀 Production Deployment

1. Set `APP_ENV=production` in .env
2. Set `APP_DEBUG=false` in .env
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Set proper file permissions
7. Configure web server (Apache/Nginx)
8. Set up SSL certificate
9. Configure backup strategy
10. Set up monitoring

## 📧 Support & Documentation

- Laravel: https://laravel.com/docs
- Filament: https://filamentphp.com/docs
- Filament Panels: https://filamentphp.com/docs/panels

## ⚠️ Important Notes

1. **Change Default Passwords**: Immediately change default passwords in production
2. **File Storage**: Ensure `storage/app/public` is linked
3. **Permissions**: Staff cannot register themselves - only Admin can create accounts
4. **Salary Management**: Salary records maintain history - mark one as "current"
5. **Document Types**: CNIC, Contract, Certificate, Degree, Experience Letter, Other
6. **Task Status**: Staff can update their own task status
7. **Commission**: Manually added by Admin (no automatic calculation)
8. **Attendance**: Flexible structure - can add check-in/check-out later

## 🎯 Future Enhancements (Optional)

- Email notifications
- Automated commission calculation
- Advanced reporting and analytics
- Leave management system
- Performance review module
- Payroll integration
- Biometric attendance integration
- Mobile app
- Real-time notifications
- Export functionality (PDF/Excel)

---

**Built with ❤️ using Laravel & Filament**
