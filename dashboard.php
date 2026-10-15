<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Online Complaint System</span>
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h2>
            <p>You are successfully logged in.</p>
            <p>From here, you will be able to register complaints and track their status.</p>

            <a href="add_complaint.php" class="btn btn-primary">
                Submit a Complaint
            </a>

            <a href="my_complaints.php" class="btn btn-success">
                My Complaints
            </a>
        </div>
    </div>
</div>

</body>
</html>