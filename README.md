# Shop ICT Laravel rebuild

Laravel 12 / MySQL replacement for the previous TanStack + Neon application. The rebuild intentionally supports one back-office role: `attendant`.

## Included

- Blade + Tailwind responsive storefront, shop search, product details, and WhatsApp enquiries
- Livewire 3 attendant product and catalogue management with AJAX updates and image uploads
- MySQL migrations for users, categories, products, catalogue, inquiries, orders, and settings
- Existing 85-row product CSV importer and preserved uploaded product/banner media
- DomPDF receipt generation, Lucide icons, web manifest, offline service worker, and Apache rules
- cPanel/PHP 8.2 deployment guide in `DEPLOYMENT.md`

## Local setup

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Configure MySQL and attendant credentials in `.env` before migrating. The seeder deletes any non-attendant users.
