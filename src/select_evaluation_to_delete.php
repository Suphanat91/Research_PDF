<?php
session_start();
require 'db.php';
$title = "เลือกบทความที่ต้องการลบการประเมิน";

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') {
    header("Location: index.php");
    exit();
}

// ดึงบทความที่มีการประเมินจากฐานข้อมูล
$stmt = $pdo->prepare("
    SELECT articles.id, articles.article_title, users.firstname AS author_name, evaluations.id AS evaluation_id
    FROM evaluations
    JOIN articles ON evaluations.articles_id = articles.id
    JOIN users ON articles.users_user_id = users.user_id
    ORDER BY articles.created_at DESC
");
$stmt->execute();
$evaluated_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">เลือกบทความที่ต้องการลบการประเมิน</h1>

    <?php if (empty($evaluated_articles)): ?>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
            <p class="text-gray-600">ไม่มีบทความที่ได้รับการประเมิน</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($evaluated_articles as $article): ?>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($article['article_title']); ?></h2>
                    <p class="text-gray-600">Author: <?php echo htmlspecialchars($article['author_name']); ?></p>

                    <div class="mt-4 text-right">
                        <a href="delete_evaluation.php?id=<?php echo $article['evaluation_id']; ?>"
                           class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Delete Evaluation
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">สำเร็จ!</strong>
        <span class="block sm:inline">การลบการประเมินสำเร็จแล้ว.</span>
    </div>
<?php endif; ?>
<?php
$content = ob_get_clean();
include 'layout2.php';
?>