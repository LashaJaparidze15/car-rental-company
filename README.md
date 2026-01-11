🚗 Car Management Module – Car Rental System
This module is part of a collaborative car rental web application developed using PHP and MySQL. It focuses on the management of car records, allowing administrators to add, delete, view, and amend car details, as well as generate comprehensive car reports.

🔧 Features
Add Car: Input new car details into the system.

Delete Car: Remove existing car records.

View/Amend Car: Display car information with options to update details.

Car Report: Generate reports listing all cars, with sorting and filtering capabilities.

Shared Components: Includes a common header and landing page for consistent navigation.
Scribd
www.slideshare.net

🗄️ Database Schema
The module utilizes a MySQL database with the following table:

Car:

car_id (INT, Primary Key)

make (VARCHAR)

model (VARCHAR)

year (YEAR)

color (VARCHAR)

rental_price (DECIMAL)

availability_status (BOOLEAN)

Refer to schema.sql for the complete table structure and sample data.

🚀 Installation & Setup
Clone the Repository:

bash
Copy
Edit
git clone https://github.com/yourusername/car-management-module.git
cd car-management-module
Database Setup:

Create a MySQL database named car_rental.

Import the schema.sql file:

bash
Copy
Edit
mysql -u your_username -p car_rental < schema.sql
Configure Database Connection:

Open db.inc.php and update the database credentials:

php
Copy
Edit
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$database = 'car_rental';
Deploy to Web Server:

Place the project folder in your web server's root directory (e.g., htdocs for XAMPP).

Ensure the server is running and navigate to http://localhost/car-management-module/ in your browser.

👤 Author
Lasha Japaridze – lashajapara68@gmail.com
