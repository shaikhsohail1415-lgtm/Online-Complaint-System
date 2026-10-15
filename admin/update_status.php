<?php
session_start();

if (empty($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

require_once "../db.php";

$allowedStatuses = [
    "Pending",
    "In Progress",
    "Resolved",
    "Rejected"
];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: manage_complaints.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$status = $_POST["status"] ?? "";

if (!$id || !in_array($status, $allowedStatuses, true)) {
    exit("Invalid complaint ID or status.");
}

$stmt = $conn->prepare(
    "UPDATE complaints SET status = ? WHERE id = ?"
);
$stmt->bind_param("si", $status, $id);
$stmt->execute();
$stmt->close();

header("Location: manage_complaints.php?updated=1");
exit;
?>