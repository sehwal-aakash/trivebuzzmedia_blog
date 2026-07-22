# Shared Hosting Deployment Guide (cPanel / Apache)

This guide provides step-by-step instructions for deploying **TriveBuzzMedia** on Apache shared hosting environments (such as cPanel, DirectAdmin, Hostinger, Namecheap, Bluehost).

---

## Method 1: Deploying via cPanel Git Version Control or SSH (Recommended)

1. **Upload / Clone Code**:
   - Clone your repository into your hosting root or `public_html` directory.

2. **Configure `.env`**:
   - Copy `.env.example` to `.env` using File Manager.
   - Update database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
   - Set `APP_ENV=production` and `APP_DEBUG=false`.
   - Set `APP_URL=https://yourdomain.com`.

3. **Database Import**:
   - In cPanel, create a MySQL Database & User.
   - Run `php artisan migrate --force` via SSH, OR import your database tables via **phpMyAdmin**.

4. **Storage Symlink on Shared Hosting**:
   - If SSH is available, run:
     ```bash
     php artisan storage:link
     ```
   - If SSH is **not** available, create a file named `symlink.php` in your root directory:
     ```php
     <?php
     $target = __DIR__.'/storage/app/public';
     $shortcut = __DIR__.'/public/storage';
     symlink($target, $shortcut);
     echo "Symlink created successfully";
     ?>
     ```
     Visit `https://yourdomain.com/symlink.php` once in your browser, then delete `symlink.php`.

5. **Optimization**:
   - If SSH is available, run:
     ```bash
     php artisan config:cache
     php artisan route:cache
     php artisan view:cache
     ```

---

## Shared Hosting `.htaccess` Support
The root `.htaccess` file included in this repository automatically rewrites all incoming web requests to the `/public` folder without requiring root DocumentRoot changes.
