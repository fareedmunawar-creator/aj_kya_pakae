# Aj Kya Pakae - Deployment Guide

## System Requirements

- PHP 8.0 or higher
- Composer
- MySQL 5.7 or higher
- Node.js and NPM
- Web server (Apache/Nginx)

## Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/aj_kya_pakae.git
   cd aj_kya_pakae
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   npm run dev
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edit the `.env` file to configure your database connection:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aj_kya_pakae
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run database migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```
   
   The application will be available at http://localhost:8000

## Production Deployment

### Server Requirements

- PHP 8.0 or higher
- Composer
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- SSL certificate (recommended)

### Deployment Steps

1. **Prepare the server**
   - Install PHP, MySQL, and web server
   - Configure web server to point to the public directory
   - Set up SSL certificate

2. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/aj_kya_pakae.git
   cd aj_kya_pakae
   ```

3. **Install dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edit the `.env` file for production settings:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   
   DB_CONNECTION=mysql
   DB_HOST=your-db-host
   DB_PORT=3306
   DB_DATABASE=your-db-name
   DB_USERNAME=your-db-user
   DB_PASSWORD=your-db-password
   ```

5. **Run database migrations**
   ```bash
   php artisan migrate --force
   ```

6. **Cache configuration and routes**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **Set proper permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

8. **Configure web server**

   **For Apache (.htaccess is already included in the public directory)**
   
   Example virtual host configuration:
   ```apache
   <VirtualHost *:80>
       ServerName your-domain.com
       ServerAlias www.your-domain.com
       DocumentRoot /path/to/aj_kya_pakae/public
       
       <Directory /path/to/aj_kya_pakae/public>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/error.log
       CustomLog ${APACHE_LOG_DIR}/access.log combined
       
       # Redirect to HTTPS
       RewriteEngine On
       RewriteCond %{HTTPS} off
       RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   </VirtualHost>
   ```

   **For Nginx**
   
   Example configuration:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com www.your-domain.com;
       return 301 https://$host$request_uri;
   }

   server {
       listen 443 ssl;
       server_name your-domain.com www.your-domain.com;
       
       ssl_certificate /path/to/certificate.crt;
       ssl_certificate_key /path/to/private.key;
       
       root /path/to/aj_kya_pakae/public;
       
       index index.php;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

9. **Set up a scheduler (for recurring tasks)**
   
   Add the following Cron entry to run Laravel's scheduler:
   ```bash
   * * * * * cd /path/to/aj_kya_pakae && php artisan schedule:run >> /dev/null 2>&1
   ```

## Maintenance and Updates

### Putting the Application in Maintenance Mode

```bash
php artisan down
```

### Updating the Application

1. Pull the latest changes
   ```bash
   git pull origin main
   ```

2. Install dependencies
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

3. Run migrations
   ```bash
   php artisan migrate --force
   ```

4. Clear and rebuild cache
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. Take the application out of maintenance mode
   ```bash
   php artisan up
   ```

## Troubleshooting

### Common Issues

1. **500 Server Error**
   - Check the Laravel log file at `storage/logs/laravel.log`
   - Ensure proper permissions on storage and bootstrap/cache directories
   - Verify .env configuration

2. **Database Connection Issues**
   - Confirm database credentials in .env
   - Check if MySQL service is running
   - Verify database user has proper permissions

3. **White Screen (No Error)**
   - Enable debugging in .env (APP_DEBUG=true) temporarily
   - Check PHP error logs
   - Verify PHP extensions are installed

### Getting Support

If you encounter issues not covered in this guide, please:

1. Check the Laravel documentation: https://laravel.com/docs
2. Search for similar issues on Stack Overflow
3. Contact the development team at support@ajkyapakae.com