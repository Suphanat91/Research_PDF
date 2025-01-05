<?php
session_start();
require 'db.php';

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') {
    header("Location: index.php");
    exit();
}

// รับ ID การประเมินที่ต้องการลบ
$evaluation_id = $_GET['id'] ?? null;
if (!$evaluation_id) {
    header("Location: select_evaluation_to_delete.php?error=missing_evaluation_id");
    exit();
}

// ดึง `articles_id` จากตาราง `evaluations` ก่อนลบ
$stmt = $pdo->prepare("SELECT articles_id FROM evaluations WHERE id = ?");
$stmt->execute([$evaluation_id]);
$evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$evaluation) {
    header("Location: select_evaluation_to_delete.php?error=evaluation_not_found");
    exit();
}

$articles_id = $evaluation['articles_id'];

// ลบข้อมูลการประเมินจากตาราง `evaluations`
$stmt = $pdo->prepare("DELETE FROM evaluations WHERE id = ?");
$stmt->execute([$evaluation_id]);

// อัปเดต `state` ของบทความในตาราง `articles` เป็น `1`
$update_stmt = $pdo->prepare("UPDATE articles SET state = 1 WHERE id = ?");
$update_stmt->execute([$articles_id]);

// กลับไปยังหน้าการเลือกบทความ
header("Location: select_evaluation_to_delete.php?success=deleted");
exit();
?>