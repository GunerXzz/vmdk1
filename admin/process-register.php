<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $check_email = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check_email->num_rows > 0) {
        $_SESSION['register_error'] = "An account with this email already exists.";
        header("Location: ../register.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Updated SQL query with the new columns
    $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES ('$firstname', '$lastname', '$email', '$hashed_password', 'customer')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../login.php");
        exit();
    } else {
        $_SESSION['register_error'] = "Error: " . $conn->error;
        header("Location: ../register.php");
        exit();
    }
}
$conn->close();
?>
