<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรอกข้อมูล PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
        }

        h1,
        h3 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .form-section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f7f7f7;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>กรอกข้อมูลสำหรับ PDF</h1>
        <form action="generate_pdf.php" method="post">
            <!-- ข้อมูลส่วนตัว -->
            <div class="form-section">
                <h3>ข้อมูลส่วนตัว (หน้า 1)</h3>
                <label for="firstname">ชื่อ:</label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname">นามสกุล:</label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="position">ตำแหน่ง:</label>
                <input type="text" id="position" name="position" required>

                <label for="work_period">ระยะเวลาทำงาน:</label>
                <input type="text" id="work_period" name="work_period" required>

                <label for="department">ฝ่าย:</label>
                <input type="text" id="department" name="department" required>

                <label for="office">สำนัก:</label>
                <input type="text" id="office" name="office" required>

                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <!-- ข้อมูลบทความ -->
            <div class="form-section">
                <label for="article_title">ชื่อบทความ:</label>
                <input type="text" id="article_title" name="article_title" required>

                <label for="first_author">ผู้แต่งชื่อคนแรก:</label>
                <input type="text" id="first_author" name="first_author" required>

                <label for="co_authors">ผู้ประพันธ์บรรณกิจ:</label>
                <input type="text" id="co_authors" name="co_authors" required>

                <label for="article_type">ประเภทของบทความ:</label>
                <select id="article_type" name="article_type" onchange="toggleOtherArticleField()" required>
                    <option value="Geo-Information">Geo-Information</option>
                    <option value="Space Technology">Space Technology</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>

                <div id="other_article_type" style="display: none;">
                    <label for="other_type">โปรดระบุ:</label>
                    <input type="text" id="other_type" name="other_type">
                </div>
            </div>

            <!-- ข้อมูลเพิ่มเติม -->
            <div class="form-section">
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

                <label for="conference_name">ชื่องานประชุมวิชาการ/ชื่อวารสารที่จะตีพิมพ์:</label>
                <textarea id="conference_name" name="conference_name" rows="4" cols="50" required></textarea>


                <label for="location">สถานที่:</label>
                <select id="location" name="location" required>
                    <option value="ในประเทศ">ในประเทศ</option>
                    <option value="ต่างประเทศ">ต่างประเทศ</option>
                </select>

                <label for="location_text">โปรดระบุสถานที่:</label>
                <input type="text" id="location_text" name="location_text" required>
            </div>

            <!-- กำหนดการ -->
            <div class="form-section">
                <label for="submission_date">วันกำหนดการส่ง/นำเสนอผลงานวิชาการ:</label>
                <input type="text" id="submission_date" name="submission_date" required>

                <label for="registration_fee">ค่าลงทะเบียน/ค่านำเสนอ/ค่าตีพิมพ์บทความ:</label>
                <input type="text" id="registration_fee" name="registration_fee" required>

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
                    <label for="other_article_plan_text">โปรดระบุ:</label>
                    <input type="text" id="other_article_plan_text" name="other_article_plan_text">
                </div>
            </div>
            <!-- <div class="form-section">
                <label for="">
                    <select name="" id="">
                        <option value="">

                        </option>
                    </select>
                </label>
            </div> -->
            <!-- แหล่งงบประมาณในการเสนอผลงาน -->
            <div class="form-section">
                <label for="budget_source">แหล่งงบประมาณในการเสนอผลงาน:</label>
                <textarea id="budget_source" name="budget_source" rows="4" required></textarea>
            </div>

            <!-- ระบุรายละเอียดการเสนอผลงานในช่วง 3 ปีที่ผ่านมา -->
            <div class="form-section">
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
                <label for="presentation_purpose">จุดประสงค์การนำเสนอผลงานวิชาการ:</label>
                <select id="presentation_purpose" name="presentation_purpose" onchange="updatePurposeFields()" required>
                    <option value="สงป">สงป</option>
                    <option value="อว">อว</option>
                    <option value="กพร">กพร</option>
                    <option value="ยุทธศาสตร์">ยุทธศาสตร์</option>
                    <option value="โครงการที่ได้รับทุนสนับสนุน">โครงการที่ได้รับทุนสนับสนุน</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>

                <label for="purpose_text">โปรดระบุ:</label>
                <input type="text" id="purpose_text" name="purpose_text">

                <div id="sub_purpose" style="display: none;">
                    <label for="sub_purpose_select">เลือกประเภทโครงการ:</label>
                    <select id="sub_purpose_select" name="sub_purpose_select" onchange="toggleForeignPurposeField()">
                        <option value="ในประเทศ">ในประเทศ</option>
                        <option value="ต่างประเทศ">ต่างประเทศ</option>
                    </select>
                </div>

                <div id="foreign_purpose" style="display: none;">
                    <label for="foreign_purpose_text">โปรดระบุ:</label>
                    <input type="text" id="foreign_purpose_text" name="foreign_purpose_text">
                </div>
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


            <!-- หัวข้อ ผู้อำนวยการสำนัก -->
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
            const purposeText = document.getElementById('purpose_text');
            const subPurposeField = document.getElementById('sub_purpose');
            const foreignField = document.getElementById('foreign_purpose');

            // Always show the text input
            purposeText.style.display = 'block';

            // Handle sub-purpose field
            if (dropdown.value === 'โครงการที่ได้รับทุนสนับสนุน') {
                subPurposeField.style.display = 'block';
                foreignField.style.display = 'none';
            } else {
                subPurposeField.style.display = 'none';
                foreignField.style.display = 'none';
                document.getElementById('sub_purpose_select').value = "";
                document.getElementById('foreign_purpose_text').value = "";
            }

            // Handle "อื่นๆ"
            if (dropdown.value !== 'อื่นๆ') {
                purposeText.value = '';
            }
        }

        function toggleForeignPurposeField() {
            const subDropdown = document.getElementById('sub_purpose_select');
            const foreignField = document.getElementById('foreign_purpose');

            if (subDropdown.value === 'ต่างประเทศ') {
                foreignField.style.display = 'block';
            } else {
                foreignField.style.display = 'none';
                document.getElementById('foreign_purpose_text').value = '';
            }
        }

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
        //     const dropdown = document.getElementById('presentation_purpose');
        //     const subPurposeField = document.getElementById('sub_purpose');
        //     const foreignField = document.getElementById('foreign_purpose');
        //     const otherPurposeField = document.getElementById('other_purpose');

        //     subPurposeField.classList.toggle('hidden', dropdown.value !== 'โครงการที่ได้รับทุนสนับสนุน');
        //     otherPurposeField.classList.toggle('hidden', dropdown.value !== 'อื่นๆ');

        //     if (dropdown.value !== 'โครงการที่ได้รับทุนสนับสนุน') {
        //         foreignField.classList.add('hidden');
        //         document.getElementById('sub_purpose_select').value = "";
        //         document.getElementById('foreign_purpose_text').value = "";
        //     }
        //     if (dropdown.value !== 'อื่นๆ') {
        //         document.getElementById('other_purpose_text').value = "";
        //     }
        // }

        // function toggleForeignPurposeField() {
        //     const subDropdown = document.getElementById('sub_purpose_select');
        //     const foreignField = document.getElementById('foreign_purpose');

        //     foreignField.classList.toggle('hidden', subDropdown.value !== 'ต่างประเทศ');
        //     if (subDropdown.value !== 'ต่างประเทศ') {
        //         document.getElementById('foreign_purpose_text').value = "";
        //     }
        // }


        // function toggleOtherArticlePlanField() {
        //     const dropdown = document.getElementById('article_plan');
        //     const otherField = document.getElementById('other_article_plan');
        //     otherField.classList.toggle('hidden', dropdown.value !== 'อื่นๆ');
        // }

        // function togglePastPresentationField() {
        //     const dropdown = document.getElementById('past_presentation');
        //     const detailsField = document.getElementById('past_presentation_details');
        //     detailsField.classList.toggle('hidden', dropdown.value !== 'เคยเสนอ');
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

</html>