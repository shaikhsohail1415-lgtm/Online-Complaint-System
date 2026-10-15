<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, subject, category, status, created_at
     FROM complaints
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">
            Online Complaint System
        </a>
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">My Complaints</h2>

    <?php if (isset($_GET["submitted"]) && $_GET["submitted"] === "1"): ?>
        <div class="alert alert-success">
            Your complaint was submitted successfully!
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($complaint = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo (int)$complaint["id"]; ?></td>
                            <td><?php echo htmlspecialchars($complaint["subject"]); ?></td>
                            <td><?php echo htmlspecialchars($complaint["category"]); ?></td>
                            <td><?php echo htmlspecialchars($complaint["created_at"]); ?></td>
                            <td>
                                <?php
                                $status = $complaint["status"];
                                $badge = "bg-secondary";

                                if ($status === "Pending") {
                                    $badge = "bg-warning text-dark";
                                } elseif ($status === "In Progress") {
                                    $badge = "bg-info text-dark";
                                } elseif ($status === "Resolved") {
                                    $badge = "bg-success";
                                } elseif ($status === "Rejected") {
                                    $badge = "bg-danger";
                                }
                                ?>
                                <span class="badge <?php echo $badge; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            You have not submitted any complaints yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="add_complaint.php" class="btn btn-primary">
        Submit New Complaint
    </a>
    <a href="dashboard.php" class="btn btn-secondary">
        Back to Dashboard
    </a>
</div>

</body>
</html>
<?php
$stmt->close();
?>