<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบประเมินบทความ</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .form-container {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* สไตล์สำหรับป็อปอัพ */
        /* ป็อปอัพซ่อนอยู่ตอนโหลด */
        .popup-overlay {
            display: none;
            /* ซ่อนป็อปอัพเริ่มต้น */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .popup-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .popup-box h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #333;
        }

        .popup-box p {
            font-size: 1rem;
            margin-bottom: 20px;
            color: #555;
        }

        .popup-box button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin: 0 10px;
        }

        .popup-confirm {
            background-color: #28a745;
            color: white;
        }

        .popup-cancel {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="form-container w-full max-w-2xl p-8 rounded-lg bg-white shadow-lg">
        <h1 class="text-3xl font-bold text-center text-green-700 mb-6">แบบประเมินบทความ</h1>

        <form id="evaluation-form" action="generate_evaluation_pdf.php" method="POST" class="space-y-6">
            <div id="criteria-form" class="grid grid-cols-1 gap-6"></div>
            <!-- หัวข้อ ความคิดเห็น -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <label for="additional_comments" class="block text-sm font-medium text-gray-700 mb-2">
                    ความคิดเห็น:
                </label>
                <textarea id="additional_comments" name="additional_comments" rows="4" cols="50"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                    placeholder="กรอกความคิดเห็นของคุณที่นี่"></textarea>
            </div>
            <div class="text-center">
                <button type="button" onclick="showPopup()"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                    สร้าง PDF
                </button>
            </div>
        </form>
    </div>

    <!-- ป็อปอัพ -->
    <div id="popup-overlay" class="popup-overlay">
        <div class="popup-box">
            <h2>ยืนยันการส่งข้อมูล</h2>
            <p>กรุณาตรวจสอบข้อมูลให้ถูกต้อง<br>เนื่องจากไม่สามารถแก้ไขได้หลังจากสร้าง PDF<br>และข้อมูลจะถูกเก็บไว้ในฐานข้อมูล</p>
            <button class="popup-confirm" onclick="submitForm()">ยืนยัน</button>
            <button class="popup-cancel" onclick="closePopup()">ยกเลิก</button>
        </div>
    </div>

    <script>
        // ฟังก์ชันแสดงป็อปอัพ
        function showPopup() {
            document.getElementById("popup-overlay").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("popup-overlay").style.display = "none";
        }

        function submitForm() {
            document.getElementById("evaluation-form").submit();
        }

        // สร้าง Dropdown ตามเกณฑ์
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
</body>

</html>