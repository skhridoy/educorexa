# 🌐 EduCorexa Custom Domain Setup & Server Configuration Guide

This guide explains how custom domain mapping works in **EduCorexa** and provides step-by-step instructions for hosting environments (cPanel, Nginx, Apache, Cloudflare, and local XAMPP testing).

---

## 📌 Architecture Overview

1. **Subdomains**: `school-slug.educorexa.com` (Resolved automatically via wildcard or subdomain routing).
2. **Custom Domains**: e.g., `myschool.edu.bd` or `portal.school.com`:
   - School Admin submits their domain in **School Settings ➔ Custom Domain**.
   - Super Admin reviews and verifies the domain in **Super Admin ➔ Custom Domains**.
   - The system dynamically manages session cookies, URLs, and tenant resolution so that:
     - Session cookies are scoped properly (no CSRF or logout issues).
     - Route URLs seamlessly stay on the custom domain.
     - Both `school.com` and `www.school.com` are supported.
     - Live DNS testing checks whether DNS has propagated to the server IP.

---

## 1️⃣ DNS Records Setup (For School / Domain Registrar)

The school administrator or IT staff must configure their domain's DNS manager (Namecheap, GoDaddy, Cloudflare, etc.):

| Type | Name / Host | Value / Points to | TTL | Purpose |
| :--- | :--- | :--- | :--- | :--- |
| **A** | `@` (or blank) | `YOUR_SERVER_IP` (e.g. `103.x.x.x`) | Automatic / 300s | Points apex domain to server |
| **CNAME** | `www` | `educorexa.com` (or `@`) | Automatic / 300s | Points www to the server |

> ℹ️ **Note on Subdomains as Custom Domain**:  
> If the school is using a subdomain of their own existing domain (e.g., `portal.mycollege.edu.bd`), they can add:  
> `CNAME` | `portal` | `educorexa.com` (or `A` record pointing to `YOUR_SERVER_IP`).

---

## 2️⃣ Server Configuration

### A. cPanel / Shared Hosting / WHM Setup
If running on cPanel:
1. Open cPanel ➔ **Domains** (or **Aliases** / **Parked Domains**).
2. Click **Create A New Domain**.
3. Enter the custom domain: `myschool.edu.bd`.
4. **IMPORTANT**: Uncheck *"Share document root"*.
5. Set the **Document Root** to the **SAME folder where the main Laravel app's public directory is located** (usually `public_html/educorexa/public` or `public_html`).
6. Click **Submit**.
7. SSL: Go to **cPanel ➔ SSL/TLS Status** and click **Run AutoSSL** on the new domain.

---

### B. Nginx Configuration (VPS / Cloud Server)
In Nginx, configure your server block to accept any custom domain or include them in `server_name`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name educorexa.com *.educorexa.com ~^(?<subdomain>.+)$;

    # Or listen as default_server:
    # server_name _;

    root /var/www/educorexa/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

### C. Apache VirtualHost Configuration
In Apache `httpd.conf` or `000-default.conf`:

```apache
<VirtualHost *:80>
    ServerName educorexa.com
    ServerAlias *.educorexa.com *
    DocumentRoot "C:/xampp/htdocs/laravel/educorexa/public"

    <Directory "C:/xampp/htdocs/laravel/educorexa/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

---

### D. Cloudflare Setup (Recommended for Free Automated SSL)
1. Add the domain to Cloudflare.
2. In Cloudflare DNS, add:
   - `A` record `@` ➔ `YOUR_SERVER_IP` (Proxy status: Proxied or DNS Only).
   - `CNAME` `www` ➔ `@` (Proxy status: Proxied or DNS Only).
3. In **SSL/TLS ➔ Overview**, set encryption mode to **Full** or **Full (Strict)**.

---

## 3️⃣ Local Testing Setup (Windows XAMPP)

To test custom domains locally on your machine without buying a real domain:

### Step 1: Add to Windows `hosts` file
Open Notepad as **Administrator**, open `C:\Windows\System32\drivers\etc\hosts`, and add:
```hosts
127.0.0.1  schoolerp.test
127.0.0.1  school1.schoolerp.test
127.0.0.1  ideal-school.com
127.0.0.1  www.ideal-school.com
```

### Step 2: Add Apache VirtualHost in XAMPP
Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    ServerName schoolerp.test
    ServerAlias *.schoolerp.test ideal-school.com www.ideal-school.com
    DocumentRoot "C:/xampp/htdocs/laravel/educorexa/public"
    <Directory "C:/xampp/htdocs/laravel/educorexa/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Restart Apache in XAMPP.

### Step 3: Approve in Application
1. Log in to School Admin: Go to **School Settings ➔ Custom Domain**.
2. Enter `ideal-school.com` and submit request.
3. Log in as Super Admin: Go to **Super Admin ➔ Custom Domains**.
4. Click **Check DNS** to test live records, then click **Approve**.
5. Visit `http://ideal-school.com` in your browser! The entire school website, login, and portal will load under `http://ideal-school.com`.

---

## 4️⃣ Environment Variables (`.env`)

Ensure these values are configured in `.env`:

```env
MAIN_DOMAIN=educorexa.com
SERVER_IP=103.xxx.xxx.xxx
SESSION_DOMAIN=.educorexa.com
```

- When visiting on the main domain or `*.educorexa.com`, `SESSION_DOMAIN` is `.educorexa.com`.
- When visiting on a custom domain (e.g. `ideal-school.com`), the app dynamically scopes the session cookie to `null` so the browser preserves login session on the custom domain.
