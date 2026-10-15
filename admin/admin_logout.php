<?php
session_start();
unset($_SESSION["admin_logged_in"], $_SESSION["admin_name"]);

header("Location: admin_login.php");
exit;
?>