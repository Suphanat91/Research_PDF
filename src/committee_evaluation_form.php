<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard_admin.php?error=missing_article_id");
    exit();
}

$article_id = $_GET['id'];
$title = "Committee Evaluation Form";

// Fetch article details
$stmt = $pdo->prepare("SELECT article_title, created_at FROM articles WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

ob_start();
?>

<!-- Gradient Background -->
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12 px-4 sm:px-6">
    <!-- Main Container -->
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-8 border border-gray-100">
            <div class="text-center">
                <h1 class="text-2xl font-serif text-gray-800 mb-3">Committee Evaluation Form</h1>
                <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
                <?php if ($article): ?>
                    <div class="inline-flex items-center justify-center space-x-2 text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Manuscript ID: <?php echo htmlspecialchars($article_id); ?></span>
                    </div>
                    <h2 class="mt-4 text-lg font-medium text-gray-700 max-w-2xl mx-auto">
                        <?php echo htmlspecialchars($article['article_title']); ?>
                    </h2>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100">
            <form id="evaluation-form" action="submit_committee_evaluation.php" method="POST">
                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>">

                <!-- Form Content -->
                <div class="p-8">
                    <!-- Appropriateness Section -->
                    <div class="mb-10">
                        <h2 class="text-xl font-serif text-gray-800 mb-6 pb-2 border-b border-gray-200">
                            Presenter and Location Assessment
                        </h2>
                        
                        <!-- Presenter -->
                        <div class="mb-8">
                            <label for="appropriateness_of_presenter" class="block text-sm font-medium text-gray-700 mb-3">
                                1. Appropriateness of Presenter
                            </label>
                            <div class="relative">
                                <select id="appropriateness_of_presenter" name="appropriateness_of_presenter" required 
                                        class="appearance-none block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">-- Please select an option --</option>
                                    <option value="เหมาะสม">เหมาะสม</option>
                                    <option value="ไม่เหมาะสม">ไม่เหมาะสม</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="appropriateness_of_location" class="block text-sm font-medium text-gray-700 mb-3">
                                2. Appropriateness of Location
                            </label>
                            <div class="relative">
                                <select id="appropriateness_of_location" name="appropriateness_of_location" required 
                                        class="appearance-none block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">-- Please select an option --</option>
                                    <option value="เหมาะสม">เหมาะสม</option>
                                    <option value="ไม่เหมาะสม">ไม่เหมาะสม</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Overall Decision Section -->
                    <div class="mb-10">
                        <h2 class="text-xl font-serif text-gray-800 mb-6 pb-2 border-b border-gray-200">
                            Final Decision
                        </h2>
                        <div>
                            <label for="overall_decision" class="block text-sm font-medium text-gray-700 mb-3">
                                3. Overall Committee Decision
                            </label>
                            <div class="relative">
                                <select id="overall_decision" name="overall_decision" required 
                                        class="appearance-none block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">-- Please select an option --</option>
                                    <option value="เห็นชอบ">เห็นชอบ</option>
                                    <option value="ไม่เห็นชอบ">ไม่เห็นชอบ</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-6 bg-gray-50 rounded-b-xl border-t border-gray-100">
                    <div class="flex justify-end space-x-4">
                        <a href="dashboard_admin.php" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Submit Evaluation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout3.php';
?>