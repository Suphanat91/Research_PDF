<?php
session_start();
require 'db.php';
$title = "แก้ไขคะแนนการประเมินบทความ";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard_reviewer.php?error=missing_article_id");
    exit();
}

$article_id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT evaluations.*, articles.article_title 
    FROM evaluations
    JOIN articles ON evaluations.articles_id = articles.id
    WHERE evaluations.articles_id = ?
");
$stmt->execute([$article_id]);
$evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$evaluation) {
    header("Location: dashboard_reviewer.php?error=evaluation_not_found");
    exit();
}

ob_start();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .form-container {
            background: linear-gradient(to bottom, #ffffff, #f8fafc);
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        .criteria-item {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        .criteria-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232563eb'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            appearance: none;
        }
        textarea:focus, select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="form-container w-full max-w-3xl p-8 rounded-xl bg-white shadow-lg mx-auto my-8">
        <div class="border-b-4 border-blue-600 pb-4 mb-8">
            <h1 class="text-3xl font-bold text-center text-blue-800 mb-4">แก้ไขคะแนนการประเมินบทความ</h1>
            <h2 class="text-xl text-center text-gray-700">บทความ: <?php echo htmlspecialchars($evaluation['article_title']); ?></h2>
        </div>

        <form id="edit-evaluation-form" action="update_evaluation.php" method="POST" class="space-y-8">
            <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>">

            <div class="grid grid-cols-1 gap-6">
                <?php
                $criteria = [
                    'article_score' => 'บทความตรงตามภารกิจของสำนักหรือ KPI ของโครงการฯ (5 คะแนน):',
                    'work_quality' => 'คุณภาพของงาน/Contribution (5 คะแนน):',
                    'writing_quality' => 'คุณภาพงานเขียน การใช้ภาษา ไวยากรณ์ มีความถูกต้อง (5 คะแนน):',
                    'practical_benefit' => 'ประโยชน์และความเป็นไปได้ในการต่อยอดและการนำไปใช้งานได้จริง (5 คะแนน):',
                    'innovation_score' => 'ความเป็นนวัตกรรม (5 คะแนน):'
                ];

                foreach ($criteria as $key => $label) {
                    $current_value = $evaluation[$key] ?? '';
                    echo '<div class="criteria-item p-5 rounded-lg">';
                    echo '<label class="block text-sm font-semibold text-blue-900 mb-3">' . htmlspecialchars($label) . '</label>';
                    echo '<select name="' . $key . '" required class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">';
                    echo '<option value="" disabled ' . ($current_value === '' ? 'selected' : '') . '>เลือกคะแนน</option>';
                    for ($i = 5; $i >= 1; $i--) {
                        $selected = $current_value == $i ? 'selected' : '';
                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . ' คะแนน</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="criteria-item p-5 rounded-lg mt-6">
                <label for="additional_comments" class="block text-sm font-semibold text-blue-900 mb-3">ความคิดเห็นเพิ่มเติม:</label>
                <textarea id="additional_comments" name="additional_comments" rows="5"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="กรุณาแสดงความคิดเห็นของท่านที่นี่..."><?php echo htmlspecialchars($evaluation['additional_comments']); ?></textarea>
            </div>

            <div class="text-center pt-6">
                <button type="submit" 
                    class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:-translate-y-1">
                    บันทึกการประเมิน
                </button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$content = ob_get_clean();
include 'layout2.php';
?>