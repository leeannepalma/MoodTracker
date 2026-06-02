
# Admin Guide

## Configuration

### Database Connection
The database connection is configured in `config.php`:
```php
$host     = 'localhost';
$db       = 'moodtracker';
$user     = 'root';
$password = 'your_password';
```
Update the password field to match your MariaDB root password.

### Apache Configuration
The application runs under Apache's default document root at `/var/www/html/mood-tracker/`. No additional Apache configuration is required.

## Database Management

### Accessing the Database
```bash
sudo mysql -u root -p
USE moodtracker;
```

### View All Members
```sql
SELECT * FROM members;
```

### Add a New Member
```sql
INSERT INTO members (name) VALUES ('New Member Name');
```

### View All Entries
```sql
SELECT entries.id, members.name, entries.mood, entries.note, entries.created_at
FROM entries
JOIN members ON entries.member_id = members.id
ORDER BY entries.created_at DESC;
```

### Delete an Entry
```sql
DELETE FROM entries WHERE id = <entry_id>;
```

## Maintenance

### Restarting Apache
```bash
sudo service apache2 restart
```

### Updating the Application
Pull the latest changes from the repository:
```bash
cd /var/www/html/mood-tracker
sudo git pull origin main
```

### Backing Up the Database
```bash
sudo mysqldump -u root -p moodtracker > moodtracker_backup.sql
```

### Restoring the Database
```bash
sudo mysql -u root -p moodtracker < moodtracker_backup.sql
```

### Checking Apache Status
```bash
sudo service apache2 status
```

### Checking MariaDB Status
```bash
sudo service mariadb status
```
