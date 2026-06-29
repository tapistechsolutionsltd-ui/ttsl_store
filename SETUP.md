# Nextgen Store — Setup Guide

## Prerequisites
- **Laragon** (recommended) with PHP 8.2+, MySQL 8, Node.js 18+
- Or: XAMPP/WAMP + Node.js separately

---

## 1. Extract the Project

Extract the `nextgen-store.zip` and place the `nextgen-store` folder in:
- **Laragon:** `C:\laragon\www\nextgen-store`
- **XAMPP:** `C:\xampp\htdocs\nextgen-store`

---

## 2. Install PHP Dependencies

Open terminal in the project folder:

```bash
composer install
```

---

## 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Then edit `.env`:

```env
APP_NAME="Nextgen Store"
APP_URL=http://nextgen-store.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nextgen_store
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=yourpassword
MAIL_FROM_ADDRESS=support@nextgenpng.net
MAIL_FROM_NAME="Nextgen Store"
```

---

## 4. Create the Database

In MySQL (via phpMyAdmin, HeidiSQL, or CLI):

```sql
CREATE DATABASE nextgen_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 5. Run Migrations & Seed

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- **Super Admin:** `admin@nextgenpng.net` / `Admin@Nextgen2025`
- 9 product categories
- Sample brands and products

---

## 6. Install Node.js Dependencies & Build Assets

```bash
npm install
npm run dev
```

For production:
```bash
npm run build
```

---

## 7. Create Storage Link

```bash
php artisan storage:link
```

This links `storage/app/public` to `public/storage` for uploaded images.

---

## 8. Set Up Virtual Host (Laragon)

Laragon auto-detects the folder and creates `http://nextgen-store.test`.

If needed, add to your hosts file:
```
127.0.0.1  nextgen-store.test
```

---

## 9. Access the Application

| URL | Description |
|-----|-------------|
| `http://nextgen-store.test` | Customer storefront |
| `http://nextgen-store.test/admin` | Admin panel |

**Admin Login:**
- Email: `admin@nextgenpng.net`
- Password: `Admin@Nextgen2025`

---

## Production Deployment (cPanel)

### File Upload
1. Upload project files to `public_html/store` (or subdomain root)
2. Move the contents of `public/` to `public_html/` (or subdomain root)
3. Update `public_html/index.php` path to point to the laravel root

### .htaccess for Subdomain
Place this in the subdomain root (where index.php is):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Or move all `public/` contents to the subdomain root and update `index.php`:
```php
require __DIR__.'/../nextgen-store/vendor/autoload.php';
$app = require_once __DIR__.'/../nextgen-store/bootstrap/app.php';
```

### Environment
Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`

### Run on server
```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --seed
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

---

## Important Default Settings

| Setting | Value |
|---------|-------|
| Currency | Papua New Guinea Kina (K) |
| Free Shipping Threshold | K500 |
| Standard Shipping Fee | K25 |
| Timezone | Pacific/Port_Moresby |
| Payment Methods | Bank Transfer, Cash on Delivery |
| COD Area | Port Moresby only |

---

## Adding Products (Admin Panel)

1. Login to `/admin`
2. Go to **Products → Add Product**
3. Fill name, price (in Kina), stock, select category
4. Add specifications in `Key: Value` format (one per line)
5. Upload product images (first image = primary)
6. Set Status to **Active** and save

---

## Troubleshooting

**CSS/JS not loading:**
```bash
npm run build
php artisan view:clear
```

**Images not showing:**
```bash
php artisan storage:link
```

**500 Error:**
```bash
php artisan config:clear
php artisan cache:clear
# Check storage/ and bootstrap/cache/ are writable (chmod 775)
```

**"Class not found" errors:**
```bash
composer dump-autoload
```

---

## Key File Locations

| Purpose | Path |
|---------|------|
| Blade views | `resources/views/` |
| CSS styles | `resources/css/app.css` |
| JavaScript | `resources/js/app.js` |
| Routes | `routes/web.php` |
| Controllers | `app/Http/Controllers/` |
| Models | `app/Models/` |
| Migrations | `database/migrations/` |
| Seeder | `database/seeders/DatabaseSeeder.php` |
| Uploaded images | `storage/app/public/` |

---

*Built for NextGen PNG — store.nextgenpng.net*
