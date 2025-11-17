# 🛒 Marketplace Timedoor

A comprehensive multi-vendor e-commerce marketplace built with Laravel 12, featuring modern UI components, payment integration, and robust vendor management system.

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
<img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
<img src="https://img.shields.io/badge/TailwindCSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
<img src="https://img.shields.io/badge/AlpineJS-3.15-8BC34A?style=for-the-badge&logo=alpine.js&logoColor=white" alt="AlpineJS">
<img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

## 🚀 Features

### 🏪 Multi-Vendor System
- **Vendor Registration & Approval**: Comprehensive vendor onboarding process with admin approval
- **Vendor Dashboard**: Complete vendor management interface with analytics
- **Product Management**: Full CRUD operations for vendor products
- **Order Management**: Vendor-specific order tracking and fulfillment
- **Vendor Analytics**: Sales reports and performance metrics

### 🛍️ E-Commerce Core
- **Product Catalog**: Advanced product browsing with categories and filters
- **Shopping Cart**: Persistent cart with session management
- **Wishlist/Favorites**: Save products for later purchase
- **Product Reviews**: Customer feedback and rating system
- **Search & Filtering**: Powerful product search functionality

### 💳 Payment & Checkout
- **Midtrans Integration**: Secure payment processing with multiple methods
- **Order Tracking**: Complete order lifecycle management
- **Invoice Generation**: Automated invoice creation and email delivery
- **Multiple Payment Methods**: Credit cards, bank transfers, e-wallets

### 🚚 Shipping & Logistics
- **RajaOngkir Integration**: Real-time shipping cost calculation
- **Multiple Shipping Options**: Various courier services integration
- **Address Management**: Customer address book functionality
- **Shipping Tracking**: Order status updates and tracking

### 👥 User Management
- **Multi-Role System**: Admin, Vendor, and Customer roles
- **Google OAuth**: Social login integration
- **Account Management**: Profile settings and preferences
- **Email Notifications**: Automated email communications
- **Account Security**: Password reset and account deletion

### 📊 Admin Panel
- **Dashboard Analytics**: Comprehensive business metrics
- **User Management**: Admin control over all user accounts
- **Order Management**: System-wide order oversight
- **Category Management**: Product category administration
- **System Settings**: Configurable application settings

### 📱 Modern UI/UX
- **Responsive Design**: Mobile-first responsive interface
- **TailwindCSS**: Modern utility-first CSS framework
- **AlpineJS**: Lightweight JavaScript framework
- **Interactive Components**: Dynamic user interface elements
- **Real-time Updates**: Live data updates and notifications

## 🔧 Technology Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: TailwindCSS 4.0, AlpineJS 3.15, Vite
- **Database**: MySQL
- **Payment**: Midtrans Payment Gateway
- **Shipping**: RajaOngkir API
- **Authentication**: Laravel Sanctum, Google OAuth
- **Email**: SMTP (Gmail)
- **Editor**: TinyMCE
- **Testing**: Pest PHP
- **File Export**: Maatwebsite Excel

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL >= 8.0
- NPM or Yarn

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/IdaDanuartha/marketplace-timedoor.git
cd marketplace-timedoor
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Create database (using MySQL CLI or phpMyAdmin)
mysql -u root -p
CREATE DATABASE marketplace_timedoor;

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
# Build frontend assets
npm run build

# For development
npm run dev
```

### 6. Start the Application
```bash
# Start Laravel server
php artisan serve

# For development with hot reload
composer run dev
```

## ⚙️ Environment Configuration

### 📧 Email Configuration (Gmail SMTP)

Configure email settings in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS="noreply@yourapp.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Setup Steps:**
1. Enable 2-factor authentication on your Gmail account
2. Generate an App Password: Google Account > Security > 2-Step Verification > App Passwords
3. Use the generated 16-character password in `MAIL_PASSWORD`

### 🔐 Google OAuth Integration

Configure Google login in your `.env` file:

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback
```

**Setup Steps:**
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API
4. Create OAuth 2.0 credentials:
   - Application type: Web application
   - Authorized redirect URIs: `http://localhost:8000/auth/google/callback`
5. Copy Client ID and Client Secret to your `.env` file

### ✍️ TinyMCE Rich Text Editor

Configure TinyMCE API in your `.env` file:

```env
TINYMCE_API_KEY=your-tinymce-api-key
```

**Setup Steps:**
1. Sign up at [TinyMCE](https://www.tiny.cloud/)
2. Get your API key from the dashboard
3. Add the API key to your `.env` file

### 💳 Midtrans Payment Gateway

Configure Midtrans payment in your `.env` file:

```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
```

**Setup Steps:**
1. Register at [Midtrans](https://midtrans.com/)
2. Get your Sandbox credentials:
   - Go to Settings > Access Keys
   - Copy Server Key and Client Key
3. For production, set `MIDTRANS_IS_PRODUCTION=true` and use production keys

### 🚚 RajaOngkir Shipping API

Configure shipping calculation in your `.env` file:

```env
RAJAONGKIR_API_KEY=your-api-key
RAJAONGKIR_BASE_URL=https://rajaongkir.komerce.id/api/v1
ORIGIN_CITY_ID=201
```

**Setup Steps:**
1. Register at [RajaOngkir](https://rajaongkir.com/)
2. Get your API key from the dashboard
3. Set your origin city ID (default: 201 for Jakarta Selatan)
4. Choose the appropriate plan based on your needs

## 🗂️ Project Structure

```
├── app/
│   ├── Enum/                    # Application enumerations
│   ├── Http/Controllers/        # HTTP controllers
│   │   ├── Auth/               # Authentication controllers
│   │   └── Customer/           # Customer-specific controllers
│   ├── Interfaces/             # Repository interfaces
│   ├── Models/                 # Eloquent models
│   ├── Repositories/           # Repository implementations
│   ├── Services/               # Business logic services
│   └── Utils/                  # Utility functions
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript files
└── routes/                    # Application routes
```

## 🔑 Default Credentials

After running the seeders, you can use these default accounts:

**Admin Account:**
- Email: admin@gmail.com
- Password: admin123

**Vendor Account:**
- Email: (check in your database for get the vendor email)
- Password: password

**Customer Account:**
- Email: (check in your database for get the customer email)
- Password: password

## 🚀 Deployment

### Production Setup

1. **Server Requirements:**
   - PHP 8.2+ with required extensions
   - MySQL 8.0+
   - Nginx or Apache
   - SSL certificate

2. **Environment Configuration:**
   ```bash
   # Set production environment
   APP_ENV=production
   APP_DEBUG=false
   
   # Configure production database
   DB_CONNECTION=mysql
   DB_HOST=your-production-db-host
   DB_DATABASE=your-production-db-name
   DB_USERNAME=your-db-username
   DB_PASSWORD=your-secure-password
   
   # Set production URLs
   APP_URL=https://yourdomain.com
   GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
   ```

3. **Deployment Commands:**
   ```bash
   # Optimize for production
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

   # Or use this shortcode command
   php artisan optimize
   
   # Run migrations
   php artisan migrate --force
   
   # Build assets
   npm run build
   ```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/your-username/marketplace-timedoor/issues) page
2. Create a new issue if your problem isn't already reported
3. Provide detailed information about your environment and the issue

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com) - The web application framework
- [TailwindCSS](https://tailwindcss.com) - Utility-first CSS framework
- [AlpineJS](https://alpinejs.dev) - Lightweight JavaScript framework
- [Midtrans](https://midtrans.com) - Payment gateway solution
- [RajaOngkir](https://rajaongkir.com) - Shipping cost calculation API
