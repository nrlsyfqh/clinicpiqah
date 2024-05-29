<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Retrieve user name from the database using the user_id from the session
try {
    $stmt = $pdo->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $user_name = $user['name'];
    } else {
        // If user not found, log out and redirect to login page
        session_destroy();
        header('Location: login.html');
        exit();
    }
} catch (PDOException $e) {
    echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href='login.html';</script>";
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #fde0e1;
        }

        .dashboard {
            text-align: center;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 2px 9px 49px -17px rgba(0, 0, 0, 0.1);
        }

        .dashboard h1 {
            font-size: 2.5rem;
            color: #272346;
            margin-bottom: 1rem;
        }

        .dashboard p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .dashboard form button {
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            background: #ee6969;
            border: none;
            border-radius: 35px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .dashboard form button:hover {
            background: #d45b5b;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <p>You have successfully logged in to the Happy Health Clinic Management System.</p>
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
