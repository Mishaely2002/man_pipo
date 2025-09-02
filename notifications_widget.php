<?php
// notifications_widget.php
$conn = new mysqli("localhost", "root", "", "school_dbs");
if ($conn->connect_error) {
    echo "<p style='color:red;'>Database connection failed.</p>";
    return;
}

$result = $conn->query("SELECT title, message, created_at FROM notifications ORDER BY created_at DESC LIMIT 5");

echo "<div style='background:#f0f8ff; padding:15px; border-radius:8px; margin:20px 0;'>";
echo "<h3>📢 Latest Notifications</h3>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border-left:4px solid #00796b; padding-left:10px; margin-bottom:15px;'>
                <strong>{$row['title']}</strong><br>
                <small><em>{$row['created_at']}</em></small>
                <p>{$row['message']}</p>
              </div>";
    }
} else {
    echo "<p>No notifications available at the moment.</p>";
}

echo "</div>";
?>
