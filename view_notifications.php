<?php
// view_notifications.php

include 'db_connect.php'; // Ensure this connects to your school_dbs database

$query = "SELECT message, created_at FROM notifications ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

echo "<h2>📢 Latest Notifications</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Message</th><th>Posted At</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
    echo "<td>" . date("M d, Y H:i", strtotime($row['created_at'])) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
