<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard_admin.php?error=missing_article_id");
    exit();
}

$article_id = $_GET['id'];

// Update state to 2 in articles table
$stmt = $pdo->prepare("UPDATE articles SET state = 2 WHERE id = ?");
$stmt->execute([$article_id]);

header("Location: dashboard_admin.php?success=article_deleted");
exit();
?>