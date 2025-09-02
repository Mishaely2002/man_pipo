<?php
$conn = new mysqli("localhost", "root", "", "school_dbs");

if ($conn->connect_error) {
    die("❌ DB Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $category = $_POST['category'] ?? 'other';
    $adminId = $_SESSION['admin_id'] ?? 1;

    $targetDir = "uploads/";
    $fileName = basename($file["name"]);
    $filePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    $allowed = ['pdf','doc','docx','xls','xlsx','csv','txt','jpg','jpeg','png','gif','mp4','mp3','zip','rar'];
    if (!in_array($fileType, $allowed)) {
        echo "<div class='error'>❌ Invalid file type: .$fileType not allowed.</div>";
        exit;
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO uploaded_files (admin_id, file_name, file_type, file_path, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $adminId, $fileName, $fileType, $filePath, $category);
        $stmt->execute();
        echo "<div class='success'>✅ File uploaded successfully!</div>";
    } else {
        echo "<div class='error'>❌ Upload failed. Check folder permissions.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 40px; }
        form { background: #fff; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="file"], select, button { width: 100%; padding: 10px; margin-top: 5px; }
        button { background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { color: green; text-align: center; margin-top: 20px; }
        .error { color: red; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>📤 Upload Document</h2>
        <label>Choose file:</label>
        <input type="file" name="file" required>

        <label>Category:</label>
        <select name="category">
            <option value="exams_results">Exams</option>
            <option value="unpaid_fee">Unpaid Fee</option>
            <option value="report">Report</option>
            <option value="dropping_out">Dropping Out</option>
            <option value="other">Other</option>
            <option value="school_regulations_and_laws">School Regulatios And Laws</option>
        </select>

        <button type="submit" name="upload">Upload</button>
    </form>
</body>
</html>
