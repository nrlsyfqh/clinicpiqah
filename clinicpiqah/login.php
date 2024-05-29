<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Check if form data is received correctly
    if (empty($name) || empty($password)) {
        echo "<script>alert('Name and password are required.'); window.location.href='login.html';</script>";
        exit();
    }

    try {
        // Retrieve user from database by name (assuming name is unique)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
        $stmt->execute([$name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                echo "<script>alert('Login successful.'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Incorrect password.'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('User not registered.'); window.location.href='login.html';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href='login.html';</script>";
    }
}
?>
