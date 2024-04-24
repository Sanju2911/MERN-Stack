<?php
// Validate and sanitize user input
$Username = isset($_POST['Username']) ? htmlspecialchars($_POST['Username']) : '';
$Email = isset($_POST['Email']) ? filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL) : '';
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

// Validate email format
if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    // Hash the password before storing it
    $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO registration (Username, Email, Password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Username, $Email, $Password,);
    
    if ($stmt->execute()) {
        echo "Registration successfully. <a href='login.html'><button>Login</button></a>";
        // header("location: Login.html");

    exit();
    } else {
        echo "Registration failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
