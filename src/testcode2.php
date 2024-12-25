<?php
$title = "กรอกข้อมูล PDF";
$header = "กรอกข้อมูล PDF";

// เนื้อหาของฟอร์ม
ob_start();
?>
<style>
    body {
        font-family: 'Sarabun', sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 20px;
        color: #2c3e50;
    }

    .container {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
    }

    h1 {
        color: #234e70;
        text-align: center;
        font-size: 2.2em;
        margin-bottom: 30px;
        border-bottom: 3px solid #234e70;
        padding-bottom: 10px;
    }

    h3 {
        color: #2c3e50;
        margin: 20px 0;
        padding: 10px;
        background: #f8f9fa;
        border-left: 4px solid #234e70;
    }

    .form-section {
        background: #ffffff;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #e1e8f0;
        border-radius: 8px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        width: 100%;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #234e70;
        font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    select,
    textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s ease;
        background-color: #f8fafc;
        box-sizing: border-box;
    }

    textarea {
        grid-column: 1 / -1;
        resize: vertical;
        min-height: 100px;
    }

    select {
        cursor: pointer;
        padding-right: 30px;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23234e70' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    button {
        background-color: #234e70;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #1a3a54;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>

<body>
    <div class="container">
        <h1>แบบฟอร์มขออนุมัตินำเสนอบทความวิชาการ</h1>
        <form action="generate_pdf.php" method="post">
            <div class="form-section">
                <h3>ข้อมูลส่วนตัว</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstname">ชื่อ:</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">นามสกุล:</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="position">ตำแหน่ง:</label>
                        <input type="text" id="position" name="position" required>
                    </div>
                    <div class="form-group">
                        <label for="work_period">ระยะเวลาทำงาน:</label>
                        <input type="text" id="work_period" name="work_period" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="department">ฝ่าย:</label>
                        <input type="text" id="department" name="department" required>
                    </div>
                    <div class="form-group">
                        <label for="office">สำนัก:</label>
                        <input type="text" id="office" name="office" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">เบอร์โทรศัพท์:</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">อีเมล:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>ข้อมูลบทความ</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_author">ผู้แต่งชื่อคนแรก:</label>
                        <input type="text" id="first_author" name="first_author" required>
                    </div>
                    <div class="form-group">
                        <label for="co_authors">ผู้ประพันธ์บรรณกิจ:</label>
                        <input type="text" id="co_authors" name="co_authors" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="article_type">ประเภทของบทความ:</label>
                        <select id="article_type" name="article_type" required>
                            <option value="Geo-Information">Geo-Information</option>
                            <option value="Space Technology">Space Technology</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="presentation_type">ประเภทการนำเสนอ:</label>
                        <select id="presentation_type" name="presentation_type" required>
                            <option value="Oral Presentation">Oral Presentation</option>
                            <option value="Poster Presentation">Poster Presentation</option>
                            <option value="Online Presentation">Online Presentation</option>
                            <option value="Publication">Publication (การตีพิมพ์บทความ)</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="article_title">ชื่อบทความ:</label>
                        <input type="text" id="article_title" name="article_title" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>รายละเอียดการนำเสนอ</h3>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="conference_name">ชื่องานประชุมวิชาการ/ชื่อวารสารที่จะตีพิมพ์:</label>
                        <textarea id="conference_name" name="conference_name" required></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="location">สถานที่:</label>
                        <select id="location" name="location" required>
                            <option value="ในประเทศ">ในประเทศ</option>
                            <option value="ต่างประเทศ">ต่างประเทศ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location_text">โปรดระบุสถานที่:</label>
                        <input type="text" id="location_text" name="location_text" required>
                    </div>
                </div>
                <!-- </div> -->

                <!-- กำหนดการ -->
                <!-- <div class="form-section"> -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="submission_date">วันกำหนดการส่ง/นำเสนอผลงานวิชาการ:</label>
                        <input type="text" id="submission_date" name="submission_date" required>
                    </div>
                    <div class="form-group">
                        <label for="registration_fee">ค่าลงทะเบียน/ค่านำเสนอ/ค่าตีพิมพ์บทความ:</label>
                        <input type="text" id="registration_fee" name="registration_fee" required>
                    </div>
                </div>
                <label for="presentation_times">จำนวนครั้งในการจะนำเสนอ:</label>
                <input type="text" id="presentation_times" name="presentation_times" required>

                <label for="details">รายละเอียด:</label>
                <textarea id="details" name="details" rows="4" cols="50" required></textarea>
            </div>
            <!-- หน้าที่สอง -->
            <!-- แผนการส่งบทความ -->
            <div class="form-section">
                <label for="article_plan">แผนการส่งบทความ:</label>
                <select id="article_plan" name="article_plan" onchange="toggleOtherArticlePlanField()" required>
                    <option value="ตามแผนการดำเนินงานของสำนัก">ตามแผนการดำเนินงานของสำนัก</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>
                <div id="other_article_plan" class="hidden">
                    <label for="other_article_plan_t