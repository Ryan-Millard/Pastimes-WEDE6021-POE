# Pastimes Project Setup Instructions

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Configuration Steps](#configuration-steps)
- [Setting Up the Database](#setting-up-the-database)
- [Troubleshooting](#troubleshooting)
- [Running the Application](#running-the-application)
- [Functionality](#functionality)
- [Additional Information](#additional-information)
- [Contributors](#contributors)
- [Conclusion](#conclusion)

## Introduction
This document outlines the necessary configurations for your XAMPP server to properly serve the Pastimes project.

## Project Overview
Pastimes is a second-hand e-clothing store built using PHP. It allows users to browse, buy, and sell clothing items, while managing their transactions and wishlists. The project follows an MVC architecture and includes features such as user authentication, product listings, and transaction management.

## Prerequisites
- Ensure you have Git installed on your machine.
- Ensure you have [XAMPP](https://www.apachefriends.org/download.html) installed on your system (Windows/Linux).
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
Once you have created it, open it in your preferred text editor and paste the below into the file:

    DB_HOST=localhost
    DB_USERNAME=root
    DB_PASSWORD=
    DB_DATABASE=pastimes

If you would like to create a custom configuration, see the [phpMyAdmin Documentation](https://docs.phpmyadmin.net/en/latest/user.html).
Remember to update the .env file to reference the newly created credentials for you database, including the user's username and password, the database name, and the host.
If you use a different database name, you will need to change it in several files to reflect your DB's name, however that would be a long process, so that is not recommended.

#### Note:
- You will need to ensure that all details in the file are exactly the same as what phpMyAdmin has been configured with.
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

## Contributors:

- [Ryan Millard](https://github.com/Ryan-Millard)

## Conclusion
Once the configurations are complete and Apache is restarted, you should be able to access your Pastimes application at `http://localhost/pastimes`.

For further assistance, please refer to the [Apache documentation](https://httpd.apache.org/docs/) or contact your server administrator.
