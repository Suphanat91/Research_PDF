<?php
session_start();
require 'db.php';
$title = "Admin Dashboard";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') {
    header("Location: index.php");
    exit();
}

$firstname = $_SESSION['firstname'] ?? 'evaluator';

$stmt = $pdo->prepare("
    SELECT articles.*, users.firstname AS author_name, DATE_FORMAT(articles.created_at, '%d %M %Y') as formatted_date 
    FROM articles
    JOIN users ON articles.users_user_id = users.user_id
    WHERE articles.state = 2
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
                <h1 class="text-3xl font-serif mb-2 text-gray-800">Articles Waiting for Committee Review</h1>
                <p class="text-gray-600">
                    Welcome, <?php echo htmlspecialchars($firstname); ?>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Total Articles</p>
                <p class="text-3xl font-serif"><?php echo count($articles); ?></p>
            </div>
        </div>
    </div>
</div> -->

<!-- Publications List -->
<div class="mb-8">
    <h2 class="text-2xl font-serif mb-6 pb-2 border-b border-gray-200">Articles for Committee Review</h2>

    <?php if (empty($articles)): ?>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
            <p class="text-gray-600 mb-4">No articles are pending committee review.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-8">
            <?php foreach ($articles as $article): ?>
                <article class="bg-white rounded-lg border border-gray-200 hover:shadow-lg transition duration-300 overflow-hidden">
                    <div class="p-8">
                        <!-- Header Section -->
                        <div class="flex justify-between items-start mb-6 pb-4 border-b border-gray-100">
                            <div class="flex-1">
                                <h3 class="text-2xl font-serif font-semibold mb-3 text-gray-900 leading-tight">
                                    <?php echo htmlspecialchars($article['article_title']); ?>
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    <span class="inline-flex items-center px-4 py-1.5 bg-gray-50 text-gray-700 text-sm rounded-md font-serif">
                                        <?php echo htmlspecialchars($article['formatted_date']); ?>
                                    </span>
                                    <span class="inline-flex items-center px-4 py-1.5 bg-blue-50 text-blue-700 text-sm rounded-md font-serif">
                                        Author: <?php echo htmlspecialchars($article['author_name']); ?>
                                    </span>
                                    <span class="inline-flex items-center px-4 py-1.5 bg-gray-50 text-gray-600 text-sm rounded-md font-serif">
                                        ID: <?php echo $article['id']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Actions Section -->
                        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 pt-4 border-t border-gray-100">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="generate_pdf.php?id=<?php echo $article['id']; ?>"
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg font-medium transition duration-200 group">
                                    <svg class="w-5 h-5 mr-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    View Full Article
                                </a>
                                <a href="generate_evaluation_pdf.php?id=<?php echo $article['id']; ?>"
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-purple-600 hover:text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg font-medium transition duration-200 group">
                                    <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    View Evaluation
                                </a>
                                <a href="edit_evaluation.php?id=<?php echo $article['id']; ?>"
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-yellow-600 hover:text-yellow-700 bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 rounded-lg font-medium transition duration-200 group">
                                    <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 114.243 4.243L8.475 20.475a3 3 0 01-1.414.829l-4.242.848a1 1 0 01-1.2-1.2l.848-4.242a3 3 0 01.829-1.414L15.232 5.232z"></path>
                                    </svg>
                                    Edit Article
                                </a>
                                <a href="select_evaluation_to_delete.php"
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg font-medium transition duration-200">
                                    <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L3 21m0 0h7m-7 0v-7m9-5H4a2 2 0 00-2 2v12a2 2h12a2 2 0 002-2v-5"></path>
                                    </svg>
                                    Delete Evaluations
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