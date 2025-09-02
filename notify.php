<?php
session_start();
$conn = new mysqli("localhost", "root", "", "school_dbs");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ✅ Auto-link function
function make_links_clickable($text) {
    $escaped = htmlspecialchars($text);
    return preg_replace(
        '/(https?:\/\/[^\s]+)/',
        '<a href="$1" target="_blank" style="color:#007BFF; text-decoration:underline;">$1</a>',
        $escaped
    );
}

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["message"])) {
    $message = $conn->real_escape_string($_POST["message"]);
    $expires_at = !empty($_POST["expires_at"]) ? "'" . $conn->real_escape_string($_POST["expires_at"]) . "'" : "NULL";

    // ✅ Optional file upload
    $file_path = "NULL";
    if (isset($_FILES["attachment"]) && is_uploaded_file($_FILES["attachment"]["tmp_name"])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["attachment"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
            $file_path = "'" . $conn->real_escape_string($targetFilePath) . "'";
        }
    }

    $sql = "INSERT INTO notifications (message, file_path, expires_at) VALUES ('$message', $file_path, $expires_at)";
    echo $conn->query($sql)
        ? "<p style='color:green;'>✅ Notification saved!</p>"
        : "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
}

// ✅ Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"]) && $_SESSION['role'] === 'admin') {
    $id = intval($_POST["delete_id"]);
    $conn->query("DELETE FROM notifications WHERE id = $id");
}

// ✅ Fetch active notifications
$now = date("Y-m-d H:i:s");
$result = $conn->query("SELECT * FROM notifications WHERE expires_at IS NULL OR expires_at > '$now' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>School Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h2 { color: #007BFF; }
        form { margin-bottom: 30px; background: #fff; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        textarea, input[type="datetime-local"], input[type="file"] { width: 100%; padding: 10px; font-size: 1em; margin-bottom: 10px; }
        button { padding: 10px 20px; background: #007BFF; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .notification {
            background: #fff;
            border-left: 5px solid #007BFF;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .timestamp {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 8px;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 10px;
        }
        .delete-btn:hover {
            background: #a71d2a;
        }
    </style>
</head>
<body>
    <h2>📢 Send a Notification</h2>
    <form method="POST" enctype="multipart/form-data">
        <textarea name="message" rows="4" placeholder="Enter your notification..." required></textarea>
        <label for="expires_at">Optional Expiration:</label>
        <input type="datetime-local" name="expires_at" id="expires_at">
        <label for="attachment">Attach File (optional):</label>
        <input type="file" name="attachment" id="attachment">
        <button type="submit">Send Notification</button>
    </form>

    <h2>📬 Active Notifications</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="notification">
                <div class="timestamp">
                    <?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?>
                    <?php if (!empty($row['expires_at'])): ?>
                        <span style="color:#dc3545;">(Expires: <?= date("F j, Y, g:i a", strtotime($row['expires_at'])) ?>)</span>
                    <?php endif; ?>
                </div>
                <p><?= make_links_clickable($row['message']) ?></p>
                <?php if (!empty($row['file_path']) && $row['file_path'] !== "NULL"): ?>
                    <a href="<?= $row['file_path'] ?>" download>📎 Download Attachment</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <button class="delete-btn">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No active notifications found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
