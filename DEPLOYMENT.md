# Production Deployment Guide

## Prerequisites

- Docker and Docker Compose on the host server
- A domain name pointed at the server (for HTTPS)
- Strong passwords for database users (never use defaults in production)

## Environment

Copy and configure production environment variables:

```bash
cp .env.example .env
```

| Variable | Production value |
|----------|------------------|
| `APP_ENV` | `production` |
| `APP_BASE_URL` | `https://yourdomain.com/online-banking` |
| `DB_PASSWORD` | Strong random password |
| `DB_ROOT_PASSWORD` | Strong random password |
| `WEB_PORT` | `80` (nginx front door) |

## Start (production stack)

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
```

This runs:
- **MariaDB** — not exposed to the host (internal only)
- **PHP-Apache** — internal app server
- **Nginx** — public reverse proxy on port 80

## Health check

```
https://yourdomain.com/online-banking/health.php
```

Expected: `{"status":"ok","service":"online-banking","database":"ok"}`

## HTTPS

Terminate TLS at Nginx or a cloud load balancer. Update `APP_BASE_URL` to `https://...` so redirects work correctly.

For Let's Encrypt with Certbot, mount certificates into the nginx container and add an SSL server block.

## Database backups

```bash
docker exec online-banking-db-1 mariadb-dump -ubank_user -p bank_db > backup.sql
```

## Updates

```bash
git pull
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
```

## Security checklist

- [ ] Change all default passwords in `.env`
- [ ] Set `APP_ENV=production`
- [ ] Enable HTTPS
- [ ] Restrict database port (prod compose does this by default)
- [ ] Review uploaded files in `site/dist/assets/uploads/`
- [ ] This is a demo app — not licensed for real banking without compliance review