<?php
session_start();
require 'db.php';

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];
    $article_score = $_POST['article_score'];
    $work_quality = $_POST['work_quality'];
    $writing_quality = $_POST['writing_quality'];
    $practical_benefit = $_POST['practical_benefit'];
    $innovation_score = $_POST['innovation_score'];
    $additional_comments = $_POST['additional_comments'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $stmt = $pdo->prepare("
        UPDATE evaluations 
        SET article_score = ?, work_quality = ?, writing_quality = ?, practical_benefit = ?, innovation_score = ?, additional_comments = ?, updated_at = NOW()
        WHERE articles_id = ?
    ");
    $stmt->execute([$article_score, $work_quality, $writing_quality, $practical_benefit, $innovation_score, $additional_comments, $article_id]);

    // กลับไปยังหน้าแดชบอร์ด
    header("Location: dashboard_reviewer.php?success=updated");
    exit();
} else {
    header("Location: dashboard_reviewer.php?error=invalid_request");
    exit();
}
?>