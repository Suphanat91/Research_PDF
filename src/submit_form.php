<?php
// เรียกใช้ไฟล์ db.php เพื่อเชื่อมต่อฐานข้อมูล
require_once 'db.php';
require_once 'auth.php'; // เพิ่ม auth.php เพื่อใช้ session

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // ตรวจสอบการล็อกอิน
        require_login();

        // ดึง user_id จาก session
        $user_id = $_SESSION['user_id']; // สมมติว่า user_id ถูกเก็บใน session

        // เตรียมข้อมูลจากฟอร์ม
        $data = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'position' => $_POST['position'],
            'work_period' => $_POST['work_period'],
            'department' => $_POST['department'],
            'office' => $_POST['office'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'article_title' => $_POST['article_title'],
            'first_author' => $_POST['first_author'],
            'co_authors' => $_POST['co_authors'],
            'article_type' => $_POST['article_type'],
            'other_article_type' => $_POST['other_type'] ?? null,
            'presentation_type' => $_POST['presentation_type'],
            'other_presentation' => $_POST['other_presentation'] ?? null,
            'conference_name' => $_POST['conference_name'],
            'location' => $_POST['location'],
            'location_text' => $_POST['location_text'],
            'submission_date' => $_POST['submission_date'],
            'registration_fee' => $_POST['registration_fee'],
            'presentation_times' => $_POST['presentation_times'],
            'details' => $_POST['details'],
            'article_plan' => $_POST['article_plan'],
            'other_article_plan' => $_POST['other_article_plan_text'] ?? null,
            'budget_source' => $_POST['budget_source'],
            'past_presentation' => $_POST['past_presentation'],
            'past_presentation_text' => $_POST['past_presentation_text'] ?? null,
            'presentation_purpose' => $_POST['presentation_purpose'],
            'purpose_text' => $_POST['purpose_text'] ?? null,
            'sub_purpose_select' => $_POST['sub_purpose_select'] ?? null,
            'foreign_purpose_text' => $_POST['foreign_purpose_text'] ?? null,
            'benefit_of_use' => $_POST['benefit_of_use'],
            'attached_documents' => $_POST['attached_documents'],
            'other_attached_documents' => $_POST['other_attached_documents_text'] ?? null,
            'notes' => $_POST['notes'],
            'director_approval' => $_POST['director_approval'],
            'director_reason' => $_POST['director_reason'] ?? null,
            'project_manager_approval' => $_POST['project_manager_approval'],
            'project_manager_reason' => $_POST['project_manager_reason'] ?? null,
            'research_collaborator_approval' => $_POST['research_collaborator_approval'],
            'research_collaborator_reason' => $_POST['research_collaborator_reason'] ?? null,
            'state' => '1', // กำหนดสถานะเริ่มต้นเป็น 'submitted'
            'users_user_id' => $user_id, // ดึง user_id จาก session
        ];

        // คำสั่ง SQL สำหรับบันทึกข้อมูล
        $sql = "
            INSERT INTO articles (
                firstname, lastname, position, work_period, department, office, phone, email, article_title, first_author,
                co_authors, article_type, other_article_type, presentation_type, other_presentation, conference_name,
                location, location_text, submission_date, registration_fee, presentation_times, details, article_plan,
                other_article_plan, budget_source, past_presentation, past_presentation_text, presentation_purpose,
                purpose_text, sub_purpose_select, foreign_purpose_text, benefit_of_use, attached_documents,
                other_attached_documents, notes, director_approval, director_reason, project_manager_approval,
                project_manager_reason, research_collaborator_approval, research_collaborator_reason, state, users_user_id
            ) VALUES (
                :firstname, :lastname, :position, :work_period, :department, :office, :phone, :email, :article_title, :first_author,
                :co_authors, :article_type, :other_article_type, :presentation_type, :other_presentation, :conference_name,
                :location, :location_text, :submission_date, :registration_fee, :presentation_times, :details, :article_plan,
                :other_article_plan, :budget_source, :past_presentation, :past_presentation_text, :presentation_purpose,
                :purpose_text, :sub_purpose_select, :foreign_purpose_text, :benefit_of_use, :attached_documents,
                :other_attached_documents, :notes, :director_approval, :director_reason, :project_manager_approval,
                :project_manager_reason, :research_collaborator_approval, :research_collaborator_reason, :state, :users_user_id
            )
        ";

        // เตรียมคำสั่ง SQL และรัน
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        // หลังบันทึกสำเร็จ ให้กลับไปที่หน้า dashboard
        header("Location: dashboard.php");
        // echo "บันทึกข้อมูลสำเร็จ!";
    } catch (PDOException $e) {
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
} else {
    echo "ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง!";
}
?>