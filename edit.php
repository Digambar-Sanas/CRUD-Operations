<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";
$errorMessage = "";
$successMessage = "";

// Check if 'id' is provided
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Fetch client data
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $email = $row["email"];
        $phone = $row["phone"];
        $address = $row["address"];
    } else {
        header("Location: /CRUD-Project/index.php");
        exit();
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);

    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $errorMessage = "All fields are required!";
    } else {
       
        $checkEmailSQL = "SELECT id FROM clients WHERE email = ? AND id != ?";
        $checkStmt = $connection->prepare($checkEmailSQL);
        $checkStmt->bind_param("si", $email, $id);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $errorMessage = "Error: This email is already registered with another client!";
        } else {
            $updateSQL = "UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
            $updateStmt = $connection->prepare($updateSQL);
            $updateStmt->bind_param("ssssi", $name, $email, $phone, $address, $id);

            if ($updateStmt->execute()) {
                $successMessage = "Client updated successfully!";
            } else {
                $errorMessage = "Error: " . $updateStmt->error;
            }
            $updateStmt->close();
        }
        $checkStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Client</h2>

        <!-- Display error message -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-secondary" href="/CRUD-Project/index.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
