# 💬 Takaidoo Shoutbox

A WhatsApp-style real-time shoutbox built with **Laravel 10**.

---

## 🚀 Setup Instructions

### Part 1 — Project Creation & Database

```bash
# 1. Create the Laravel project
composer create-project laravel/laravel takaidoo-shoutbox
cd takaidoo-shoutbox

# 2. Create the MySQL database
mysql -u root -p -e "CREATE DATABASE takaidoo_shoutbox CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. Copy the environment file
cp .env.example .env

# 4. Generate the application key
php artisan key:generate
```

### Configure `.env`

Open `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=takaidoo_shoutbox
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### Part 1 — Copy Project Files

Copy the files from this repo into your Laravel project, replacing the defaults:

| Source file | Destination |
|---|---|
| `database/migrations/..._create_shouts_table.php` | `database/migrations/` |
| `app/Models/Shout.php` | `app/Models/` |
| `app/Http/Controllers/ShoutController.php` | `app/Http/Controllers/` |
| `routes/web.php` | `routes/web.php` |
| `resources/views/shoutbox.blade.php` | `resources/views/` |

### Run the Migration

```bash
php artisan migrate
```

### Start the Development Server

```bash
php artisan serve
# Visit http://localhost:8000
```

---

## 📂 File Structure

```
takaidoo-shoutbox/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ShoutController.php   ← CRUD logic
│   └── Models/
│       └── Shout.php                 ← Eloquent model
├── database/
│   └── migrations/
│       └── ..._create_shouts_table.php
├── resources/
│   └── views/
│       └── shoutbox.blade.php        ← WhatsApp-style UI
├── routes/
│   └── web.php                       ← 3 routes (index, store, destroy)
├── .env.example
├── .gitignore                        ← vendor/ and .env excluded ✅
└── README.md
```

---

## ✨ Features

| Feature | Details |
|---|---|
| **Post a shout** | Username + message form at the bottom |
| **Read messages** | Latest messages shown first |
| **Delete a shout** | 🗑 button on every bubble |
| **Validation** | Message required, max 255 chars |
| **WhatsApp UI** | Green bubbles (right) / grey bubbles (left) |
| **Character counter** | Live countdown in the input |
| **Keyboard shortcut** | Ctrl/Cmd + Enter to send |

---

## 🗄️ Database Schema

```sql
CREATE TABLE shouts (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(255) NOT NULL,
    message    TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 📲 Part 3 — Git & GitHub

```bash
# Inside your project folder:
git init
git add .
git commit -m "feat: initial Takaidoo Shoutbox implementation"

# Create a private repo on GitHub, then:
git remote add origin https://github.com/YOUR_USERNAME/takaidoo-shoutbox.git
git branch -M main
git push -u origin main
```

> ⚠️ **Security check**: confirm `.env` and `vendor/` are in `.gitignore` before pushing!

Then go to **Settings → Collaborators** on GitHub and invite **webanticofusion-dev**.

---

## 💬 WhatsApp Message Template

```
Task Completed: Takaidoo Shoutbox ✅
Repo Link: https://github.com/YOUR_USERNAME/takaidoo-shoutbox
Hardest Part: [One sentence on what challenged you most]
[Attach screenshot of the UI]
```
