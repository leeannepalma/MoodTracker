
# Installation Guide

## Hardware Requirements
- Raspberry Pi Zero 2W
- MicroSD card (8GB or more)
- USB cable or Ethernet adapter for connection

## Software Requirements
- DietPi OS (Debian-based)
- Apache HTTP Server
- PHP 8.4
- MariaDB

## Installation Steps

### 1. Update the System
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install Apache
```bash
sudo apt install apache2 -y
```

### 3. Install PHP and Required Modules
```bash
sudo apt install php libapache2-mod-php php8.4-mysql -y
```

### 4. Enable PHP Module
```bash
sudo a2dismod mpm_event
sudo a2enmod mpm_prefork
sudo a2enmod php8.4
sudo service apache2 restart
```

### 5. Install MariaDB
```bash
sudo apt install mariadb-server -y
```

### 6. Set Up the Database
Log into MariaDB:
```bash
sudo mysql -u root -p
```

Run the following SQL commands:
```sql
CREATE DATABASE moodtracker;
USE moodtracker;

CREATE TABLE members (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, email VARCHAR(100), bio TEXT, photo_url VARCHAR(255));

CREATE TABLE entries (id INT AUTO_INCREMENT PRIMARY KEY, member_id INT NOT NULL, mood INT NOT NULL, note TEXT, created_at DATE NOT NULL, FOREIGN KEY (member_id) REFERENCES members(id));

INSERT INTO members (name) VALUES ('Kevicia'), ('Troya'), ('Tyrese'), ('Leeanne'), ('Lordwish'), ('Saelle'), ('Jonathan');
```

Set the root password:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED BY 'your_password_here';
FLUSH PRIVILEGES;
EXIT;
```

### 7. Clone the Repository
```bash
cd /var/www/html
sudo git clone https://github.com/leeannepalma/tsharp.git mood-tracker
```

### 8. Configure Database Connection
Edit the config file:
```bash
sudo nano /var/www/html/mood-tracker/config.php
```
Update the password to match your MariaDB password.

### 9. Access the Application
Open a browser and go to:
