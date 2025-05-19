# Contact Form with Admin Panel

A PHP-based contact form system with an admin panel for managing submissions. Built using PHP, MySQL, and modern web technologies.

## Features Implemented

### Contact Form
- User-friendly contact form with fields for name, email, and message
- Email format validation
- Input sanitization to prevent security vulnerabilities
- Success/error message display with auto-dismiss functionality
- Responsive design with modern UI elements

![propertyStudiosContactUs](https://github.com/user-attachments/assets/32046d7d-dcd4-475c-9d3a-7517d69304fd)


### Admin Panel
- Secure login system with password hashing
- View all form submissions sorted by most recent
- Protected display of sensitive information
- Clean and intuitive interface

![adminPanel](https://github.com/user-attachments/assets/a446c5ba-fd8b-4397-9026-2a1450c058c4)

### Add Admin
- Secure adding system with password hashing
- Clean and intuitive interface

![addAdmin](https://github.com/user-attachments/assets/804a5b38-a3bb-4a80-ae19-6f5800bd095b)

### Database
- MySQL database with proper table structure
- Auto-incrementing IDs
- Timestamp tracking for submissions
- Secure database connection handling

![administrators_phpmyadmin](https://github.com/user-attachments/assets/ab98a4d5-da55-4838-b0f2-7bc5509e5255)
![contactForm_phpmyadmin](https://github.com/user-attachments/assets/3ba50704-c2aa-482a-bfc2-e0133c536e08)


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
   - Open your web browser and navigate to `http://localhost/phpmyadmin/index.php`
   - Create a new database named `propertyStudios_db`
   - Import the database structure by visiting or running the setup_database.php script first through IDE:
     `http://localhost:3000/setup_database.php`
   - Note: If you're using a different port (e.g., Live Server, or custom Apache port), update the 3000 to your port number.
   

![setupdatabase](https://github.com/user-attachments/assets/bf6057ce-5bff-4bbf-a143-54efdb8c3a21)


4. **Access the Application**
   - Contact Form: `http://localhost:3000/contactUs.php`
   - Admin Panel: `http://localhost:3000/admin/adminPanel.php`
   - Note: If you're using a different port (e.g., Live Server, or custom Apache port), update the 3000 to your port number.

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
