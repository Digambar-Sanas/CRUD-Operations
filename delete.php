<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /CRUD-Project/index.php?message=Client deleted successfully");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request!";
}

$connection->close();
?>