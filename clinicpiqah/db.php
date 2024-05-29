<?php
$servername = "localhost";
$username = "root";
$password = "";  // xampp default password
$dbname = "clinic_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Optional: You can remove or comment this line in production
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
