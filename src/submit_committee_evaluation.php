<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    $article_id = $_POST['article_id'];
    $appropriateness_of_presenter = $_POST['appropriateness_of_presenter'];
    $appropriateness_of_location = $_POST['appropriateness_of_location'];
    $overall_decision = $_POST['overall_decision'];
    $user_id = $_SESSION['user_id'];

    // Insert committee evaluation
    $stmt = $pdo->prepare("
        INSERT INTO committee_evaluation 
        (appropriateness_of_presenter, appropriateness_of_location, overall_decision, articles_id, users_user_id, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $evaluation_saved = $stmt->execute([
        $appropriateness_of_presenter, $appropriateness_of_location, $overall_decision, $article_id, $user_id
    ]);

    if ($evaluation_saved) {
        // Update state to 3 in articles table
        $update_stmt = $pdo->prepare("UPDATE articles SET state = 3 WHERE id = ?");
        $update_stmt->execute([$article_id]);

        header("Location: dashboard_admin.php?success=1");
        exit();
    }
}

header("Location: dashboard_admin.php?error=1");
exit();
?>