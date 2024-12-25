<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'evaluator') {
    $articles_id = $_POST['article_id'];
    $article_score = $_POST['article_score'];
    $work_quality = $_POST['work_quality'];
    $writing_quality = $_POST['writing_quality'];
    $practical_benefit = $_POST['practical_benefit'];
    $innovation_score = $_POST['innovation_score'];
    $additional_comments = $_POST['additional_comments'];

    // Prepare SQL statement to insert evaluation
    $stmt = $pdo->prepare("
        INSERT INTO evaluations (
            articles_id, evaluator_id, article_score, work_quality, writing_quality, practical_benefit, innovation_score, additional_comments, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $evaluation_saved = $stmt->execute([
        $articles_id, $_SESSION['user_id'], $article_score, $work_quality, $writing_quality, $practical_benefit, $innovation_score, $additional_comments
    ]);

    if ($evaluation_saved) {
        // Update the article's state to 2
        $update_stmt = $pdo->prepare("UPDATE articles SET state = ? WHERE id = ?");
        $update_stmt->execute([2, $articles_id]);
        header("Location: dashboard_reviewer.php?success=1");
        exit();
    }
}

// Redirect back to the dashboard with an error if something goes wrong
header("Location: dashboard_reviewer.php?error=1");
exit();