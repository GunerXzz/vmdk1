<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection Failed: " . $conn->connect_error); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // --- SUCCESS: Store the new name fields in the session ---
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname']; // New
            $_SESSION['lastname'] = $user['lastname'];   // New
            $_SESSION['role'] = $user['role'];
            
            // Redirect logic remains the same
            if (isset($_SESSION['redirect_url'])) {
                $redirect_url = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);
                header("Location: " . $redirect_url);
            } else {
                if ($user['role'] == 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../index.php");
                }
            }
            exit();
        }
    }
    
    $_SESSION['login_error'] = "Invalid email or password.";
    header("Location: ../login.php");
    exit();
}
$conn->close();
?>
