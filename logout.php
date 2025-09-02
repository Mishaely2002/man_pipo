<?php
session_start();
session_unset();
session_destroy();
header("Location: admin_login.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
exit;
