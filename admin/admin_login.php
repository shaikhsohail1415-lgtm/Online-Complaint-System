<?php
session_start();

if (!empty($_SESSION["admin_logged_in"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // Demo credentials for this college project
    if ($username === "Sohel" && $password === "Sohel@123") {
        session_regenerate_id(true);
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_name"] = "Administrator";

        header("Location: dashboard.php");
        exit;
    }

    $error = "Invalid admin username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Admin Login</h2>

                    <?php if ($error !== ""): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                   class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            Login as Admin
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="../index.php">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>