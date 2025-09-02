<?php
session_start();
$conn = new mysqli("localhost", "root", "", "school_dbs");
$error = "";
$notifications = [];

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"], $_POST["password"])) {
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
    } else {
        $error = "❌ Invalid username or password.";
    }
}

// If not logged in, show login form
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true):
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title><style>/* same login styles as before */</style></head>
<body>
    <div class="login-box">
        <h2>🔐 Admin Login</h2>
        <?php if (!empty($error)) echo "<div class='error'>" . htmlspecialchars($error) . "</div>"; ?>
        <form method="POST" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
<?php exit; endif; ?>

<?php
// Handle delete request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    // Optional: delete attached file if stored
    $stmt = $conn->prepare("SELECT file_path FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();

    if ($file && !empty($file['file_path']) && file_exists($file['file_path'])) {
        unlink($file['file_path']); // delete file
    }

    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin_manageNotifications.php");
    exit;
}

// Fetch notifications
$result = $conn->query("SELECT id, title, message, created_at, file_path FROM notifications ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Notifications</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; padding: 20px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .notification { background: white; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); position: relative; }
        .notification h3 { margin: 0 0 10px; }
        .notification p { margin: 0; }
        .timestamp { font-size: 0.85em; color: #888; margin-top: 8px; }
        .delete-btn { position: absolute; top: 10px; right: 10px; background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        .file-link { margin-top: 10px; display: block; font-size: 0.9em; color: #2980b9; }
    </style>
</head>
<body>
    <h2>📢 Admin Notification Center</h2>
    <?php if (empty($notifications)): ?>
        <p>No notifications found.</p>
    <?php else: ?>
        <?php foreach ($notifications as $note): ?>
            <div class="notification">
                <form method="GET" onsubmit="return confirm('Delete this notification?');">
                    <input type="hidden" name="delete_id" value="<?= $note['id'] ?>">
                    <button class="delete-btn">🗑️ Delete</button>
                </form>
                <h3><?= htmlspecialchars($note['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($note['message'])) ?></p>
                <div class="timestamp">Posted on <?= htmlspecialchars($note['created_at']) ?></div>
                <?php if (!empty($note['file_path'])): ?>
                    <a class="file-link" href="<?= htmlspecialchars($note['file_path']) ?>" target="_blank">📎 View Attachment</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
