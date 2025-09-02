<?php
$conn = new mysqli("localhost", "root", "", "school_dbs");
if ($conn->connect_error) {
    die("<h3 style='color:red;'>Connection failed: " . $conn->connect_error . "</h3>");
}

// ✅ Fetch only active notifications
$now = date("Y-m-d H:i:s");
$result = $conn->query("SELECT * FROM notifications WHERE expires_at IS NULL OR expires_at > '$now' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        h2 { color: #007BFF; }
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
    </style>
</head>
<body>
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
                <p><?= htmlspecialchars($row['message']) ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No active notifications found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
