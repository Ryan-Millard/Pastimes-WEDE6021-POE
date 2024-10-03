# Pastimes Project Setup Instructions

This document outlines the necessary configurations for your Apache server to properly serve the Pastimes project.

## Prerequisites
- Ensure you have Apache installed on your system (Windows/Linux).
- You should have access to the configuration files for Apache.

## Configuration Steps

### 1. Update `httpd.conf` or `apache2.conf`
You need to add the following lines to your `httpd.conf` or `apache2.conf` file, depending on your system:

```apache
Alias /pastimes "/path/to/your/app/public"

<Directory "/path/to/your/app/public">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
```

- Replace `/path/to/your/app/public` with the actual path to the `public` directory of your Pastimes application.

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

### 2. Update `pastimes.conf`
Next, you need to configure the `pastimes.conf` file located in your Apache `sites-available` directory:

```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "/path/to/your/app/public"

    <Directory "/path/to/your/app/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

- Again, replace `/path/to/your/app/public` with the actual path to your `public` directory.

### Example for Windows
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

### Example for Linux
```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot "/var/www/pastimes/public"

    <Directory "/var/www/pastimes/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

## Final Steps
1. **Save Changes**: After updating the configuration files, save your changes.
2. **Restart Apache**: Restart the Apache server to apply the changes. You can use the following command:

   - On Linux:
     ```bash
     sudo systemctl restart apache2
     ```

   - On Windows, use the XAMPP Control Panel or run:
     ```bash
     httpd -k restart
     ```

## Conclusion
Once the configurations are complete and Apache is restarted, you should be able to access your Pastimes application at `http://localhost/pastimes`.

For further assistance, please refer to the [Apache documentation](https://httpd.apache.org/docs/) or contact your server administrator.

