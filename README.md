# Maithreya Agencies

An e-commerce website for Maithreya Agencies, a shop that sells engine oils and tyres. Customers can browse products, create an account, check what's in stock and contact the store, and admins get their own login to manage things.

I built this with Nelson and Mohanram as our BSc final-year project at St Joseph's University in 2023. The full project report is in `Major project documentation final.pdf`.

## Tech stack

- PHP 8 with MySQL/MariaDB (runs on XAMPP)
- HTML, CSS and JavaScript (jQuery and bxSlider for the landing page slider)

## Features

- Landing page with featured tyres (MRF, CEAT, Apollo, JK) and engine oils (Servo, Shell, Mobil, Castrol)
- Registration and login, with separate pages for customers and admins
- Products, categories, cart, orders and customer contact queries stored in MySQL

## Security

I went back to this project in 2026 and fixed the weak spots in the original code:

- Passwords are hashed with `password_hash()` and checked with `password_verify()` (the first version used plain MD5)
- Every query that uses user input is a prepared statement, so it can't be used for SQL injection
- Registration always creates a normal user. Earlier, anyone could send `user_type=admin` in the form and make themselves an admin
- Protected pages stop with `exit` after redirecting logged-out visitors
- Names are escaped with `htmlspecialchars()` before they're shown on a page
- Email is unique in the database, so one email can't be registered twice
- The session id changes after login

## Running it locally

1. Install [XAMPP](https://www.apachefriends.org/) and start Apache and MySQL.
2. Copy this folder into `C:\xampp\htdocs\` (or `/Applications/XAMPP/htdocs/` on a Mac).
3. Open phpMyAdmin at http://localhost/phpmyadmin, create a database called `maithreyaagencies` and import `maithreyaagencies.sql` into it.
4. Go to http://localhost/MaithreyaAgencies/landing.php

`config.php` uses the XAMPP defaults (user `root`, no password, database `maithreyaagencies`). If your setup is different, set the `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASS` and `DB_NAME` environment variables.

### Demo accounts

The SQL file only has demo data, no real customer details.

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | Admin@123 |
| User | user@example.com | User@123 |

You can also make a new customer account from the register page. Admin accounts can only be added directly in the database.

## Project structure

```
landing.php         public landing page
login_form.php      login for customers and admins
register_form.php   customer registration
user_page.php       customer welcome page
admin_page.php      admin welcome page
logout.php          ends the session
config.php          database connection and a small HTML-escaping helper
css/style.css       styles for the login, register and welcome pages
maithreyaagencies.sql   database schema with demo data
```

## Credits

The landing page layout is based on a template by Kamran Mubarik.
