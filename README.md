# 🐐 Sistem Monitoring Peternakan Pak Tarno

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)
![MariaDB](https://img.shields.io/badge/MariaDB-10.x-003545?style=for-the-badge&logo=mariadb)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript)

**Sistem Monitoring Peternakan Pak Tarno** is a modern, web-based livestock management and monitoring platform. Specifically engineered to support **goat fattening programs (program penggemukan kambing)**, this system digitizes daily farm operations to ensure optimal livestock growth and health. 

This project was developed to fulfill the Final Project requirements for the Web Programming Course, Informatics Engineering Study Program (Class of '25), Universitas Negeri Malang. The system utilizes a decoupled architecture, separating the Back-End RESTful API from the Front-End Responsive UI, providing a seamless solution for manual record-keeping issues, weight monitoring for fattening targets, and irregular medical scheduling.

---

## Core Features

### 1. Fattening & Weight Tracking Logic
* **Weight Trend Analysis:** Interactive Line Chart visualizations to monitor periodic weight development, ensuring the goat fattening targets are met and preventing livestock stunting.
* **Growth Analytics:** Automated calculations of average weight and the latest recorded mass for individual livestock.

### 2. Real-Time Analytics Dashboard
* **Chart.js Visualization:** Interactive charts (Doughnut and Pie Charts) for real-time monitoring of breed distribution and health status.
* **Quick Insights:** Instant metrics overview including total population, sick livestock, and today's medical agenda.

### 3. Digital Livestock Catalog
* **Direct Camera Integration:** Enables field workers to capture livestock photos directly via smartphone cameras, bypassing manual file uploads.
* **Structured Identity Management:** Comprehensive data tracking (ID, breed, gender, health status) via dynamic data tables.

### 4. Medical Log & Vaccination Schedule
* **Immunization Scheduling:** Medical action scheduling with partial update support for status modifications.
* **Health Monitoring:** Proactive tracking to maintain the health quality of the fattened goats.

### 5. Role-Based Access Control (RBAC) & Mobile-First UI
* **Laravel Sanctum Authentication:** API route protection utilizing stateless bearer tokens.
* **Dynamic UI Restriction:** Automatically restricts administrative interfaces for farm worker roles.
* **Bootstrap 5 Optimization:** Fully responsive interface ensuring seamless operation across field devices (smartphones) for Anak Kandang.

---

## Technology Stack

| Category | Technology |
| :--- | :--- |
| **Back-End Framework** | Laravel 10.x (PHP 8.x) |
| **Database Engine** | MariaDB / MySQL |
| **API Authentication** | Laravel Sanctum (Bearer Token) |
| **Front-End Engine** | Laravel Blade Engine & Vanilla JavaScript (Fetch API) |
| **CSS Framework** | Bootstrap 5.3 + Bootstrap Icons |
| **Chart Library** | Chart.js |
| **Asset Bundler** | Vite |
| **Design Tools** | Figma |

---

## System Architecture & Database Design

* **Master Models:** `User.php` (Admin & Worker Accounts) and `Kambing.php` (Livestock Master Data with Soft Deletes implementation).
* **Transaction Models:** `LogBerat.php` (Weight History) and `JadwalMedis.php` (Vaccination History) utilizing `hasMany` (One-to-Many) relationships.
* **API Entry Point:** Managed in `routes/api.php` and fully protected by the `auth:sanctum` middleware.
* **Controller Logic:** Implements strict validation using `$request->validate()` and the `sometimes` parameter for efficient partial data updates (PATCH requests).

---

## Development Team

This project was successfully developed through the collaborative efforts of the Informatics Engineering Team, Universitas Negeri Malang (Class of 2025):

| Developer | Role | Core Responsibilities |
| :--- | :--- | :--- |
| **[Naila Rizki](https://github.com/rootxnaila)** | **Lead Back-End Developer & Database Engineer** | Designed MariaDB relational schemas, wrote migrations & seeders, built API Controller logic, secured routes via Sanctum Middleware, handled comprehensive Request Validation, and coordinated full-stack integration. |
| **[Nova Indriansyah](https://github.com/Pallnova07)** | **Front-End Developer & UI Designer** | Designed high-fidelity prototypes in Figma, implemented responsive layouts using Bootstrap 5, and integrated Chart.js for dynamic analytics visualization. |
| **[Naufal Hilman](https://github.com/zharx07-lgtm)** | **Front-End Developer & UI Interaction** | Built UI interactions, handled DOM manipulation logic via Fetch API, managed authentication state via `localStorage`, and optimized UX for form validation and error handling. |

---

## Installation & Deployment Guide

### 1. Prerequisites
* PHP `>= 8.1`
* Composer
* MySQL/MariaDB Server (e.g., XAMPP / Laragon)
* Node.js & NPM

### 2. Clone Repository
```bash
git clone [https://github.com/rootxnaila/novagoat.git](https://github.com/rootxnaila/novagoat.git)
cd novagoat
```

### 3. Install PHP Dependencies
```bash
composer install
```

### 4. Environment Configuration
Copy the `.env.example` file and rename it to `.env`:
```bash
cp .env.example .env
```
Configure your database credentials in the `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=novagoat_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Database Migration & Seeding
Run the following command to build the tables and seed the initial dummy/admin data:
```bash
php artisan migrate --seed
```

### 7. Compile Frontend Assets
```bash
npm install
npm run dev
```

### 8. Run Local Development Server
Open a new terminal tab and start the Laravel server:
```bash
php artisan serve
```
Access the application in your browser at: **`http://127.0.0.1:8000`**