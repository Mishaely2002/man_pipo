<?php
$conn = new mysqli("localhost", "root", "", "school_dbs");
if ($conn->connect_error) {
    die("❌ DB Connection failed: " . $conn->connect_error);
}

// Get selected category from URL or default to 'all'
$category = $_GET['category'] ?? 'all';

// Fetch distinct categories from DB
$categories = [];
$catResult = $conn->query("SELECT DISTINCT category FROM uploaded_files WHERE category IS NOT NULL AND category != ''");
if ($catResult) {
    while ($catRow = $catResult->fetch_assoc()) {
        $categories[] = $catRow['category'];
    }
}

// Prepare query based on selected category
if ($category === 'all') {
    $sql = "SELECT file_name, file_type, file_path, category, uploaded_at FROM uploaded_files ORDER BY uploaded_at DESC";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT file_name, file_type, file_path, category, uploaded_at FROM uploaded_files WHERE category = ? ORDER BY uploaded_at DESC";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $category);
    }
}

// Execute query and fetch results
if (!$stmt || !$stmt->execute()) {
    die("❌ Query failed: " . ($stmt ? $stmt->error : $conn->error));
}
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>📁 View Uploaded Files</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 40px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        form { text-align: center; margin-bottom: 20px; }
        select { padding: 10px; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        a.download { color: #007bff; text-decoration: none; }
        a.download:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📁 Uploaded Files</h2>
        <form method="GET">
            <label for="category">Filter by Category:</label>
            <select name="category" onchange="this.form.submit()">
                <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>All</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $cat))) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <table>
            <tr>
                <th>File Name</th>
                <th>Type</th>
                <th>Category</th>
                <th>Uploaded At</th>
                <th>Download</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['file_name']) ?></td>
                    <td><?= strtoupper($row['file_type']) ?></td>
                    <td><?= ucfirst(str_replace('_', ' ', $row['category'])) ?></td>
                    <td><?= date("M d, Y H:i", strtotime($row['uploaded_at'])) ?></td>
                    <td>
                        <?php if (file_exists($row['file_path'])): ?>
                            <a class="download" href="<?= htmlspecialchars($row['file_path']) ?>" download>Download</a>
                        <?php else: ?>
                            <span style="color:red;">Missing</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center;">No files found for this category.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
