<?php
session_start();

if (empty($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

require_once "../db.php";

$sql = "SELECT c.id, c.subject, c.category, c.description,
               c.status, c.created_at, u.name, u.email
        FROM complaints c
        JOIN users u ON c.user_id = u.id
        ORDER BY c.created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4 mb-5">
    <h2>Manage All Complaints</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Dashboard</a>

    <?php if (isset($_GET["updated"])): ?>
        <div class="alert alert-success">Complaint status updated successfully.</div>
    <?php endif; ?>

    <?php while ($c = $result->fetch_assoc()): ?>
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5>
                    Complaint #<?php echo (int)$c["id"]; ?>:
                    <?php echo htmlspecialchars($c["subject"]); ?>
                </h5>

                <p><strong>User:</strong>
                    <?php echo htmlspecialchars($c["name"]); ?>
                    (<?php echo htmlspecialchars($c["email"]); ?>)
                </p>

                <p><strong>Category:</strong>
                    <?php echo htmlspecialchars($c["category"]); ?>
                </p>

                <p><strong>Description:</strong><br>
                    <?php echo nl2br(htmlspecialchars($c["description"])); ?>
                </p>

                <p><strong>Submitted:</strong>
                    <?php echo htmlspecialchars($c["created_at"]); ?>
                </p>

                <p><strong>Current Status:</strong>
                    <?php echo htmlspecialchars($c["status"]); ?>
                </p>

                <form method="POST" action="update_status.php"
                      class="d-flex gap-2 flex-wrap">
                    <input type="hidden" name="id"
                           value="<?php echo (int)$c["id"]; ?>">

                    <select name="status" class="form-select"
                            style="max-width:220px" required>
                        <?php foreach (["Pending", "In Progress", "Resolved", "Rejected"] as $status): ?>
                            <option value="<?php echo $status; ?>"
                                <?php echo $c["status"] === $status ? "selected" : ""; ?>>
                                <?php echo $status; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>

    <?php if ($result->num_rows === 0): ?>
        <p>No complaints have been submitted yet.</p>
    <?php endif; ?>
</div>
</body>
</html>