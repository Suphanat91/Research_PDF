<?php
ob_start(); // เปิดบัฟเฟอร์เอาท์พุต
session_start();
require 'db.php';
$title = "Reviewer Dashboard";
error_reporting(0); // ปิดการแสดงผลข้อผิดพลาดทั้งหมด
ini_set('display_errors', 0); // ห้ามแสดงข้อผิดพลาดบนหน้าเว็บ

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') { // ตรวจสอบว่าเป็นผู้ตรวจสอบหรือไม่
    header("Location: index.php");
    exit();
}

$firstname = $_SESSION['firstname'] ?? 'evaluator';

// ดึงข้อมูลบทความทั้งหมด
$stmt = $pdo->prepare("
    SELECT articles.*, users.firstname AS author_name, DATE_FORMAT(articles.created_at, '%d %M %Y') as formatted_date 
    FROM articles
    JOIN users ON articles.users_user_id = users.user_id
    WHERE articles.state = 1
    ORDER BY articles.created_at DESC
");
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<!-- Header Section -->
<!-- <div class="bg-gray-50 border-b border-gray-200 py-8 px-6 mb-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif mb-2 text-gray-800">All Submitted Articles</h1>
                <p class="text-gray-600">
                    Welcome, <?php echo htmlspecialchars($firstname); ?>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Total Publications</p>
                <p class="text-3xl font-serif"><?php echo count($articles); ?></p>
            </div>
        </div>
    </div>
</div> -->

<!-- Publications List -->
<div class="mb-8">
    <h2 class="text-2xl font-serif mb-6 pb-2 border-b border-gray-200">All Research Articles</h2>

    <?php if (empty($articles)): ?>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <p class="text-gray-600 mb-4">No articles have been submitted yet.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-8">
    <?php foreach ($articles as $article): ?>
        <article class="bg-white rounded-lg border border-gray-200 hover:shadow-lg transition duration-300 overflow-hidden">
            <div class="p-8">
                <!-- Header Section -->
                <div class="flex justify-between items-start mb-6 pb-4 border-b border-gray-100">
                    <div class="flex-1">
                        <h3 class="text-2xl font-serif font-semibold mb-3 text-gray-900 leading-tight hover:text-blue-800 transition duration-200">
                            <?php echo htmlspecialchars($article['article_title']); ?>
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center px-4 py-1.5 bg-gray-50 text-gray-700 text-sm rounded-md font-serif border border-gray-200">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo htmlspecialchars($article['formatted_date']); ?>
                            </span>
                            <span class="inline-flex items-center px-4 py-1.5 bg-blue-50 text-blue-700 text-sm rounded-md font-serif border border-blue-100">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php echo htmlspecialchars($article['author_name']); ?>
                            </span>
                            <span class="inline-flex items-center px-4 py-1.5 bg-gray-50 text-gray-600 text-sm rounded-md font-serif border border-gray-200">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                ID: <?php echo $article['id']; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Abstract Section -->
                <div class="mb-6">
                    <h4 class="text-base font-semibold text-gray-700 mb-3 font-serif uppercase tracking-wider">Abstract</h4>
                    <p class="text-gray-600 leading-relaxed font-serif text-justify">
                        <?php echo htmlspecialchars(substr($article['details'], 0, 300)) . '...'; ?>
                    </p>
                </div>

                <!-- Actions Section -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <a href="generate_pdf.php?id=<?php echo $article['id']; ?>" 
                       class="inline-flex items-center text-blue-700 hover:text-blue-800 font-medium font-serif group">
                        <span>View Full Article</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <div class="flex gap-4 items-center">
                        <a href="article_evaluation_form.php?id=<?php echo $article['id']; ?>"
                           class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-md transition duration-200 font-serif">
                            <span>Evaluate Article</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include 'layout2.php';
?>