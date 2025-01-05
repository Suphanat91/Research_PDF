<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];
    $presenter = $_POST['appropriateness_of_presenter'];
    $location = $_POST['appropriateness_of_location'];
    $decision = $_POST['overall_decision'];

    // ตรวจสอบว่ามีการประเมินอยู่หรือไม่
    $stmt = $pdo->prepare("SELECT * FROM committee_evaluation WHERE articles_id = ?");
    $stmt->execute([$article_id]);
    $evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($evaluation) {
        // อัปเดตข้อมูลการประเมิน
        $stmt = $pdo->prepare("
            UPDATE committee_evaluation 
            SET appropriateness_of_presenter = ?, appropriateness_of_location = ?, overall_decision = ?, updated_at = NOW()
            WHERE articles_id = ?
        ");
        $stmt->execute([$presenter, $location, $decision, $article_id]);
    } else {
        // เพิ่มข้อมูลการประเมินใหม่
        $stmt = $pdo->prepare("
            INSERT INTO committee_evaluation (appropriateness_of_presenter, appropriateness_of_location, overall_decision, articles_id, users_user_id, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$presenter, $location, $decision, $article_id, $_SESSION['user_id']]);
    }

    // Redirect ไปหน้า dashboard_admin.php พร้อมพารามิเตอร์ success
    header("Location: dashboard_admin.php?success=evaluation_updated");
    exit();
}
?>