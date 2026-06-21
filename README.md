<h1 align="center">Online Banking website using PHP</h1>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

Online banking demo with separate **customer** and **admin** portals, backed by MySQL.

## Quick start (Docker)

**Prerequisites:** [Docker Desktop](https://www.docker.com/products/docker-desktop/)

```bash
cp .env.example .env
docker compose up -d --build
```

| Portal | URL |
|--------|-----|
| Customer | http://localhost:8080/online-banking/site/dist/auth_login.php |
| Admin | http://localhost:8080/online-banking/admin/dist/auth-login.php |

**Test credentials** (seed data in `bank_db.sql`):

| Role | Username / ID | Password |
|------|---------------|----------|
| Customer | `customer1` | `Password1` |
| Admin | `1000502004` | `Password1` |

Health check: http://localhost:8081/online-banking/health.php

Stop containers:

```bash
docker compose down
```

Reset database (removes all data):

```bash
docker compose down -v
docker compose up -d --build
```

## Local development

### Backend (PHP + MySQL)

Use Docker as above. PHP source lives in `site/src/php/` and `admin/src/php/` and is copied to `dist/` during the Gulp build.

Configuration is driven by environment variables (see `.env.example`):

- `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME` — database connection
- `APP_BASE_URL` — base URL for redirects (default: `http://localhost:8080/online-banking`)

### Frontend assets (optional)

To rebuild theme assets (SCSS, JS, HTML templates):

```bash
cd site   # or admin
npm install
gulp build   # copies PHP from src/php → dist, rebuilds assets
```

> **Note:** `gulp` runs `clean:dist` before building. PHP files are preserved because they are copied from `src/php/` on every build.

## Project structure

```
online-banking/
├── docker-compose.yml    # PHP-Apache + MariaDB
├── bank_db.sql           # Database schema + seed data
├── includes/config.php   # Shared DB + URL config
├── site/
│   ├── src/php/          # Customer PHP source
│   └── dist/             # Deployed customer app
└── admin/
    ├── src/php/          # Admin PHP source
    └── dist/             # Deployed admin app
```

## Production deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for production Docker setup with nginx, `APP_ENV=production`, and security checklist.

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
```

## Legacy setup (XAMPP)

If you prefer XAMPP instead of Docker:

1. Import `bank_db.sql` into a database named `bank_db`
2. Place the project under `htdocs/online-banking`
3. Set `APP_BASE_URL=http://localhost/online-banking` in your environment or edit `includes/config.php`
4. Open:
   - Customer: http://localhost/online-banking/site/dist/
   - Admin: http://localhost/online-banking/admin/dist/

See [DOCUMENTATION.md](DOCUMENTATION.md) for more detail.

## Authors

- [@rashmin](https://github.com/rashmindungrani) — Idea & initial work