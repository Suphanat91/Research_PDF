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

// Fetch article details and existing committee evaluation
$stmt = $pdo->prepare("
    SELECT a.article_title, a.created_at, 
           ce.appropriateness_of_presenter, ce.appropriateness_of_location, ce.overall_decision
    FROM articles a
    LEFT JOIN committee_evaluation ce ON a.id = ce.articles_id
    WHERE a.id = ?
");
$stmt->execute([$article_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header("Location: dashboard_admin.php?error=article_not_found");
    exit();
}

ob_start();
?>

<!-- Gradient Background -->
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-8 border border-gray-100">
            <div class="text-center">
                <h1 class="text-2xl font-serif text-gray-800 mb-3">Committee Evaluation Form</h1>
                <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
                <div class="inline-flex items-center justify-center space-x-2 text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-full">
                    <span>Manuscript ID: <?php echo htmlspecialchars($article_id); ?></span>
                </div>
                <h2 class="mt-4 text-lg font-medium text-gray-700 max-w-2xl mx-auto">
                    <?php echo htmlspecialchars($data['article_title']); ?>
                </h2>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100">
            <form id="evaluation-form" action="submit_committee_evaluation.php" method="POST">
                <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>">

                <!-- Form Content -->
                <div class="p-8">
                    <!-- Appropriateness of Presenter -->
                    <div class="mb-8">
                        <label for="appropriateness_of_presenter" class="block text-sm font-medium text-gray-700 mb-3">
                            Appropriateness of Presenter
                        </label>
                        <select id="appropriateness_of_presenter" name="appropriateness_of_presenter" required 
                                class="appearance-none block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">-- Please select an option --</option>
                            <option value="เหมาะสม" <?php echo $data['appropriateness_of_presenter'] === 'เหมาะสม' ? 'selected' : ''; ?>>เหมาะสม</option>
                            <option value="ไม่เหมาะสม" <?php echo $data['appropriateness_of_presenter'] === 'ไม่เหมาะสม' ? 'selected' : ''; ?>>ไม่เหมาะสม</option>
                        </select>
                    </div>

                    <!-- Appropriateness of Location -->
                    <div class="mb-8">
                        <label for="appropriateness_of_location" class="block text-sm font-medium text-gray-700 mb-3">
                            Appropriateness of Location
                        </label>
                        <select id="appropriateness_of_location" name="appropriateness_of_location" required 
                                class="appearance-none block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">-- Please select an option --</option>
                            <option value="เหมาะสม" <?php echo $data['appropriateness_of_location'] === 'เหมาะสม' ? 'selected' : ''; ?>>เหมาะสม</option>
                            <option value="ไม่เหมาะสม" <?php echo $data['appropriateness_of_location'] === 'ไม่เหมาะสม' ? 'selected' : ''; ?>>ไม่เหมาะสม</option>
                        </select>
                    </div>

                    <!-- Overall Decision -->
                    <div class="mb-8">
                        <label for="overall_decision" class="block text-sm font-medium text-gray-700 mb-3">
                            Overall Committee Decision
                        </label>
                        <select id="overall_decision" name="overall_decision" required 
                                class="appearance-none block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">-- Please select an option --</option>
                            <option value="เห็นชอบ" <?php echo $data['overall_decision'] === 'เห็นชอบ' ? 'selected' : ''; ?>>เห็นชอบ</option>
                            <option value="ไม่เห็นชอบ" <?php echo $data['overall_decision'] === 'ไม่เห็นชอบ' ? 'selected' : ''; ?>>ไม่เห็นชอบ</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-6 bg-gray-50 rounded-b-xl border-t border-gray-100">
                    <div class="flex justify-end space-x-4">
                        <a href="dashboard_admin.php" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
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