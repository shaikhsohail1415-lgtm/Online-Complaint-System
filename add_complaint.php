<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";
$success = false;

$categories = [
    "Technical Issue",
    "Service Issue",
    "Billing Issue",
    "Product Issue",
    "Other"
];

$subject = "";
$category = "";
$description = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = trim($_POST["subject"] ?? "");
    $category = $_POST["category"] ?? "";
    $description = trim($_POST["description"] ?? "");

    if ($subject === "" || $category === "" || $description === "") {
        $message = "Please fill in all fields.";
    } elseif (strlen($subject) > 200) {
        $message = "Subject must not exceed 200 characters.";
    } elseif (!in_array($category, $categories, true)) {
        $message = "Please select a valid category.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO complaints (user_id, subject, category, description)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "isss",
            $_SESSION["user_id"],
            $subject,
            $category,
            $description
        );

        if ($stmt->execute()) {
            header("Location: my_complaints.php?submitted=1");
            exit;
        } else {
            $message = "Could not submit your complaint. Please try again.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submit a Complaint</title>
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

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Submit a Complaint</h2>

                    <?php if ($message !== ""): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="add_complaint.php">
                        <div class="mb-3">
                            <label class="form-label">Complaint Subject</label>
                            <input type="text" name="subject"
                                   class="form-control"
                                   maxlength="200"
                                   value="<?php echo htmlspecialchars($subject); ?>"
                                   placeholder="Enter complaint subject" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Complaint Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $item): ?>
                                    <option value="<?php echo htmlspecialchars($item); ?>"
                                        <?php echo $category === $item ? "selected" : ""; ?>>
                                        <?php echo htmlspecialchars($item); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Complaint Description</label>
                            <textarea name="description" class="form-control"
                                      rows="5"
                                      placeholder="Explain your problem in detail"
                                      required><?php echo htmlspecialchars($description); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Submit Complaint
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="dashboard.php">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>