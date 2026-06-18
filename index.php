<?php
$server = "warranty-sql-server-elliott.database.windows.net";
$database = "warrantydb";
$username = "fmtest";
$password = "sqladminuser@123";

try {
    $conn = new PDO(
        "sqlsrv:server=$server;Database=$database",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("DB Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("
        INSERT INTO WarrantyRequests 
        (CustomerName, Email, Address, IssueType, Description)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST["name"],
        $_POST["email"],
        $_POST["address"],
        $_POST["issue"],
        $_POST["description"]
    ]);

    $message = "Warranty request submitted successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Warranty Portal</title>
</head>
<body>

<h1>Elliott Homes Warranty Portal</h1>

<?php if (isset($message)) echo "<p style='color:green'>$message</p>"; ?>

<form method="POST">
    <input name="name" placeholder="Name" required><br><br>
    <input name="email" placeholder="Email" required><br><br>
    <input name="address" placeholder="Address" required><br><br>

    <select name="issue">
        <option>Plumbing</option>
        <option>Electrical</option>
        <option>HVAC</option>
        <option>Structural</option>
    </select><br><br>

    <textarea name="description" placeholder="Describe issue"></textarea><br><br>

    <button type="submit">Submit Request</button>
</form>

</body>
</html>
