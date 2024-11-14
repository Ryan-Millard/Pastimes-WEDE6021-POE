# Pastimes Project Setup Instructions

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Configuration Steps](#configuration-steps)
- [Setting Up the Database](#setting-up-the-database)
- [Troubleshooting](#troubleshooting)
- [Running the Application](#running-the-application)
- [File Structure](#file-structure)
- [Functionality](#functionality)
- [Additional Information](#additional-information)
- [Contributors](#contributors)
- [Conclusion](#conclusion)

## Introduction
This document outlines the necessary configurations for your XAMPP server to properly serve the Pastimes project.

## Project Overview
Pastimes is a second-hand e-clothing store built using PHP. It allows users to browse, buy, and sell clothing items, while managing their transactions and wishlists. The project follows an MVC architecture and includes features such as user authentication, product listings, and transaction management.

## Key Features
- User Login: Allows users of all types to log in and view items in the clothing store.
- Admin privileges: Allows administrators to manage the clothing store, including products and other users.
- Clothing Store View: Displays available clothing items to the users.
- Database Setup: Includes PHP scripts that execute SQL scripts to set up all necessary database tables for storing information in every table required by the application.
- Responsive Design: Minimalistic and responsive CSS design.

## Key Files
See [File Structure](#file-structure) to locate each file in the project.

- index.php: All requests are routed through this file, which requires the header.php and footer.php views as well as the app.php file.
- .htaccess: Configures Apache to serve all incoming requests to the index.php file.
- app.php: Registers controllers and middleware with their respective routes in the Router.php file.
- Router.php: Formats every route on the website to hide the internal workings of the backend server as well as maps middleware and controllers to their respective routes within the website.
- DI_Container.php: The Dependecny Injection container for all models, middlewares, and controllers.
- DBConn.php: Establishes and provides other code with a static connection to the database.
- loadClothingStore.php: The file used to initially set up the database and then seed it at later stages.
- LoadEnv.php: Loads the environment variables in the .env file.

## Prerequisites
- Ensure you have Git installed on your machine - git version 2.34.1.
- Ensure you have [XAMPP](https://www.apachefriends.org/download.html) installed on your system - Version: XAMPP for Linux 8.1.25-0 or higher.
- You should have access to the configuration files for Apache.

## Pulling the repository to your local machine:
Exectue the below command to pull the project to your local machine.
```bash
git clone https://github.com/Ryan-Millard/Pastimes-WEDE6021-POE.git
cd Pastimes-WEDE6021-POE
```

## Configuration Steps

### 1. Update `httpd.conf` or `apache2.conf`
You need to add the following lines to your `httpd.conf` or `apache2.conf` file (possibly using elevated privileges), depending on your system:
Note that the file's name depends on which system you are using.

```apache
Alias /pastimes "/path/to/your/pastimes/public"

<Directory "/path/to/your/pastimes/public">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```

- Replace `/path/to/your/pastimes/public` with the actual path to the `public` directory of your Pastimes application, which is the directory in this application that contains the [index.php file](https://github.com/Ryan-Millard/Pastimes-WEDE6021-POE/blob/main/public/index.php).

### Example for Windows
If your application is located at `C:\xampp\htdocs\pastimes`, the configuration will look like this:

```apache
Alias /pastimes "C:/xampp/htdocs/pastimes/public"

<Directory "C:/xampp/htdocs/pastimes/public">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```

### Example for Linux
If your application is located at `/var/www/pastimes`, the configuration will look like this:

```apache
Alias /pastimes "/var/www/pastimes/public"

<Directory "/var/www/pastimes/public">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```

### 2. Update `httpd-vhosts.conf`
Next, you need to create and configure the `httpd-vhosts.conf` file located in your Apache `/opt/lampp/etc/` or `C:\xampp\apache\conf\extra\` directory depending on your OS:

#### Example for Linux
```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "/path/to/your/pastimes/public"

    <Directory "/path/to/your/pastimes/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

#### Example for Windows
```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "C:/xampp/htdocs/pastimes/public"

    <Directory "C:/xampp/htdocs/pastimes/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

- Again, replace `/path/to/your/pastimes/public` with the actual path to your `public` directory.

### 3. Enable Site Configuration:
#### Linux:
Open the file below

    /opt/lampp/etc/httpd.conf
Uncomment the following line in that file:

    #Include conf/extra/httpd-vhosts.conf
#### Windows:
Open the file below

    C:\xampp\apache\conf\httpd.conf
Uncomment the following line in that file:

    #Include conf/extra/httpd-vhosts.conf
Add the line below:

    Include conf/extra/pastimes.conf

### 5. Restart XAMPP:

#### Linux
    sudo /opt/lampp/lampp restart
    
#### Windows
    C:\xampp\xampp_stop
    C:\xampp\xampp_start

### Final Steps
1. **Save Changes**: After updating the configuration files, save your changes.
2. **Restart Apache**: Restart the Apache server to apply the changes. You can use the following command:

   - On Linux:
     ```bash
     sudo /opt/lampp/lampp restart
     ```

   - On Windows, use the XAMPP Control Panel or run:
     ```bash
     httpd -k restart
     ```

## Setting Up the Database
This topic covers setting up a new database with fictitious entries as well as seeding the database at a later stage.

### 1. Start XAMPP:

- On Linux:
  ```bash
  sudo /opt/lampp/lampp  start
  ```

- On Windows:
  ```bash
  C:\xampp\xampp_start.exe
  ```
### 2. Creating the .env file (if it doesn't exist) and ensure that it contains the below:

To get started with connecting to the database, you will need to create a .env file in the root directory of the project.
Once you have created it, open it in your preferred text editor and paste the below into the file, ensuring that the username and password is correct for the user you intend to use to connect to the database with:

    DB_HOST=localhost
    DB_USERNAME=root
    DB_PASSWORD=
    DB_DATABASE=pastimes

If you would like to create a custom configuration, see the [phpMyAdmin Documentation](https://docs.phpmyadmin.net/en/latest/user.html).
Remember to update the .env file to reference the newly created credentials for you database, including the user's username and password, the database name, and the host.
If you use a different database name, you will need to change it in several files to reflect your DB's name as well as rename the app/Database/pastimes.sql file to reflect your database's name, however that would be a long process, so that is not recommended.

#### Note:
- You will need to ensure that all details in the .env file are exactly the same as what your phpMyAdmin user has been configured with, namely the username and password.
- Unless you have created the database under a different name, you cannot change the DB_DATABASE as it will not function correctly if you do.

To connect to to the database, you only require those four credentials. The core/Functions/LoadEnv.php's EnvLoader class's load function only loads those four, so keep that in mind when configuring the .env file.

### 3. Create the `public/images/products/` directory

On every OS:

    mkdir public/images/products/

### 4. Open the project and navigate to the app/Seedeers directory:

- On all operating systems
    ```bash
    cd app/Seeders
    ```

### 4. Using PHP, execute the [loadClothingStore.php script](https://github.com/Ryan-Millard/Pastimes-WEDE6021-POE/blob/main/app/Seeders/loadClothingStore.php):

- On Linux:
  ```bash
  /opt/lampp/bin/php loadClothingStore.php
  ```
- On Windows:
  ```bash
  C:\xampp\php\php.exe loadClothingStore.php
  ```

  This script can be used to set up the database for the first time and to seed it at a later stage.

## Troubleshooting
### Application not loading:
Ensure that the .htaccess file in the public directory is set up correctly.

If you are experiencing issues with it, consult the [Apache Documentation](https://httpd.apache.org/docs/current/howto/htaccess.html).

### Seeding/Setting Up Database issues:

Try re-running the script and ensure that the database is correctly referenced by every file in the project.

## Running the Application
Once Apache and MySQL are configured and running, navigate to the following URL in your browser:
```bash
http://http://localhost/pastimes/
```


## File Structure
[file_structure.txt](https://github.com/Ryan-Millard/Pastimes-WEDE6021-POE/blob/main/file_structure.txt)
```
.
├── README.md

├── app

│   ├── Controllers

│   │   ├── AdminController.php

│   │   ├── CategoryController.php

│   │   ├── Controller.php

│   │   ├── DashboardController.php

│   │   ├── Error404Controller.php

│   │   ├── HomeController.php

│   │   ├── MessageController.php

│   │   ├── ProductController.php

│   │   ├── PurchaseController.php

│   │   └── UserController.php

│   ├── DI_Container.php

│   ├── Database

│   │   ├── DBConn.php

│   │   ├── pastimes.sql

│   │   └── tableStructure.docx

│   ├── Middleware

│   │   ├── AdminMiddleware.php

│   │   ├── AuthMiddleware.php

│   │   ├── BuyerMiddleware.php

│   │   ├── GuestMiddleware.php

│   │   └── SellerMiddleware.php

│   ├── Models

│   │   ├── AdminModel.php

│   │   ├── BuyerModel.php

│   │   ├── CategoryModel.php

│   │   ├── MessageModel.php

│   │   ├── Model.php

│   │   ├── ProductImageModel.php

│   │   ├── ProductModel.php

│   │   ├── SellerModel.php

│   │   ├── TransactionModel.php

│   │   ├── TransactionProductModel.php

│   │   ├── UserModel.php

│   │   └── WishlistModel.php

│   ├── Seeders

│   │   ├── AdminSeeder.php

│   │   ├── BuyerSeeder.php

│   │   ├── CategorySeeder.php

│   │   ├── MessageSeeder.php

│   │   ├── ProductImageSeeder.php

│   │   ├── ProductSeeder.php

│   │   ├── SeedDatabase.php

│   │   ├── Seeder.php

│   │   ├── SeedingHelp.txt

│   │   ├── SellerSeeder.php

│   │   ├── TransactionProductSeeder.php

│   │   ├── TransactionSeeder.php

│   │   ├── UserSeeder.php

│   │   ├── WishlistSeeder.php

│   │   ├── data

│   │   └── loadClothingStore.php

│   ├── app.php

│   └── views

│       ├── 404.php

│       ├── about.php

│       ├── adminDashboard.php

│       ├── category_list.php

│       ├── checkout.php

│       ├── contact.php

│       ├── edit_product.php

│       ├── home.php

│       ├── login.php

│       ├── message_list.php

│       ├── new_listing.php

│       ├── product_list.php

│       ├── shared

│       ├── signup.php

│       ├── single_category.php

│       ├── single_conversation.php

│       ├── single_product.php

│       ├── single_transaction.php

│       ├── single_user.php

│       ├── transactions_list.php

│       ├── user.php

│       └── userDashboard.php

├── core

│   ├── Functions
│   │   ├── LoadEnv.php

│   │   └── dd.php

│   └── Router.php

├── file_structure.txt

└── public
    
    ├── css
    
    │   └── index.css
    
    ├── images
    
    │   ├── banner.webp
    
    │   └── products
    
    └── index.php
```

15 directories, 76 files

## Functionality

### Seeding the Database:
See the prior topic on [Setting Up the Database](#setting-up-the-database) as you will need to follow the same process.

### User Accounts:
#### 1. Registering New Accounts:
You should be able to register a new account as long as another user does not have the same details. 

To do so:
- Click on the "Log in" button in the top right corner of the screen.
- Click on the "Sign up" link above the form.
- Enter the new account's details

#### 2. Logging into Existing Accounts:
If you successfully created and loaded the database with fictitious entries (see [Setting Up the Database](#setting-up-the-database) if you have not), you should be able to log into existing user accounts.

To do so:
- Click on the "Log in" button in the top right corner of the screen.
- Enter the user's username and password (You can get those details in the [userData.txt file](https://github.com/Ryan-Millard/Pastimes-WEDE6021-POE/blob/main/app/Seeders/data/userData.txt) or from the [User's table in phpMyAdmin]([http://localhost/phpmyadmin/index.php?route=/table/structure&db=pastimes&table=Users](http://localhost/phpmyadmin/index.php?route=/sql&db=pastimes&table=Users&pos=0))). Note that all users have the same password, "password123", and their usernames are the second entry in the txt file.

#### 3. Logging into Specific Existing Account Types:
All created accounts are logged in the [Users table](http://localhost/phpmyadmin/index.php?route=/sql&db=pastimes&table=Users&pos=0), but for them to be usable, they must be referenced by the "user_id" foreign key in either the Sellers, Buyers, or Admins table.

To see which user has one of the above account types, compare their user_id to that of the referenced foreign_key in one of the aforementioned child tables.

## Additional Information

### Features
A list of key features included in the project:

- User Registration and Login: Users can create accounts and log in with predefined credentials.
- Product Listings: Sellers can list their second-hand clothing products.
- Shopping Cart and Checkout: Buyers can add products to their cart and proceed with checkout.
- Transaction Management: Both sellers and buyers can manage their transactions.
- Wishlist: Users can save products to their wishlist for future consideration.
- Admin Panel: Administrators can manage users, products, and transactions.
- Responsive Design: The application is designed to work on desktop and mobile devices.

### Technology Stack
- Backend: PHP (MVC architecture)
- Frontend: HTML, CSS, JavaScript
- Database: MySQL (using phpMyAdmin for database management)
- Server: Apache (XAMPP for local development)
- Version Control: Git

### Database Structure
- Users Table: Contains user details like name, email, and password.
- Sellers Table: Contains details specific to sellers (linked via user_id).
- Buyers Table: Contains details specific to buyers (linked via user_id).
- Admins Table: Contains details specific to admins (linked via user_id).
- Products Table: Contains product details like name, description, price, and associated seller.
- Product_Images Table: Contains images specific to products (linked via product_id).
- Transactions Table: Stores details of purchases made by buyers.
- Transaction_Products Table: Stores details of individual purchases made by buyers (linked via transaction_id).
- Wishlists Table: Stores products saved by users for future reference.
- Categories Table: Stores the various categories of products available in the store.
- Messages Table: Stores messages send by users and references two users (linked via user_id).

### Seeding
- All code for seeding can be found in the app/Seeders directory
- Every table in the database has a seeder class, which all inherit from the Seeder base class in the Seeder.php file, which allows data to be loaded into the database when the loadClothingStore.php file is run.
- loadClothingStore.php calls the seed() function from the SeedDatabase class in SeedDatabase.php
- SeedDatabase.php is the file that seeds the database. It connects to the database, ensures that the database exists (and creates it if it doesn't using the Database::createDatabaseIfNotExists() function, which can be found in app/Database/DBConn.php), then calls the seed() function on every Seeder child class.
- The app/Database/DBConn.php file enables all database interactions by providing the connection object through it's getConnection() function.
- To load the .env file in the root directory, the app/Database/DBConn.php file uses the core/Functions/LoadEnv.php's EnvLoader class's load() function, which splits each entry into key value pairs and saves them using PHP's putenv() function.
- Note that there is no CreateTable.php file as each Seeder file, e.g. UserSeeder.php and ProductSeeder.php, corresponds to it's own table and will handle the dropping and re-creation of it's specified table.
- In addition, each Seeder has a CSV-like text data file to use when seeding, which can be found in the app/Seeders/data directory (the naming convention is {table's name}Data.php).
- The only exception to this is the ProductImageSeeder as it's table requires actual images as well as text data. As a result, the app/Seeders/data/ProductImages directory contains images for the table and the app/Seeders/data/productImageData.txt file contains the text data for seeding that table. When seeding, the ProductImageSeeder copies the image files to the public/images/products directory but gives each file a unique name to avoid naming conflicts.
- Every User seeded by the UserSeeder will have "password123" as their password, as can be seen in the 4th column in the app/Seeders/data/userData.txt file.

## Contributors:

- [Ryan Millard](https://github.com/Ryan-Millard)

## Conclusion
Once the configurations are complete and Apache is restarted, you should be able to access your Pastimes application at `http://localhost/pastimes`.

For further assistance, please refer to the [Apache documentation](https://httpd.apache.org/docs/) or contact your server administrator.
