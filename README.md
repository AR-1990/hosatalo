# Hostal Booking System

A complete Laravel-based hostel booking system with Bootstrap UI, featuring user authentication, room management, and booking functionality.

## Features

### 🔐 Authentication System
- **3 User Roles**: Admin, Client, and Regular User
- **Secure Login/Register**: Bootstrap-based forms with validation
- **Role-based Access Control**: Different dashboards for each user type

### 🏠 Room Management
- **Room CRUD Operations**: Add, edit, delete, and view rooms
- **Image Upload**: Room images stored in public/uploads/rooms
- **Room Details**: Name, description, price, capacity, type, amenities
- **Availability Status**: Mark rooms as available/unavailable

### 📅 Booking System
- **Room Booking**: Users can book available rooms
- **Date Selection**: Check-in and check-out date picker
- **Booking Status**: Pending, confirmed, cancelled, completed
- **Automatic Calculation**: Nights and total amount calculation

### 👥 User Roles

#### **Admin User**
- Full system access
- View all users, rooms, and bookings
- Manage system statistics
- Approve/reject bookings

#### **Client User**
- Add and manage their own rooms
- View bookings for their rooms
- Update room availability

#### **Regular User**
- Browse available rooms
- Make room bookings
- View booking history
- Cancel confirmed bookings

## Installation

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Hostalo
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` file with your database credentials
   - Create a new database

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database**
   ```bash
   php artisan db:seed
   ```

7. **Create uploads directory**
   ```bash
   mkdir public/uploads
   mkdir public/uploads/rooms
   ```

8. **Set permissions** (if on Linux/Mac)
   ```bash
   chmod -R 755 public/uploads
   ```

## Default Accounts

After running the seeder, you'll have these default accounts:

- **Admin**: admin@hostal.com / admin123
- **Client**: client@hostal.com / client123  
- **User**: user@hostal.com / user123

## File Structure

```
Hostalo/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      # Authentication logic
│   │   ├── RoomController.php      # Room management
│   │   ├── BookingController.php   # Booking operations
│   │   └── AdminController.php     # Admin panel
│   ├── Models/
│   │   ├── User.php               # User model with roles
│   │   ├── Room.php               # Room model
│   │   └── Booking.php            # Booking model
│   └── Providers/
├── database/
│   ├── migrations/                 # Database structure
│   └── seeders/                    # Sample data
├── resources/
│   └── views/
│       ├── auth/                   # Login/Register forms
│       ├── user/                   # User dashboard
│       ├── client/                 # Client dashboard
│       └── admin/                  # Admin dashboard
├── public/
│   └── uploads/                    # File uploads
└── routes/
    └── web.php                     # Application routes
```

## Database Schema

### Users Table
- `id`, `name`, `email`, `password`
- `role` (user/client/admin)
- `phone`, `address`
- `email_verified_at`, `remember_token`
- `created_at`, `updated_at`

### Rooms Table
- `id`, `user_id` (client who owns the room)
- `name`, `description`, `price_per_night`
- `capacity`, `room_type`, `image`
- `is_available`, `amenities` (JSON)
- `created_at`, `updated_at`

### Bookings Table
- `id`, `user_id`, `room_id`
- `check_in_date`, `check_out_date`
- `number_of_nights`, `total_amount`
- `status`, `special_requests`
- `created_at`, `updated_at`

## Usage

### For Shared Hosting
This system is designed to work on shared hosting without terminal access:

- **File Uploads**: All files are stored in `public/uploads/` directory
- **No Storage Usage**: Uses direct file operations instead of Laravel Storage
- **Simple Deployment**: Just upload files and run migrations via phpMyAdmin

### Key Routes

- **Authentication**: `/login`, `/register`, `/logout`
- **User Dashboard**: `/user/dashboard`
- **Client Dashboard**: `/client/dashboard`
- **Admin Dashboard**: `/admin/dashboard`
- **Rooms**: `/rooms` (CRUD operations)
- **Bookings**: `/bookings` (CRUD operations)

## Customization

### Adding New Features
1. Create new migration: `php artisan make:migration create_new_table`
2. Add model: `php artisan make:model NewModel`
3. Create controller: `php artisan make:controller NewController`
4. Add routes in `routes/web.php`
5. Create views in `resources/views/`

### Styling
- Uses Bootstrap 5 for responsive design
- Font Awesome icons for better UX
- Custom CSS can be added to `public/css/custom.css`

## Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Server-side validation for all inputs
- **Role-based Access**: Middleware protection for routes
- **SQL Injection Protection**: Eloquent ORM with prepared statements
- **XSS Protection**: Blade templating with automatic escaping

## Support

For support or questions:
- Check the code comments for implementation details
- Review the migration files for database structure
- Test with the provided sample accounts

## License

This project is open-source and available under the MIT License.
