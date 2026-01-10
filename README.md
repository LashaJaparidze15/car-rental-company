# Web Projects

A collection of web development projects built with PHP, MySQL, HTML, CSS, and JavaScript.

## Projects

### PHP Car Rental Company

A complete car rental management system featuring vehicle inventory management, customer bookings, and rental transactions.

**Tech Stack:**
- Backend: PHP with MySQL database
- - Frontend: HTML5, CSS3, JavaScript
  - - Database: MySQL with relational schema
   
    - **Features:**
    - - Vehicle inventory management
      - - Customer registration and management
        - - Booking and reservation system
          - - Payment processing
            - - Rental history and reports
              - - Admin dashboard for management
               
                - **Project Structure:**
                - ```
                  PHP_Car_Rental_Company/
                  ├── index.php
                  ├── config/
                  │   └── database.php
                  ├── pages/
                  │   ├── login.php
                  │   ├── vehicles.php
                  │   ├── bookings.php
                  │   └── admin/
                  ├── includes/
                  │   ├── header.php
                  │   └── footer.php
                  ├── css/
                  │   └── style.css
                  ├── js/
                  │   └── script.js
                  └── database/
                      └── schema.sql
                  ```

                  ## Getting Started

                  ### Prerequisites
                  - PHP 7.4 or higher
                  - - MySQL 5.7 or higher
                    - - Web server (Apache/Nginx)
                      - - Modern web browser
                       
                        - ### Installation
                       
                        - 1. **Clone the repository**
                          2. ```bash
                             git clone https://github.com/LashaJaparidze15/Web_Projects.git
                             cd Web_Projects/PHP_Car_Rental_Company
                             ```

                             2. **Database Setup**
                             3. - Create a new MySQL database
                                - - Import the `database/schema.sql` file
                                  - - Update database credentials in `config/database.php`
                                   
                                    - 3. **Configuration**
                                      4. ```php
                                         // config/database.php
                                         define('DB_HOST', 'localhost');
                                         define('DB_USER', 'root');
                                         define('DB_PASS', 'your_password');
                                         define('DB_NAME', 'car_rental');
                                         ```

                                         4. **Run the Application**
                                         5. - Place the project in your web server root directory
                                            - - Access via: `http://localhost/Web_Projects/PHP_Car_Rental_Company`
                                             
                                              - ## Usage
                                             
                                              - ### Customer Operations
                                              - - Register a new account
                                                - - Browse available vehicles
                                                  - - Check vehicle details and pricing
                                                    - - Make bookings for desired dates
                                                      - - View booking history
                                                        - - Download rental invoices
                                                         
                                                          - ### Admin Operations
                                                          - - Manage vehicle inventory
                                                            - - Add/edit/delete vehicles
                                                              - - View all bookings
                                                                - - Generate reports
                                                                  - - Manage customer accounts
                                                                    - - Process rental confirmations
                                                                     
                                                                      - ## Contributing
                                                                     
                                                                      - 1. Fork the repository
                                                                        2. 2. Create a feature branch (`git checkout -b feature/your-feature`)
                                                                           3. 3. Commit changes (`git commit -m 'Add new feature'`)
                                                                              4. 4. Push to branch (`git push origin feature/your-feature`)
                                                                                 5. 5. Open a Pull Request
                                                                                   
                                                                                    6. ## License
                                                                                   
                                                                                    7. This project is licensed under the MIT License.
                                                                                   
                                                                                    8. ## Author
                                                                                   
                                                                                    9. Created by Lasha Japaridze
