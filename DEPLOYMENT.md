# HostPinnacle cPanel deployment

Requirements: PHP 8.2+, MySQL 8/MariaDB, Apache `mod_rewrite`, Composer 2, and Node only during builds.

1. Create a MySQL database and user in cPanel, then grant the user all privileges.
2. Upload this application outside `public_html` (for example `~/shopict`). Point the domain document root to `~/shopict/public`. If HostPinnacle does not allow changing the document root, copy only `public/` into `public_html` and update the two paths in `public/index.php`.
3. Copy `.env.example` to `.env`. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://your-domain`, the MySQL values, and the attendant credentials. Never upload the development `.env`.
4. Run:

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   php artisan optimize
   ```

5. Upload the already-built `public/build` directory, or run `npm ci && npm run build` before upload.
6. Enable AutoSSL and force HTTPS in cPanel. The included `.htaccess` sets HSTS for HTTPS responses.
7. Ensure `storage/` and `bootstrap/cache/` are writable (normally `775`).

The seeder imports `database/data/products.csv`, creates the attendant account, removes every non-attendant account, and populates both the public products and attendant catalogue tables. Existing media is retained under `public/uploads`.
