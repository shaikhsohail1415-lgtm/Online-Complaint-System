<?php
session_start();

if (empty($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

require_once "../db.php";

$total = $conn->query("SELECT COUNT(*) AS total FROM complaints")->fetch_assoc()["total"];
$pending = $conn->query("SELECT COUNT(*) AS total FROM complaints WHERE status='Pending'")->fetch_assoc()["total"];
$progress = $conn->query("SELECT COUNT(*) AS total FROM complaints WHERE status='In Progress'")->fetch_assoc()["total"];
$resolved = $conn->query("SELECT COUNT(*) AS total FROM complaints WHERE status='Resolved'")->fetch_assoc()["total"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Complaint System - Admin</span>
        <a href="admin_logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h2>Welcome, Administrator!</h2>
    <p>Manage complaints submitted by users.</p>

    <div class="row g-3 mt-3">
        <div class="col-md-3">
            <div class="card card-body shadow-sm">
                <h6>Total Complaints</h6>
                <h2><?php echo (int)$total; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body shadow-sm">
                <h6>Pending</h6>
                <h2><?php echo (int)$pending; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body shadow-sm">
                <h6>In Progress</h6>
                <h2><?php echo (int)$progress; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body shadow-sm">
                <h6>Resolved</h6>
                <h2><?php echo (int)$resolved; ?></h2>
            </div>
        </div>
    </div>

    <a href="manage_complaints.php" class="btn btn-primary mt-4">
        Manage All Complaints
    </a>
</div>
</body>
</html>