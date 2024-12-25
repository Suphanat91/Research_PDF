<?php
session_start();
require 'db.php';
$title = "แบบประเมินบทความ";

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'evaluator') {
    header("Location: index.php");
    exit();
}

// ตรวจสอบว่ามี `id` ของบทความที่ส่งมา
if (!isset($_GET['id'])) {
    header("Location: dashboard_reviewer.php?error=missing_article_id");
    exit();
}

$article_id = $_GET['id'];

// ดึงข้อมูลบทความจากฐานข้อมูล
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("Location: dashboard_reviewer.php?error=article_not_found");
    exit();
}

// เริ่มต้น output ของหน้า
ob_start();
?>

<div class="form-container w-full max-w-2xl p-8 rounded-lg bg-white shadow-lg mx-auto">
    <h1 class="text-3xl font-bold text-center text-green-700 mb-6">แบบประเมินบทความ</h1>

    <form id="evaluation-form" action="submit_evaluation.php" method="POST" class="space-y-6">
        <!-- ส่ง article_id ซ่อนไว้ -->
        <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>">

        <div id="criteria-form" class="grid grid-cols-1 gap-6"></div>
        <!-- ความคิดเห็น -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <label for="additional_comments" class="block text-sm font-medium text-gray-700 mb-2">
                ความคิดเห็น:
            </label>
            <textarea id="additional_comments" name="additional_comments" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                placeholder="กรอกความคิดเห็นของคุณที่นี่"></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                ส่งแบบประเมิน
            </button>
        </div>
    </form>
</div>

<!-- Popup -->
<!-- <div id="popup-overlay" class="popup-overlay">
    <div class="popup-box">
        <h2>ยืนยันการส่งข้อมูล</h2>
        <p>กรุณาตรวจสอบข้อมูลให้ถูกต้อง<br>เนื่องจากไม่สามารถแก้ไขได้หลังจากส่ง<br>และข้อมูลจะถูกเก็บไว้ในฐานข้อมูล</p>
        <button class="popup-confirm" onclick="submitForm()">ยืนยัน</button>
        <button class="popup-cancel" onclick="closePopup()">ยกเลิก</button>
    </div>
</div> -->

<script>
    // Popup functions
    function showPopup() {
        document.getElementById("popup-overlay").style.display = "flex";
    }

    function closePopup() {
        document.getElementById("popup-overlay").style.display = "none";
    }

    function submitForm() {
        document.getElementById("evaluation-form").submit();
    }

    // Create dropdowns for evaluation
    const criteria = [{
            id: "article_score",
            text: "บทความตรงตามภารกิจของสำนักหรือ KPI ของโครงการฯ (5 คะแนน):"
        },
        {
            id: "work_quality",
            text: "คุณภาพของงาน/Contribution (5 คะแนน):"
        },
        {
            id: "writing_quality",
            text: "คุณภาพงานเขียน การใช้ภาษา ไวยากรณ์ มีความถูกต้อง (5 คะแนน):"
        },
        {
            id: "practical_benefit",
            text: "ประโยชน์และความเป็นไปได้ในการต่อยอดและการนำไปใช้งานได้จริง (5 คะแนน):"
        },
        {
            id: "innovation_score",
            text: "ความเป็นนวัตกรรม (5 คะแนน):"
        }
    ];

    const createDropdown = () => {
        const formContainer = document.getElementById("criteria-form");

        criteria.forEach(item => {
            const wrapper = document.createElement("div");
            wrapper.className = "bg-gray-50 p-4 rounded-lg";

            const label = document.createElement("label");
            label.className = "block text-sm font-medium text-gray-700 mb-2";
            label.textContent = item.text;

            const select = document.createElement("select");
            select.name = item.id;
            select.required = true;
            select.className = "w-full p-2 border rounded";

            const defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.textContent = "เลือกคะแนน";
            defaultOption.disabled = true;
            defaultOption.selected = true;
            select.appendChild(defaultOption);

            for (let i = 5; i >= 1; i--) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                select.appendChild(option);
            }

            wrapper.appendChild(label);
            wrapper.appendChild(select);
            formContainer.appendChild(wrapper);
        });
    };

    createDropdown();
</script>

<?php
$content = ob_get_clean();
include 'layout2.php';
?>