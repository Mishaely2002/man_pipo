<?php include("auth.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .sidebar {
            width: 220px;
            background-color: #34495e;
            position: fixed;
            top: 0;
            bottom: 0;
            padding-top: 60px;
            color: white;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #1abc9c;
        }
        .main {
            margin-left: 220px;
            padding: 30px;
        }
        .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: #ecf0f1;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>!</h1>
        <p>School Management Admin Dashboard</p>
    </div>

    <div class="sidebar">
        <a href="notify.php">📢 Send Notification</a>
        <a href="notifications.php">📨 View Notifications</a>
        <a href="upload_file.php">📁 Upload File</a>
        <a href="uploaded_files.php">📂 Uploaded Files</a>
        <a class="logout" href="logout.php">🚪 Logout</a>
        <a href="admin_manageNotifications.php"> Manage Notifications</a>
    </div>

    <div class="main">
        <h2>Dashboard Overview</h2>
        <p>Select a module from the sidebar to begin managing your school system.</p>
        <!-- You can embed content dynamically here if needed -->
    </div>

</body>
</html>
