# Blog Management System

A simple Core PHP and MySQL blog system with public blog pages and an admin panel.



## Features

- Dynamic blog listing from MySQL
- Blog detail page
- jQuery AJAX search, category filter, and date filter
- Responsive HTML/CSS layout
- Simple admin login
- Admin add, edit, delete blog CRUD
- Blog image upload support
- Unsplash fallback images for blog cards

## Tech Used

- Core PHP
- MySQL
- HTML
- CSS
- jQuery
- AJAX

## Setup

1. Create the database and seed sample data:

```sql
SOURCE database.sql;
```

Or import `database.sql` using phpMyAdmin.

2. Update database credentials in `config/database.php` if your MySQL username/password differs.

3. Run the PHP server from this project folder:

```bash
php -S localhost:8000
```

4. Open:

- User side: `http://localhost:8000/index.php`
- Admin panel: `http://localhost:8000/admin/login.php`


