<?php
require 'auth.php';

// บังคับให้ล็อกอินก่อนเข้าถึงหน้า
require_login();

// echo "ยินดีต้อนรับสู่ Dashboard, คุณ " . $_SESSION['firstname'];
$title = "แบบฟอร์มขออนุมัตินำเสนอบทความวิชาการ PDF";
$header = "แบบฟอร์มขออนุมัตินำเสนอบทความวิชาการ";

// เนื้อหาของฟอร์ม
ob_start();
?>


<style>
    .hidden {
        display: none;
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
        font-family: 'Sarabun', sans-serif;
        font-size: 18px;
        color: #234e70;
        margin: 20px 0;
        padding: 10px;
        background: rgb(246, 248, 248);
        border-left: 4px solid #234e70;
        font-weight: 330;
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

    label {
        display: block;
        margin-bottom: 8px;
        color: #234e70;
        font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
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


    body {
        font-family: 'Sarabun', sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        /* ลบ margin ทั้งหมด */
        padding: 0;
        /* ลบ padding ทั้งหมด */
        padding: 20px;
        color: #2c3e50;
    }

    .container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
        margin-top: 0;
    }
</style>

</head>

<body>

    <div class="container">
        <h1>แบบฟอร์มการส่งผลงานวิชาการ</h1>
        <!-- <form action="generate_pdf.php" method="post"> -->
        <form action="submit_form.php" method="post">
            <!-- รายละเอียดของผู้เสนอผลงานวิชาการ -->
            <div class="form-section">
                <h3>รายละเอียดของผู้เสนอผลงานวิชาการ</h3>
                <div class="form-row">
                    <div>
                        <label for="firstname">ชื่อ:</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>
                    <div>
                        <label for="lastname">นามสกุล:</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="position">ตำแหน่ง:</label>
                        <input type="text" id="position" name="position" required>
                    </div>
                    <div>
                        <label for="work_period">ระยะเวลาทำงาน(ปี):</label>
                        <input type="number" id="work_period" name="work_period" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="department">ฝ่าย:</label>
                        <input type="text" id="department" name="department" required>
                    </div>
                    <div>
                        <label for="office">สำนัก:</label>
                        <input type="text" id="office" name="office" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="phone">เบอร์โทรศัพท์:</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <div>
                        <label for="email">อีเมล:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
            </div>

            <!-- รายละเอียดของบทความที่จะเสนอ -->
            <div class="form-section">
                <h3>รายละเอียดของบทความที่จะเสนอ</h3>
                <div class="form-row">
                    <div>
                        <label for="article_title">ชื่อบทความ:</label>
                        <input type="text" id="article_title" name="article_title" required>
                    </div>
                    <div>
                        <label for="first_author">ผู้แต่งชื่อคนแรก:</label>
                        <input type="text" id="first_author" name="first_author" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="co_authors">ผู้ประพันธ์บรรณกิจ:</label>
                        <input type="text" id="co_authors" name="co_authors" required>
                    </div>
                    <div>
                        <label for="article_type">ประเภทของบทความ:</label>
                        <select id="article_type" name="article_type" onchange="toggleOtherArticleField()" required>
                            <option value="Geo-Information">Geo-Information</option>
                            <option value="Space Technology">Space Technology</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>
                </div>
                <div id="other_article_type" style="display: none;">
                    <label for="other_type">โปรดระบุ:</label>
                    <input type="text" id="other_type" name="other_type">
                </div>
                <div class="form-row">
                    <div>
                        <label for="presentation_type">ประเภท:</label>
                        <select id="presentation_type" name="presentation_type" onchange="toggleOtherPresentationField()" required>
                            <option value="Oral Presentation">Oral Presentation</option>
                            <option value="Poster Presentation">Poster Presentation</option>
                            <option value="Online Presentation">Online Presentation</option>
                            <option value="Publication">Publication (การตีพิมพ์บทความ)</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>

                        <div id="other_presentation_type" style="display: none;">
                            <label for="other_presentation">โปรดระบุ:</label>
                            <input type="text" id="other_presentation" name="other_presentation">
                        </div>
                    </div>
                    <div>
                        <label for="conference_name">ชื่องานประชุมวิชาการ/ชื่อวารสารที่จะตีพิมพ์:</label>
                        <input type="text" id="conference_name" name="conference_name" rows="4" cols="50" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="location">สถานที่:</label>
                        <select id="location" name="location" required>
                            <option value="ในประเทศ">ในประเทศ</option>
                            <option value="ต่างประเทศ">ต่างประเทศ</option>
                        </select>
                    </div>
                    <div>
                        <label for="location_text">โปรดระบุสถานที่:</label>
                        <input type="text" id="location_text" name="location_text" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="submission_date">วันกำหนดการส่ง/นำเสนอผลงานวิชาการ:</label>
                        <input type="text" id="submission_date" name="submission_date" required>
                    </div>
                    <div>
                        <label for="registration_fee">ค่าลงทะเบียน/ค่านำเสนอ/ค่าตีพิมพ์บทความ:</label>
                        <input type="number" id="registration_fee" name="registration_fee" required>
                    </div>
                </div>
            </div>


            <!--  แผนการนำเสนอผลงานวิชาการ)-->
            <div class="form-section">
                <h3>แผนการนำเสนอผลงานวิชาการ</h3>
                <label for="presentation_times">จำนวนครั้งในการจะนำเสนอ:</label>
                <input type="number" id="presentation_times" name="presentation_times" required>


                <label for="details">รายละเอียด:</label>
                <textarea id="details" name="details" rows="4" cols="50" required></textarea>



                <label for="article_plan">แผนการส่งบทความ:</label>
                <select id="article_plan" name="article_plan" onchange="toggleOtherArticlePlanField()" required>
                    <option value="ตามแผนการดำเนินงานของสำนัก">ตามแผนการดำเนินงานของสำนัก</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>
                <div id="other_article_plan" class="hidden">
                    <label for="other_article_plan_text">โปรดระบุ:</label>
                    <input type="text" id="other_article_plan_text" name="other_article_plan_text">
                </div>

                <!-- <div class="form-section"> -->
                <!-- <div> -->
                <label for="budget_source">แหล่งงบประมาณในการเสนอผลงาน:</label>
                <input id="budget_source" type="text" name="budget_source" rows="4" required>
                <!-- </div> -->

                <!-- ระบุรายละเอียดการเสนอผลงานในช่วง 3 ปีที่ผ่านมา -->
                <!-- <div class="form-section"> -->
                <label for="past_presentation">ระบุรายละเอียดการเสนอผลงานในช่วง 3 ปีที่ผ่านมา:</label>
                <select id="past_presentation" name="past_presentation" onchange="togglePastPresentationField()" required>
                    <option value="ไม่เคยเสนอ">ไม่เคยเสนอ</option>
                    <option value="เคยเสนอ">เคยเสนอ</option>
                </select>
                <div id="past_presentation_details" class="hidden">
                    <label for="past_presentation_text">โปรดระบุ:</label>
                    <textarea id="past_presentation_text" name="past_presentation_text" rows="4"></textarea>
                </div>
            </div>

            <!-- จุดประสงค์การนำเสนอผลงานวิชาการ -->
            <div class="form-section">
                <h3>จุดประสงค์การนำเสนอผลงานวิชาการ</h3>
                <label for="presentation_purpose">จุดประสงค์การนำเสนอผลงานวิชาการ:</label>
                <select id="presentation_purpose" name="presentation_purpose" onchange="updatePurposeFields()" required>
                    <option value="สงป">สงป</option>
                    <option value="อว">อว</option>
                    <option value="กพร">กพร</option>
                    <option value="ยุทธศาสตร์">ยุทธศาสตร์</option>
                    <option value="โครงการที่ได้รับทุนสนับสนุน">โครงการที่ได้รับทุนสนับสนุน</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>

                <!-- ช่องกรอกเมื่อเลือก "อื่นๆ" -->
                <div id="other_purpose_field" style="display: none;">
                    <label for="purpose_text">โปรดระบุจุดประสงค์อื่นๆ:</label>
                    <input type="text" id="purpose_text" name="purpose_text" placeholder="กรอกจุดประสงค์ของคุณ">
                </div>

                <!-- Dropdown สำหรับโครงการที่ได้รับทุนสนับสนุน -->
                <div id="sub_purpose" style="display: none;">
                    <label for="sub_purpose_select">เลือกประเภทโครงการ:</label>
                    <select id="sub_purpose_select" name="sub_purpose_select" onchange="toggleForeignPurposeField()">
                        <option value="">กรุณาเลือก</option>
                        <option value="ในประเทศ">ในประเทศ</option>
                        <option value="ต่างประเทศ">ต่างประเทศ</option>
                    </select>
                </div>

                <!-- ช่องกรอกเมื่อเลือก "ต่างประเทศ" -->
                <div id="foreign_purpose" style="display: none;">
                    <label for="foreign_purpose_text">โปรดระบุประเทศ:</label>
                    <input type="text" id="foreign_purpose_text" name="foreign_purpose_text" placeholder="กรอกชื่อประเทศ">
                </div>
                <!-- </div> -->
                <!-- </div> -->
                <label for="benefit_of_use">ประโยชน์ของการนำไปใช้:</label>
                <textarea id="benefit_of_use" name="benefit_of_use" rows="4" cols="50" required></textarea>

                <label for="attached_documents">สิ่งที่ส่งมาด้วย:</label>
                <select id="attached_documents" name="attached_documents" onchange="toggleOtherAttachedDocumentsField()" required>
                    <option value="abstract">Abstract</option>
                    <option value="fullpaper">Fullpaper</option>
                    <option value="powerpoint">Power Point</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>

                <div id="other_attached_documents_field" style="display: none;">
                    <label for="other_attached_documents_text">โปรดระบุ:</label>
                    <input type="text" id="other_attached_documents_text" name="other_attached_documents_text">
                </div>
                <label for="notes">หมายเหตุ:</label>
                <textarea id="notes" name="notes" rows="4" cols="50" required></textarea>

            </div>

            <div class="form-section">
                <!-- หัวข้อ ผู้อำนวยการสำนัก -->
                <h3>ความเห็นของผู้บังคับบัญชาและผู้เกี่ยวข้อง</h3>
                <label for="director_approval">ผู้อำนวยการสำนัก:</label>
                <select id="director_approval" name="director_approval" onchange="toggleDirectorReasonField()" required>
                    <option value="เห็นชอบ">เห็นชอบ</option>
                    <option value="ไม่เห็นชอบ">ไม่เห็นชอบ</option>
                </select>

                <div id="director_reason_field" style="display: none;">
                    <label for="director_reason">โปรดระบุเหตุผล:</label>
                    <textarea id="director_reason" name="director_reason" rows="4" cols="50"></textarea>
                </div>

                <!-- หัวข้อ ผู้จัดการโครงการ -->
                <label for="project_manager_approval">ผู้จัดการโครงการ:</label>
                <select id="project_manager_approval" name="project_manager_approval" onchange="toggleProjectManagerReasonField()" required>
                    <option value="เห็นชอบ">เห็นชอบ</option>
                    <option value="ไม่เห็นชอบ">ไม่เห็นชอบ</option>
                </select>

                <div id="project_manager_reason_field" style="display: none;">
                    <label for="project_manager_reason">โปรดระบุเหตุผล:</label>
                    <textarea id="project_manager_reason" name="project_manager_reason" rows="4" cols="50"></textarea>
                </div>
                <label for="research_collaborator_approval">ผู้ร่วมวิจัย:</label>

                <select id="research_collaborator_approval" name="research_collaborator_approval" onchange="toggleResearchCollaboratorReasonField()" required>
                    <option value="เห็นชอบ">เห็นชอบ</option>
                    <option value="ไม่เห็นชอบ">ไม่เห็นชอบ</option>
                </select>

                <div id="research_collaborator_reason_field" style="display: none;">
                    <label for="research_collaborator_reason">โปรดระบุเหตุผล:</label>
                    <textarea id="research_collaborator_reason" name="research_collaborator_reason" rows="4" cols="50"></textarea>
                </div>
            </div>




            <button type="submit">บันทึกและสร้าง PDF</button>
        </form>

    </div>

    <script>
        function toggleOtherArticleField() {
            const dropdown = document.getElementById('article_type');
            const otherField = document.getElementById('other_article_type');
            otherField.style.display = dropdown.value === 'อื่นๆ' ? 'block' : 'none';
        }

        function toggleOtherPresentationField() {
            const dropdown = document.getElementById('presentation_type');
            const otherField = document.getElementById('other_presentation_type');
            otherField.style.display = dropdown.value === 'อื่นๆ' ? 'block' : 'none';
        }

        function toggleOtherArticlePlanField() {
            const dropdown = document.getElementById('article_plan');
            const otherField = document.getElementById('other_article_plan');
            if (dropdown.value === 'อื่นๆ') {
                otherField.classList.remove('hidden');
            } else {
                otherField.classList.add('hidden');
            }
        }

        function togglePastPresentationField() {
            const dropdown = document.getElementById('past_presentation');
            const detailsField = document.getElementById('past_presentation_details');
            if (dropdown.value === 'เคยเสนอ') {
                detailsField.classList.remove('hidden');
            } else {
                detailsField.classList.add('hidden');
            }
        }

        function updatePurposeFields() {
            const dropdown = document.getElementById('presentation_purpose');
            const otherPurposeField = document.getElementById('other_purpose_field'); // Field สำหรับ "อื่นๆ"
            const subPurpose = document.getElementById('sub_purpose'); // Dropdown สำหรับในประเทศ/ต่างประเทศ
            const foreignPurpose = document.getElementById('foreign_purpose'); // ช่องกรอกประเทศ

            // จัดการช่องกรอก "โปรดระบุ" สำหรับ "อื่นๆ"
            if (dropdown.value === 'อื่นๆ') {
                otherPurposeField.style.display = 'block';
            } else {
                otherPurposeField.style.display = 'none';
                document.getElementById('purpose_text').value = ''; // รีเซ็ตค่า
            }

            // จัดการ dropdown "โครงการที่ได้รับทุนสนับสนุน"
            if (dropdown.value === 'โครงการที่ได้รับทุนสนับสนุน') {
                subPurpose.style.display = 'block';
            } else {
                subPurpose.style.display = 'none';
                foreignPurpose.style.display = 'none'; // ซ่อนช่องกรอกประเทศด้วย
                document.getElementById('sub_purpose_select').value = ''; // รีเซ็ต dropdown
                document.getElementById('foreign_purpose_text').value = ''; // รีเซ็ตช่องกรอกประเทศ
            }
        }

        function toggleForeignPurposeField() {
            const subDropdown = document.getElementById('sub_purpose_select');
            const foreignPurpose = document.getElementById('foreign_purpose');

            // แสดงช่องกรอกประเทศเมื่อเลือก "ต่างประเทศ"
            if (subDropdown.value === 'ต่างประเทศ') {
                foreignPurpose.style.display = 'block';
            } else {
                foreignPurpose.style.display = 'none';
                document.getElementById('foreign_purpose_text').value = ''; // รีเซ็ตช่องกรอกประเทศ
            }
        }

        function toggleForeignPurposeField() {
            const subDropdown = document.getElementById('sub_purpose_select');
            const foreignPurpose = document.getElementById('foreign_purpose');

            // แสดงช่องกรอกประเทศเมื่อเลือก "ต่างประเทศ"
            if (subDropdown.value === 'ต่างประเทศ') {
                foreignPurpose.style.display = 'block';
            } else {
                foreignPurpose.style.display = 'none';
                document.getElementById('foreign_purpose_text').value = ''; // รีเซ็ตช่องกรอกประเทศ
            }
        }
        // 


        function toggleOtherAttachedDocumentsField() {
            const dropdown = document.getElementById('attached_documents');
            const otherField = document.getElementById('other_attached_documents_field');
            otherField.style.display = dropdown.value === 'อื่นๆ' ? 'block' : 'none';
        }

        function toggleDirectorReasonField() {
            const dropdown = document.getElementById('director_approval');
            const reasonField = document.getElementById('director_reason_field');
            reasonField.style.display = dropdown.value === 'ไม่เห็นชอบ' ? 'block' : 'none';
        }

        function toggleProjectManagerReasonField() {
            const dropdown = document.getElementById('project_manager_approval');
            const reasonField = document.getElementById('project_manager_reason_field');
            reasonField.style.display = dropdown.value === 'ไม่เห็นชอบ' ? 'block' : 'none';
        }

        function toggleResearchCollaboratorReasonField() {
            const dropdown = document.getElementById('research_collaborator_approval');
            const reasonField = document.getElementById('research_collaborator_reason_field');
            reasonField.style.display = dropdown.value === 'ไม่เห็นชอบ' ? 'block' : 'none';
        }
        // function toggleSubPurposeField() {
        // const dropdown = document.getElementById('presentation_purpose');
        // const subPurposeField = document.getElementById('sub_purpose');
        // const foreignField = document.getElementById('foreign_purpose');
        // const otherPurposeField = document.getElementById('other_purpose');

        // subPurposeField.classList.toggle('hidden', dropdown.value !== 'โครงการที่ได้รับทุนสนับสนุน');
        // otherPurposeField.classList.toggle('hidden', dropdown.value !== 'อื่นๆ');

        // if (dropdown.value !== 'โครงการที่ได้รับทุนสนับสนุน') {
        // foreignField.classList.add('hidden');
        // document.getElementById('sub_purpose_select').value = "";
        // document.getElementById('foreign_purpose_text').value = "";
        // }
        // if (dropdown.value !== 'อื่นๆ') {
        // document.getElementById('other_purpose_text').value = "";
        // }
        // }

        // function toggleForeignPurposeField() {
        // const subDropdown = document.getElementById('sub_purpose_select');
        // const foreignField = document.getElementById('foreign_purpose');

        // foreignField.classList.toggle('hidden', subDropdown.value !== 'ต่างประเทศ');
        // if (subDropdown.value !== 'ต่างประเทศ') {
        // document.getElementById('foreign_purpose_text').value = "";
        // }
        // }


        // function toggleOtherArticlePlanField() {
        // const dropdown = document.getElementById('article_plan');
        // const otherField = document.getElementById('other_article_plan');
        // otherField.classList.toggle('hidden', dropdown.value !== 'อื่นๆ');
        // }

        // function togglePastPresentationField() {
        // const dropdown = document.getElementById('past_presentation');
        // const detailsField = document.getElementById('past_presentation_details');
        // detailsField.classList.toggle('hidden', dropdown.value !== 'เคยเสนอ');
        // }
    </script>

    <!-- <script>
    // ฟังก์ชันสำหรับแสดง/ซ่อนฟิลด์
    function toggleField(dropdownId, fieldId, conditionValue) {
        const dropdown = document.getElementById(dropdownId);
        const field = document.getElementById(fieldId);
        field.style.display = dropdown.value === conditionValue ? 'block' : 'none';
    }

    // ฟังก์ชันสำหรับรีเซ็ตค่าเมื่อฟิลด์ถูกซ่อน
    function resetField(fieldId) {
        const field = document.getElementById(fieldId);
        field.querySelectorAll('input, textarea, select').forEach(element => {
            element.value = '';
        });
    }

    // Event Listeners สำหรับ dropdowns
    document.getElementById('article_type').addEventListener('change', () => {
        toggleField('article_type', 'other_article_type', 'อื่นๆ');
    });

    document.getElementById('presentation_type').addEventListener('change', () => {
        toggleField('presentation_type', 'other_presentation_type', 'อื่นๆ');
    });

    document.getElementById('article_plan').addEventListener('change', () => {
        toggleField('article_plan', 'other_article_plan', 'อื่นๆ');
    });

    document.getElementById('past_presentation').addEventListener('change', () => {
        toggleField('past_presentation', 'past_presentation_details', 'เคยเสนอ');
    });

    document.getElementById('attached_documents').addEventListener('change', () => {
        toggleField('attached_documents', 'other_attached_documents_field', 'อื่นๆ');
    });

    document.getElementById('director_approval').addEventListener('change', () => {
        toggleField('director_approval', 'director_reason_field', 'ไม่เห็นชอบ');
    });

    document.getElementById('project_manager_approval').addEventListener('change', () => {
        toggleField('project_manager_approval', 'project_manager_reason_field', 'ไม่เห็นชอบ');
    });

    document.getElementById('research_collaborator_approval').addEventListener('change', () => {
        toggleField('research_collaborator_approval', 'research_collaborator_reason_field', 'ไม่เห็นชอบ');
    });

    document.getElementById('presentation_purpose').addEventListener('change', () => {
        const dropdown = document.getElementById('presentation_purpose');
        toggleField('presentation_purpose', 'sub_purpose', 'โครงการที่ได้รับทุนสนับสนุน');
        document.getElementById('purpose_text').style.display = 'block';
    });

    document.getElementById('sub_purpose_select').addEventListener('change', () => {
        toggleField('sub_purpose_select', 'foreign_purpose', 'ต่างประเทศ');
    });
</script> -->

</body>
<?php
$content = ob_get_clean();

include 'layout.php';
?>