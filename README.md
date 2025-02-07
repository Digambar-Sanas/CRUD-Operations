# CRUD Operations Project

This is a simple CRUD (Create, Read, Update, Delete) operations project using PHP and MySQL with Bootstrap for styling.

## Features
- Add new clients
- View a list of clients
- Edit client details
- Delete clients with confirmation prompt
- Prevent duplicate email entries

## Technologies Used
- PHP
- MySQL
- Bootstrap 5
- HTML & CSS

## Setup Instructions

### 1. Clone the Repository
```sh
 git clone https://github.com/yourusername/CRUD-Project.git
 cd CRUD-Project
```

### 2. Create the Database
1. Open **phpMyAdmin** or any MySQL client.
2. Create a database named `crud`.
3. Run the following SQL query to create the `clients` table:

```sql
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Configure Database Connection
Modify `config.php` (or inside `index.php`, `create.php`, `edit.php`, `delete.php`) to match your database credentials:
```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud";
$connection = new mysqli($servername, $username, $password, $database);
```

### 4. Start the Project
Start a local PHP server using the command:
```sh
php -S localhost:8000
```
Then open `http://localhost:8000/index.php` in your browser.

## File Structure
```
CRUD-Project/
│── index.php       # List all clients
│── create.php      # Add new client
│── edit.php        # Edit client details
│── delete.php      # Delete a client
│── config.php      # Database connection file (if used separately)
│── README.md       # Project documentation
```

## Screenshots
![Client List](https://via.placeholder.com/800x400?text=Client+List+UI)
![Add Client](https://via.placeholder.com/800x400?text=Add+Client+Form)

## License
This project is licensed under the MIT License.
