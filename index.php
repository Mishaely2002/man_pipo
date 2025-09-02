<?php
$conn = new mysqli("localhost", "root", "", "school_dbs");
if ($conn->connect_error) die("❌ Connection failed: " . $conn->connect_error);

$now = date("Y-m-d H:i:s");

// Auto-link function
function make_links_clickable($text) {
    $escaped = htmlspecialchars($text);
    return preg_replace(
        '/(https?:\/\/[^\s]+)/',
        '<a href="$1" target="_blank" style="color:#007BFF; text-decoration:underline;">$1</a>',
        $escaped
    );
}

// Fetch notifications
$notifResult = $conn->query("SELECT message, created_at FROM notifications WHERE expires_at IS NULL OR expires_at > '$now' ORDER BY created_at DESC");

// Fetch uploaded files
$fileResult = $conn->query("SELECT file_name, file_type, file_path, category, uploaded_at FROM uploaded_files ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mwansele High School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: url('pipo.png') no-repeat center center fixed;
            background-size: cover;
        }
        .landing-wrapper {
            padding: 40px 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            margin: 40px auto;
            max-width: 1000px;
        }
        h1 {
            background-color: palegreen;
            padding: 20px;
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #2c3e50;
            border-radius: 8px;
        }
        nav a {
            margin: 0 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover { text-decoration: underline; }
        .mission { font-size: 1.2em; color: #555; margin-bottom: 30px; }
        .highlights { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        .highlight-box {
            background: white; padding: 20px; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 280px; text-align: left;
        }
        .cta-button {
            display: inline-block; margin-top: 30px; padding: 12px 24px;
            background-color: #2c3e50; color: white; text-decoration: none;
            border-radius: 6px; font-weight: bold;
        }
        .cta-button:hover { background-color: #1abc9c; }
        .widget {
            margin: 40px auto; max-width: 900px;
            background: rgba(255, 255, 255, 0.95); padding: 25px;
            border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            text-align: left;
        }
        .widget h3 { margin-top: 0; color: #2c3e50; }
        .file-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .file-table th, .file-table td {
            padding: 10px; border-bottom: 1px solid #ddd; text-align: left;
        }
        .file-table th { background-color: #f0f0f0; }
        .badge {
            padding: 4px 8px; border-radius: 4px; font-size: 0.9em; color: white;
        }
        .csv { background-color: #3498db; }
        .docx, .doc { background-color: #2c3e50; }
        .pdf { background-color: #e74c3c; }
        .notifications { list-style: none; padding: 0; margin-top: 15px; }
        .notifications li {
            padding: 10px; border-bottom: 1px solid #eee; color: #333;
        }
        footer {
            background-color: #2c3e50; color: white;
            text-align: center; padding: 15px 0; font-size: 14px;
            margin-top: 60px;
        }
    </style>
    
</head>
<script src="welcome_typing.js"></script>

<body>
    <div id="assistantGreeting" class="greeting-banner"></div>

    <div class="landing-wrapper">
        <h1 id="dynamicWelcome" class="typing-banner"></h1>

        <nav> 
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="_contact.php">Contact</a>
        </nav>
        <div style="position: fixed; top: 20px; right: 20px; background: #004080; padding: 12px 18px; border-radius: 8px; z-index: 1000;">
  <a href="/schools_systems_management/web/chat.html" style="color: white; text-decoration: none; font-size: 18px;">
    💬  Mwansele_GPT   A I  assistant
  </a>
</div>

        <p class="mission">Empowering students with knowledge, character, and community spirit.</p>
        <div class="highlights">
            <div class="highlight-box">
                <h3>🎓 Academic Excellence</h3>
                <p>We offer a rigorous curriculum tailored to diverse learning styles, preparing students for success in a changing world.</p>
            </div>
            <div class="highlight-box">
                <h3>🤝 Community Engagement</h3>
                <p>Through outreach and service projects, our students learn the value of giving back and making a difference.</p>
            </div>
            <div class="highlight-box">
                <h3>🎭 Holistic Development</h3>
                <p>From sports to science clubs, we nurture leadership, creativity, and teamwork beyond the classroom.</p>
            </div>
        </div>
        <a class="cta-button" href="admin_login.php">🔐 Admin Login</a>
    </div>

    <div class="widget">
        <h3>📁 Uploaded Files</h3>
        <table class="file-table">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Uploaded At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($fileResult && $fileResult->num_rows > 0): ?>
                    <?php while ($file = $fileResult->fetch_assoc()): 
                        $badgeClass = strtolower($file['file_type']);
                        $uploadedAt = date("M d, Y H:i", strtotime($file['uploaded_at']));
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($file['file_name']) ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= strtoupper($file['file_type']) ?></span></td>
                        <td><?= htmlspecialchars($file['category']) ?></td>
                        <td><?= $uploadedAt ?></td>
                        <td>
                            <?php if (file_exists($file['file_path'])): ?>
                                <a href="<?= htmlspecialchars($file['file_path']) ?>" download>Download</a>
                            <?php else: ?>
                                <span style="color:red;">Missing</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">No files uploaded yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="widget">
        <h3>📢 Latest School Notifications</h3>
        <ul class="notifications">
            <?php if ($notifResult && $notifResult->num_rows > 0): ?>
                <?php while ($row = $notifResult->fetch_assoc()): ?>
                    <li>
                        <strong><?= date("M j, g:i a", strtotime($row['created_at'])) ?>:</strong>
                        <?= make_links_clickable($row['message']) ?>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No notifications available.</li>
            <?php endif; ?>
        </ul>
    </div>

 
<script src="greeting_logic.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    injectGreeting(); // Default target is 'assistantGreeting'
  });
</script>
<div class="widget">
<button onclick="toggleRegulations()" class="cta-button">
  📘 School Rules & Regulations
</button>
<div id="regulationsNotice" class="widget" style="display: none;">
  <h3 class="medium-text">📘 School Rules & Regulations</h3>

  <p>For full details on school conduct, dress code, and academic policies, please visit the <strong>Uploaded Files</strong> section above.</p>
  <p>Look for documents labeled <em>“regulations”</em> or <em>“school_rules.pdf”</em>.</p>
  <a href="#uploaded-files" class="cta-button">📁 Go to Uploaded Files</a>
  <p><span style="font-size:1.2em;">📌</span> This document is updated by school administration. Check regularly for changes.</p>
</div>
<script>
function toggleRegulations() {
  const section = document.getElementById("regulationsNotice");
  section.style.display = section.style.display === "none" ? "block" : "none";
}
</script>

</div>
   <footer>
        &copy; <?= date("Y") ?> Mwansele High School. All rights reserved.
    </footer>

</body>
</html>
<?php $conn->close(); ?>
