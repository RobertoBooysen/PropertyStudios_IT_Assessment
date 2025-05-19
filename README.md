# Contact Form with Admin Panel

A PHP-based contact form system with an admin panel for managing submissions. Built using PHP, MySQL, and modern web technologies.

## Features Implemented

### Contact Form
- User-friendly contact form with fields for name, email, and message
- Email format validation
- Input sanitization to prevent security vulnerabilities
- Success/error message display with auto-dismiss functionality
- Responsive design with modern UI elements

### Admin Panel
- Secure login system with password hashing
- View all form submissions sorted by most recent
- Protected display of sensitive information
- Clean and intuitive interface

### Database
- MySQL database with proper table structure
- Auto-incrementing IDs
- Timestamp tracking for submissions
- Secure database connection handling

## Prerequisites

- XAMPP (Apache + MySQL + PHP)
- Web browser
- Text editor (VS Code recommended)

## Installation Instructions

1. **Set up XAMPP**
   - Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Start Apache and MySQL services from XAMPP Control Panel

2. **Project Setup**
   - Clone or download this repository

3. **Database Configuration**
   - Open your web browser and navigate to `http://localhost/phpmyadmin`
   - Create a new database named `propertyStudios_db`
   - Import the database structure by visiting or running the setup_database.php script first:
     `http://localhost/PropertyStudios_IT_Assessment/setup_database.php`

4. **Access the Application**
   - Contact Form: `http://localhost/PropertyStudios_IT_Assessment/contactUs.php`
   - Admin Panel: `http://localhost/PropertyStudios_IT_Assessment/login.php`

## Admin Access

Pre-configured admin accounts:
- Email: robertobooysen11@gmail.com
- Password: Roberto11

OR

- Email: nadia@propertystudios.co.uk
- Password: Nadia2025

## Security Features

- Password hashing using PHP's built-in `password_hash()` function
- Prepared statements to prevent SQL injection
- Input sanitization
- Email format validation
- Protected admin routes
