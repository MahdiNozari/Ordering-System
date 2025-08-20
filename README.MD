# 🍔 Ordering System

A **Laravel-based food ordering platform** consisting of two applications:

- **Admin Panel (`admin/`)** – Manage restaurants, menus, orders, and users.  
- **Customer App (`food/`)** – Customers can browse food, place orders, and track status.  

---

## 🚀 Features

- 🔑 Authentication & role-based access (Admin / Customer)  
- 📦 Menu & category management  
- 🛒 Cart and checkout  
- 💳 Order placement & tracking  
- 📊 Admin dashboard with order analytics  
- 🌐 RESTful API endpoints  

---

## 🛠 Requirements

- **PHP** >= 8.1  
- **Composer** >= 2.x  
- **Laravel** 10+  
- **Node.js & NPM**  
- **MySQL / MariaDB**  

---

## ⚙️ Installation

Clone the project and set up both apps:

```bash
git clone https://github.com/yourusername/ordering-system.git
cd "Ordering System"

1️⃣ Setup Admin Panel

cd admin
cp .env.example .env
composer install
php artisan key:generate
npm install && npm run dev
php artisan migrate --seed
php artisan serve --port=8000

Admin available at:
👉 http://localhost:8000
2️⃣ Setup Customer App

cd ../food
cp .env.example .env
composer install
php artisan key:generate
npm install && npm run dev
php artisan migrate --seed
php artisan serve --port=8001

Customer app available at:
👉 http://localhost:8001
🔧 Environment Configuration

Update .env in both admin/ and food/ with your database and mail settings:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ordering
DB_USERNAME=root
DB_PASSWORD=

🧪 Running Tests

php artisan test

📂 Project Structure

Ordering System/
├── admin/   # Admin panel (Laravel app)
├── food/    # Customer app (Laravel app)

📜 License

This project is open-source under the MIT License.
