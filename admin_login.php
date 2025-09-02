<?php
session_start();

$conn = new mysqli("localhost", "root", "", "school_dbs");
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT admin_id, username, password_hash FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin["password_hash"])) {
        $_SESSION["admin_id"] = $admin["admin_id"];
        $_SESSION["admin_username"] = $admin["username"];
        $_SESSION["is_admin"] = true;

        // Optional: prevent caching
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Pragma: no-cache");

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 Admin Login</h2>
        <?php if (!empty($error)) echo "<div class='error'>" . htmlspecialchars($error) . "</div>"; ?>
        <form method="POST" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required autocomplete="new-username">
            <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
