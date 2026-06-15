# Saksham Bharti — Database Setup & Handover Document

This document provides instructions on how to set up, connect, and verify the database for the Saksham Bharti Foundation website.

---

## 📊 1. Database Specifications
* **Database Engine:** MySQL / MariaDB (standard for XAMPP / WAMP / MAMP)
* **Default Database Name:** `saksham_db`
* **Connection Framework:** PHP Data Objects (PDO) with UTF-8 support.
* **SQL Dump File:** `database.sql` (located in the root directory of the project)

---

## 🗂️ 2. Database Schema (Tables)
The database contains the following tables:

| Table Name | Description |
| :--- | :--- |
| `admins` | Stores admin login credentials (passwords are securely hashed with bcrypt). |
| `activities` | Main table for activities and news. |
| `blogs` | Main table for articles and blogs. |
| `programs` | Core programs list (IT Training, Fashion, Beauty, Soft Skills). |
| `donations` | Stores donor names, emails, amounts, and messages. |
| `volunteers` | Stores volunteer applications, contact details, and interests. |
| `contacts` | Handles general contact form submissions and chatbot lead captures. |
| `site_settings` | Dynamic settings for the site (emails, phone numbers, social media links). |

---

## 🚀 3. Step-by-Step Import Instructions

Follow these steps to set up the database on a local machine (e.g., using XAMPP):

1. **Start MySQL Server:**
   * Open the **XAMPP Control Panel**.
   * Click **Start** next to **Apache** and **MySQL**.

2. **Open phpMyAdmin:**
   * In your browser, navigate to: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

3. **Import the SQL file:**
   * Click the **Import** tab at the top.
   * Click **Choose File** and select **`database.sql`** from the project's root folder (`c:\xampp\htdocs\saksham-bharti\database.sql`).
   * Scroll to the bottom and click **Import** (or **Go**).
   * *Note: The SQL script automatically creates the `saksham_db` database and selects it, so you do not need to create it manually first.*

---

## ⚙️ 4. Connection Configuration (`.env`)
The PHP application reads database credentials from the `.env` file in the project's root directory. Make sure it matches your server:

```ini
# --- Database Configuration ---
DB_HOST=localhost
DB_NAME=saksham_db
DB_USER=root
DB_PASS=
```
*(Leave `DB_PASS` empty if using a default local XAMPP setup).*

---

## 🔑 5. Default Admin Credentials
Once imported, you can access the admin dashboard using:
* **Admin Login URL:** `http://localhost/saksham-bharti/admin.php` (or `/backend/login.php`)
* **Username:** `admin`
* **Password:** `Saksham@Secure#2026`
