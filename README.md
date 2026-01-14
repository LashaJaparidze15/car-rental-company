# 🚗 Car Rental Company - Car Management System

A comprehensive car rental management system built with PHP and MySQL. This application allows administrators to efficiently manage car inventory, track rental statuses, and generate detailed reports.

## Overview

Car Rental Company is a robust web application designed for car rental businesses. It provides a complete solution for managing vehicle inventory, including adding new vehicles, removing obsolete ones, updating vehicle information, and generating comprehensive management reports.

**Technologies Used:**
- **Backend:** PHP
- - **Database:** MySQL
- - **Frontend:** HTML, CSS, JavaScript
- - **Architecture:** MVC (Model-View-Controller) Pattern
     
- ## Features
     
- ### Core Functionality
- - Add Car** - Add new vehicles to the system with complete details (make, model, year, color, rental price, availability status)
- - Delete Car** - Remove vehicles from inventory with a single action
- - View/Edit Cars** - Display vehicle information and update details as needed
- - Car Reports** - Generate comprehensive reports with filtering and sorting capabilities
             
- ### Additional Features
- - **Shared Components** - Consistent navigation with header and landing page
- - **User-Friendly Interface** - Intuitive design for easy navigation
- - **Database Integrity** - Built-in validation and error handling
                   
- ## Database Schema
                   
- ### Car Table
- | Column | Type | Description |
- |--------|------|-------------|
- | car_id | INT (Primary Key) | Unique identifier for each vehicle |
- | make | VARCHAR | Vehicle manufacturer (e.g., Toyota, BMW) |
- | model | VARCHAR | Vehicle model name |
- | year | YEAR | Year of manufacture |
- | color | VARCHAR | Vehicle color |
- | rental_price | DECIMAL | Daily rental price |
- | availability_status | BOOLEAN | Availability status (1 = available, 0 = rented) |
                   
- For the complete schema, refer to `schema.sql`.
                   
- ## Installation & Setup
                   
- ### Prerequisites
- - PHP 7.4 or higher
- - MySQL 5.7 or higher
- - Web Server (Apache recommended)
- - XAMPP or similar (for local development)
                           
- ### Step-by-Step Setup
                           
- #### 1. Clone the Repository
- ```bash
git clone https://github.com/LashaJaparidze15/car-rental-company.git
cd car-rental-company
```

#### 2. Create the Database
```bash
mysql -u your_username -p
CREATE DATABASE car_rental;
EXIT;
```

#### 3. Import the Database Schema
```bash
mysql -u your_username -p car_rental < schema.sql
```

#### 4. Configure Database Connection
Edit `db.inc.php` and update the following:
```php
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$database = 'car_rental';
```

#### 5. Deploy to Web Server
- Copy the project folder to your web server's root directory (e.g., `htdocs` for XAMPP)
- - Ensure the web server is running
- - Navigate to `http://localhost/car-rental-company/` in your browser
                                 
- ## 📁 File Structure
                                 
- ```
car-rental-company/
├── index.php              # Main landing page
├── header.php             # Shared navigation header
├── addCar.php             # Add vehicle form
├── addCarDB.php           # Database insert logic for new vehicles
├── viewCar.php            # Display all vehicles
├── viewCarDB.php          # Fetch vehicle data from database
├── deleteCar.php          # Delete vehicle confirmation
├── deleteCarDB.php        # Database delete logic
├── carReport.php          # Generate vehicle reports
├── db.inc.php             # Database connection configuration
├── schema.sql             # Database schema
├── .gitignore             # Git ignore rules
├── README.md              # This file
└── css/                   # Stylesheets (if applicable)
```

## Usage Guide

### 1. Access the Application
Open your browser and navigate to `http://localhost/car-rental-company/`

### 2. Add a New Vehicle
- Click "Add Car" from the main menu
- - Enter vehicle details (make, model, year, color, rental price)
- - Set availability status
- - Click "Add" to save to the database
                                         
- ### 3. View All Vehicles
- - Click "View Cars" to see the complete vehicle inventory
- - View detailed information for each vehicle
                                             
- ### 4. Update Vehicle Information
- - From the vehicle list, click "Edit" next to the vehicle you want to update
- - Modify the desired fields
- - Click "Update" to save changes
                                                   
- ### 5. Delete a Vehicle
- - Click "Delete" next to the vehicle you want to remove
- - Confirm the deletion
- - The vehicle will be permanently removed from the database
                                                         
- ### 6. Generate Reports
- - Click "Car Report" from the main menu
- - Filter vehicles by status or other criteria
- - Sort by make, model, year, or price
- - Export or print the report
                                                                 
- ## 🔧 Troubleshooting
                                                                 
- ### Common Issues
                                                                 
- #### 1. "Connection refused" Error
- **Problem:** Cannot connect to MySQL database
- **Solution:**
- - Ensure MySQL server is running
- - Verify database credentials in `db.inc.php`
- - Check that the database `car_rental` exists
                                                                       
- #### 2. "Database does not exist" Error
- **Problem:** Schema not imported
- **Solution:**
- - Re-run the schema import command: `mysql -u your_username -p car_rental < schema.sql`
                                                                         
- #### 3. "Permission Denied" Error
- **Problem:** Server directory permissions issue
- **Solution:**
- - Change file permissions: `chmod 755 car-rental-company/`
- - Ensure your web server user has write permissions
                                                                             
- #### 4. CSS or Images Not Loading
- **Problem:** Static files returning 404
- **Solution:**
- - Verify file paths are relative to project root
- - Check that all static files are in the correct directories
                                                                                 
- ## Security Considerations
                                                                                 
- - **Database Credentials:** Never commit `db.inc.php` to version control (already in `.gitignore`)
- - **Input Validation:** Always validate user inputs to prevent SQL injection
- - **SQL Prepared Statements:** Use prepared statements for all database queries
- - **Authentication:** Consider adding user authentication and role-based access control for production
                                                                                         
- ## Database Backup
                                                                                         
- To backup your database:
- ```bash
mysqldump -u your_username -p car_rental > car_rental_backup.sql
```

To restore from backup:
```bash
mysql -u your_username -p car_rental < car_rental_backup.sql
```

## 🤝 Contributing

Contributions are welcome! To contribute:
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/improvement`)
3. Commit your changes (`git commit -m 'Add improvement'`)
4. Push to the branch (`git push origin feature/improvement`)
5. Open a Pull Request
                                                                                                       
## Author                                                                                                    
                                                                                                        **Lasha Japaridze**
                                                                                                        - Email: lashajaparidze@gmail.com
- - GitHub: [@LashaJaparidze15](https://github.com/LashaJaparidze15)
- - Location: Carlow, Ireland
                                                                                                              
- ## License                                                                                                 
- This project is provided as-is for educational and personal use.
                                                                                                              
- ## Acknowledgments
 
- - SETU Carlow for educational support
- - MySQL and PHP communities for excellent documentation
                                                                                                                  
- ---
                                                                                                                   
**Last Updated:** January 2026
**Version:** 1.0
