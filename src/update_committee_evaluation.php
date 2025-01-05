<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];
    $presenter = $_POST['appropriateness_of_presenter'];
    $location = $_POST['appropriateness_of_location'];
    $decision = $_POST['overall_decision'];

    $stmt = $pdo->prepare("
        UPDATE evaluations 
        SET appropriateness_of_presenter = ?, appropriateness_of_location = ?, overall_decision = ?, updated_at = NOW()
        WHERE articles_id = ?
    ");
    $stmt->execute([$presenter, $location, $decision, $article_id]);

    header("Location: dashboard_admin.php?success=updated");
    exit();
}
?>