<?php
session_start();
require 'db.php';
$title = "Academic Dashboard";
// $header = "แบบฟอร์มขออนุมัตินำเสนอบทความวิชาการ";
error_reporting(0); // ปิดการแสดงผลข้อผิดพลาดทั้งหมด
ini_set('display_errors', 0); // ห้ามแสดงข้อผิดพลาดบนหน้าเว็บ
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'] ?? 'Guest';

// ดึงข้อมูลบทความจากตารางที่มีอยู่
$stmt = $pdo->prepare("
    SELECT *, DATE_FORMAT(created_at, '%d %M %Y') as formatted_date 
    FROM articles 
    WHERE users_user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<!-- Header Section -->
<div class="bg-gray-50 border-b border-gray-200 py-8 px-6 mb-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif mb-2 text-gray-800">Academic Publications</h1>
                <p class="text-gray-600">
                    <?php echo htmlspecialchars($firstname); ?>'s Research Repository
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Total Publications</p>
                <p class="text-3xl font-serif"><?php echo count($articles); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-8">
    <div class="flex flex-wrap gap-4">
        <a href="create-article.php" class="inline-flex items-center px-6 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Submit New Publication
        </a>
    </div>
</div>

<!-- Publications List -->
<div class="mb-8">
    <h2 class="text-2xl font-serif mb-6 pb-2 border-b border-gray-200">Research Archive</h2>

    <?php if (empty($articles)): ?>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <p class="text-gray-600 mb-4">Your academic repository is currently empty</p>
            <a href="create-article.php" class="inline-flex items-center px-6 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded transition duration-200">
                Submit Your First Publication
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($articles as $article): ?>
                <article class="bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition duration-200">
                    <div class="p-6">
                        <!-- Publication Title and Meta -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-serif mb-2 text-gray-800">
                                    <?php echo htmlspecialchars($article['article_title']); ?>
                                </h3>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-full font-serif">
                                        Published: <?php echo htmlspecialchars($article['formatted_date']); ?>
                                    </span>
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-sm rounded-full font-serif">
                                        Research Article
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="edit-article.php?id=<?php echo $article['id']; ?>"
                                    class="text-gray-400 hover:text-gray-600 p-2"
                                    title="Edit Publication">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Abstract -->
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-500 mb-2 font-serif">Abstract</h4>
                            <p class="text-gray-600 leading-relaxed font-serif">
                                <?php echo htmlspecialchars(substr($article['details'], 0, 300)) . '...'; ?>
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <a href="generate_pdf.php?id=<?php echo $article['id']; ?>"
                                class="text-blue-700 hover:text-blue-800 font-medium inline-flex items-center font-serif">
                                View Full Publication
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <span class="text-sm text-gray-500 font-serif">ID: <?php echo $article['id']; ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>