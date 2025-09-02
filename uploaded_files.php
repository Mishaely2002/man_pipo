<?php
session_start();
$conn = new mysqli("localhost", "root", "", "school_dbs");

// Access control
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("SELECT file_path FROM uploaded_files WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();

    if ($file && file_exists($file['file_path'])) {
        unlink($file['file_path']); // Delete file from server
    }

    $conn->query("DELETE FROM uploaded_files WHERE id = $id");
    header("Location: admin_manageFiles.php");
    exit;
}

$result = $conn->query("SELECT * FROM uploaded_files ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>📁 Manage Uploaded Files</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; padding: 20px; }
        h2 { color: #2c3e50; }
        .file-card {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #3498db;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            position: relative;
        }
        .file-meta { font-size: 0.9em; color: #555; }
        .file-link { font-size: 1.1em; font-weight: bold; color: #2980b9; text-decoration: none; }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e74c3c;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>📁 Manage Uploaded Files</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <?php
            $ext = strtolower($row['file_type']);
            $icon = match($ext) {
                'pdf' => '📕', 'doc', 'docx' => '📘', 'xls', 'xlsx' => '📗', 'csv' => '📙',
                'txt' => '📄', 'html', 'htm' => '🌐', 'css' => '🎨', 'js' => '⚙️',
                'php', 'py', 'java', 'c', 'cpp', 'rb' => '💻', 'jpg', 'jpeg', 'png', 'gif' => '🖼️',
                'mp3', 'wav' => '🎵', 'mp4', 'avi' => '🎥', 'zip', 'rar' => '🗜️',
                default => '📁'
            };
            $timestamp = date("M d, Y H:i", strtotime($row['uploaded_at']));
        ?>
        <div class="file-card">
            <form method="GET" onsubmit="return confirm('Delete this file?');">
                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                <button class="delete-btn">🗑️ Delete</button>
            </form>
            <div class="file-meta">
                <?= $icon ?> <a class="file-link" href="<?= $row['file_path'] ?>" target="_blank"><?= $row['file_name'] ?></a><br>
                Category: <strong><?= $row['category'] ?></strong><br>
                Uploaded At: <?= $timestamp ?>
            </div>
        </div>
    <?php endwhile; ?>
</body>
</html>
