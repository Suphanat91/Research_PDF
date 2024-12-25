<?php
session_start();
require __DIR__ . '/vendor/autoload.php'; // Composer autoload
require_once 'db.php'; // เชื่อมต่อฐานข้อมูล

use setasign\Fpdi\Fpdi;

// ดึงข้อมูลจากฐานข้อมูล
try {
    // กำหนด ID ของบทความที่ต้องการ
    $article_id = $_GET['id'] ?? 3; // ใช้ ID 1 เป็นค่าเริ่มต้น หรือเปลี่ยนเป็น dynamic ได้

    // คำสั่ง SQL สำหรับดึงข้อมูล
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->execute(['id' => $article_id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        throw new Exception("ไม่พบข้อมูลบทความที่ต้องการ");
    }

    // ดึงค่าจากฐานข้อมูลมาเก็บในตัวแปร
    $firstname = $article['firstname'] ?? '';
    $lastname = $article['lastname'] ?? '';
    $position = $article['position'] ?? '';
    $work_period = $article['work_period'] ?? '';
    $department = $article['department'] ?? '';
    $office = $article['office'] ?? '';
    $phone = $article['phone'] ?? '';
    $email = $article['email'] ?? '';
    $article_title = $article['article_title'] ?? '';
    $first_author = $article['first_author'] ?? '';
    $co_authors = $article['co_authors'] ?? '';
    $article_type = $article['article_type'] ?? '';
    $other_type = $article['other_article_type'] ?? '';
    $presentation_type = $article['presentation_type'] ?? '';
    $other_presentation = $article['other_presentation'] ?? '';
    $conference_name = $article['conference_name'] ?? '';
    $location = $article['location'] ?? '';
    $location_text = $article['location_text'] ?? '';
    $submission_date = $article['submission_date'] ?? '';
    $registration_fee = $article['registration_fee'] ?? '';
    $presentation_times = $article['presentation_times'] ?? '';
    $details = $article['details'] ?? '';
    $article_plan = $article['article_plan'] ?? '';
    $other_article_plan_text = $article['other_article_plan'] ?? '';
    $budget_source = $article['budget_source'] ?? '';
    $past_presentation = $article['past_presentation'] ?? '';
    $past_presentation_text = $article['past_presentation_text'] ?? '';
    $presentation_purpose = $article['presentation_purpose'] ?? '';
    $sub_purpose_select = $article['sub_purpose_select'] ?? '';
    $foreign_purpose_text = $article['foreign_purpose_text'] ?? '';
    $purpose_text = $article['purpose_text'] ?? '';
    $benefit_of_use = $article['benefit_of_use'] ?? '';
    $attached_documents = $article['attached_documents'] ?? '';
    $other_attached_documents_text = $article['other_attached_documents'] ?? '';
    $notes = $article['notes'] ?? '';
    $director_approval = $article['director_approval'] ?? '';
    $director_reason = $article['director_reason'] ?? '';
    $project_manager_approval = $article['project_manager_approval'] ?? '';
    $project_manager_reason = $article['project_manager_reason'] ?? '';
    $research_collaborator_approval = $article['research_collaborator_approval'] ?? '';
    $research_collaborator_reason = $article['research_collaborator_reason'] ?? '';
    $date_today = date('d/m/Y');

    $additional_info_1 = $article['additional_info_1'] ?? ''; // ค่าเริ่มต้น
    $additional_info_2 = $article['additional_info_2'] ?? ''; // ค่าเริ่มต้น
    $final_note = $article['final_note'] ?? ''; // ค่าเริ่มต้น
    $article_plan_text = $article_plan === 'อื่นๆ' ? $other_article_plan_text : $article_plan; // เลือกข้อความที่เหมาะสม
    $other_purpose_text = $purpose_text; // กำหนดค่าตาม context
    if ($article_type === 'อื่นๆ') {
        $article_type_text = $other_type;
    } else {
        $article_type_text = $article_type;
    }


    if ($presentation_type === 'อื่นๆ') {
        $presentation_type_text = $other_presentation;
    } else {
        $presentation_type_text = $presentation_type;
    }
    // แปลงข้อความด้วย iconv หากไม่ใช่ null
    $convertToCp874 = function ($text) {
        return $text !== null ? iconv('UTF-8', 'cp874', $text) : '';
    };

    $firstname = $convertToCp874($firstname);
    $lastname = $convertToCp874($lastname);
    $position = $convertToCp874($position);
    $work_period = $convertToCp874($work_period);
    $department = $convertToCp874($department);
    $office = $convertToCp874($office);
    $phone = $convertToCp874($phone);
    $email = $convertToCp874($email);
    $article_title = $convertToCp874($article_title);
    $first_author = $convertToCp874($first_author);
    $co_authors = $convertToCp874($co_authors);
    $additional_info_1 = $convertToCp874($additional_info_1);
    $additional_info_2 = $convertToCp874($additional_info_2);
    $final_note = $convertToCp874($final_note);
    $article_type_text = $convertToCp874($article_type === 'อื่นๆ' ? $other_type : $article_type);
    $presentation_type_text = $convertToCp874($presentation_type === 'อื่นๆ' ? $other_presentation : $presentation_type);
    $conference_name = $convertToCp874($conference_name);
    $location_text = $convertToCp874($location_text);
    $submission_date = $convertToCp874($submission_date);
    $registration_fee = $convertToCp874($registration_fee);
    $presentation_times = $convertToCp874($presentation_times);
    $details = $convertToCp874($details);
    $article_plan_text = $convertToCp874($article_plan_text);
    $budget_source = $convertToCp874($budget_source);
    $past_presentation_text = $convertToCp874($past_presentation_text);
    $foreign_purpose_text = $convertToCp874($foreign_purpose_text);
    $other_purpose_text = $convertToCp874($other_purpose_text);
    $benefit_of_use = $convertToCp874($benefit_of_use);
    $other_attached_documents_text = $convertToCp874($other_attached_documents_text);
    $notes = $convertToCp874($notes);
    $director_reason = $convertToCp874($director_reason);
    $project_manager_reason = $convertToCp874($project_manager_reason);
    $research_collaborator_reason = $convertToCp874($research_collaborator_reason);
    $purpose_text = $convertToCp874($purpose_text);
    $other_type = $convertToCp874($other_type);


   
    
    // ส่วนที่เหลือใช้โค้ดการสร้าง PDF เดิม
    // โหลดฟอร์ม PDF
    $pdf = new Fpdi();

    // --- ดึงหน้า 1 ---
    $pdf->AddPage();
    $pdf->setSourceFile(__DIR__ . '/form-template1.pdf');
    $page1 = $pdf->importPage(1);
    $pdf->useTemplate($page1);

    // เพิ่มฟอนต์ภาษาไทย
    $pdf->AddFont('SarabunPSK', '', 'THSarabunNew.php');
    $pdf->SetFont('SarabunPSK', '', 16);
    $pdf->SetTextColor(0, 0, 0);

    // เติมข้อมูลหน้า 1 ด้วย MultiCell
    $pdf->SetXY(25, 54);
    $pdf->MultiCell(70, 5, $firstname, 0, 'C'); // ช่องข้อความสำหรับชื่อ

    $pdf->SetXY(105, 54);
    $pdf->MultiCell(70, 5, $lastname, 0, 'C'); // ช่องข้อความสำหรับนามสกุล

    $pdf->SetXY(35, 61.7);
    $pdf->MultiCell(90, 5, $position, 0, 'C'); // ช่องข้อความสำหรับตำแหน่ง

    $pdf->SetXY(151, 61.7);
    $pdf->MultiCell(30, 5, $work_period, 0, 'C'); // ช่องข้อความสำหรับช่วงเวลาทำงาน

    $pdf->SetXY(25, 69.4);
    $pdf->MultiCell(80, 5, $department, 0, 'C'); // ช่องข้อความสำหรับแผนก

    $pdf->SetXY(90, 69.4);
    $pdf->MultiCell(60, 5, $office, 0, 'C'); // ช่องข้อความสำหรับสำนักงาน

    $pdf->SetXY(40, 78);
    $pdf->MultiCell(50, 5, $phone, 0, 'C'); // ช่องข้อความสำหรับโทรศัพท์

    $pdf->SetXY(105, 78);
    $pdf->MultiCell(60, 5, $email, 0, 'C'); // ช่องข้อความสำหรับอีเมล

    $max_words = 25;
    $article_words = explode(' ', $article_title); // แยกข้อความออกเป็นคำ
    if (count($article_words) > $max_words) {
        $article_title = implode(' ', array_slice($article_words, 0, $max_words)); // ตัดเหลือ 25 คำ
    }
    $pdf->SetXY(50, 96);
    $pdf->MultiCell(100, 7.8, $article_title, 0, 'L'); // 100 = ความกว้าง, 6 = ระยะห่างบรรทัด

    $pdf->SetXY(105, 131);
    $pdf->Write(0, "$first_author");
    $pdf->SetXY(130, 140);
    $pdf->Write(0, "$co_authors");
    // กำหนดตำแหน่งเครื่องหมายถูก
    $geo_check_x = 65;  // ตำแหน่ง X สำหรับ Geo-Information
    $geo_check_y = 144; // ตำแหน่ง Y สำหรับ Geo-Information

    $space_check_x = 103;  // ตำแหน่ง X สำหรับ Space Technology
    $space_check_y = 144; // ตำแหน่ง Y สำหรับ Space Technology

    $other_check_x = 65;  // ตำแหน่ง X สำหรับเครื่องหมายถูก "อื่นๆ"
    $other_check_y = 153; // ตำแหน่ง Y สำหรับเครื่องหมายถูก "อื่นๆ"

    $other_text_x = 115;  // ตำแหน่ง X สำหรับข้อความ "อื่นๆ"
    $other_text_y = 156; // ตำแหน่ง Y สำหรับข้อความ "อื่นๆ"

    // ตรวจสอบประเภทของบทความ
    if ($article_type === 'Geo-Information') {
        $pdf->Image(__DIR__ . '/correct1.png', $geo_check_x, $geo_check_y, 5, 5); // เครื่องหมายถูก Geo-Information
    } elseif ($article_type === 'Space Technology') {
        $pdf->Image(__DIR__ . '/correct1.png', $space_check_x, $space_check_y, 5, 5); // เครื่องหมายถูก Space Technology
    } elseif ($article_type === 'อื่นๆ') {
        // เครื่องหมายถูกสำหรับ "อื่นๆ"
        $pdf->Image(__DIR__ . '/correct1.png', $other_check_x, $other_check_y, 5, 5);

        // แสดงข้อความ "อื่นๆ" ที่ระบุมา
        $pdf->SetXY($other_text_x, $other_text_y); // ระบุตำแหน่งตัวหนังสือ
        $pdf->Write(0, $other_type); // พิมพ์ข้อความที่ผู้ใช้กรอกมา
    }

    //หัวข้อประเภท
    // ตำแหน่งของเครื่องหมายถูก
    $oral_check_x = 41;   // ตำแหน่ง X สำหรับ Oral Presentation
    $oral_check_y = 161;  // ตำแหน่ง Y สำหรับ Oral Presentation

    $poster_check_x = 86.5;   // ตำแหน่ง X สำหรับ Poster Presentation
    $poster_check_y = 161;  // ตำแหน่ง Y สำหรับ Poster Presentation

    $online_check_x = 136;   // ตำแหน่ง X สำหรับ Online Presentation
    $online_check_y = 161;  // ตำแหน่ง Y สำหรับ Online Presentation

    $publication_check_x = 41;   // ตำแหน่ง X สำหรับ Publication
    $publication_check_y = 169;  // ตำแหน่ง Y สำหรับ Publication

    $other_check_x = 100;   // ตำแหน่ง X สำหรับ "อื่นๆ"
    $other_check_y = 169;  // ตำแหน่ง Y สำหรับ "อื่นๆ"

    $other_text_x = 133;    // ตำแหน่ง X สำหรับข้อความ "อื่นๆ"
    $other_text_y = 172;   // ตำแหน่ง Y สำหรับข้อความ "อื่นๆ"

    // ตรวจสอบประเภทและแสดงเครื่องหมายถูก
    if ($presentation_type === 'Oral Presentation') {
        $pdf->Image(__DIR__ . '/correct1.png', $oral_check_x, $oral_check_y, 5, 5);
    } elseif ($presentation_type === 'Poster Presentation') {
        $pdf->Image(__DIR__ . '/correct1.png', $poster_check_x, $poster_check_y, 5, 5);
    } elseif ($presentation_type === 'Online Presentation') {
        $pdf->Image(__DIR__ . '/correct1.png', $online_check_x, $online_check_y, 5, 5);
    } elseif ($presentation_type === 'Publication') {
        $pdf->Image(__DIR__ . '/correct1.png', $publication_check_x, $publication_check_y, 5, 5);
    } elseif ($presentation_type === 'อื่นๆ') {
        // แสดงเครื่องหมายถูกสำหรับ "อื่นๆ"
        $pdf->Image(__DIR__ . '/correct1.png', $other_check_x, $other_check_y, 5, 5);

        // แสดงข้อความที่กรอกมา
        $pdf->SetXY($other_text_x, $other_text_y); // ระบุตำแหน่งข้อความ
        $pdf->Write(0, $presentation_type_text); // พิมพ์ข้อความที่ผู้ใช้กรอก
    }

    // // $pdf->SetXY(135, 180); // ตัวอย่างตำแหน่ง X, Y
    // // $pdf->Write(0, $conference_name); // เขียนข้อความ

    // $cell_width = 100; // ความกว้างของพื้นที่ข้อความ
    // $cell_line_height = 9; // ระยะห่างระหว่างบรรทัด

    // // ตำแหน่งเริ่มต้น
    // $x = 100; // ตำแหน่ง X เริ่มต้น
    // $y = 175; // ตำแหน่ง Y เริ่มต้น

    // // แยกข้อความเป็นบรรทัดๆ ละไม่เกิน 35 ตัวอักษร
    // $lines = explode("\n", wordwrap($conference_name, 35, "\n", true));

    // // วาดข้อความทีละบรรทัด
    // foreach ($lines as $line) {
    // $pdf->SetXY($x, $y); // กำหนดตำแหน่งของบรรทัด
    // $pdf->MultiCell($cell_width, $cell_line_height, $line, 0, 'J'); // 'J' คือการจัดข้อความแบบ Justify
    // $y += $cell_line_height; // เพิ่มตำแหน่ง Y สำหรับบรรทัดถัดไป
    // }
    // $max_chars_first_line = 40; // จำนวนตัวอักษรสูงสุดสำหรับบรรทัดแรก
    $max_words_first_line = 5; // จำนวนคำสูงสุดสำหรับบรรทัดแรก
    $max_words_second_line = 200; // จำนวนคำสูงสุดสำหรับบรรทัดที่สอง

    // ตำแหน่งเริ่มต้น
    $cell_width = 120; // ความกว้างของพื้นที่ข้อความ
    $cell_line_height = 7; // ระยะห่างระหว่างบรรทัด

    // ตำแหน่งสำหรับบรรทัดต่างๆ
    $x_first_line = 100; // ตำแหน่ง X สำหรับบรรทัดแรก
    $y_first_line = 177; // ตำแหน่ง Y สำหรับบรรทัดแรก
    $x_second_line = 25; // ตำแหน่ง X สำหรับบรรทัดที่สอง (ต่างจากบรรทัดแรก)
    $y_second_line = 185; // ตำแหน่ง Y สำหรับบรรทัดที่สอง (เลื่อนลงมา)

    // แยกข้อความเป็นคำ
    $words = explode(' ', $conference_name);

    // แยกคำสำหรับบรรทัดแรก
    $first_line_words = array_slice($words, 0, $max_words_first_line);
    $first_line = implode(' ', $first_line_words);

    // เหลือข้อความที่เหลือจากบรรทัดแรก
    $remaining_words = array_slice($words, $max_words_first_line);

    // แยกคำสำหรับบรรทัดที่สอง
    $second_line_words = array_slice($remaining_words, 0, $max_words_second_line);
    $second_line = implode(' ', $second_line_words);

    // แสดงบรรทัดแรก
    $pdf->SetXY($x_first_line, $y_first_line);
    $pdf->MultiCell($cell_width, $cell_line_height, $first_line, 0, 'L');

    // แสดงบรรทัดที่สอง
    $pdf->SetXY($x_second_line, $y_second_line);
    $pdf->MultiCell($cell_width, $cell_line_height, $second_line, 0, 'L');




    $in_country_check_x = 41; // ตำแหน่ง X สำหรับ "ในประเทศ"
    $in_country_check_y = 193; // ตำแหน่ง Y สำหรับ "ในประเทศ"

    $out_country_check_x = 41; // ตำแหน่ง X สำหรับ "ต่างประเทศ"
    $out_country_check_y = 202; // ตำแหน่ง Y สำหรับ "ต่างประเทศ"

    $text_x = 75; // ตำแหน่ง X สำหรับข้อความเพิ่มเติม
    $text_y_in_country = 196; // ตำแหน่ง Y สำหรับข้อความเพิ่มเติม "ในประเทศ"
    $text_y_out_country = 205; // ตำแหน่ง Y สำหรับข้อความเพิ่มเติม "ต่างประเทศ"

    // แสดงข้อมูล "สถานที่"
    if ($location === 'ในประเทศ') {
        $pdf->Image(__DIR__ . '/correct1.png', $in_country_check_x, $in_country_check_y, 5, 5);
        if (!empty($location_text)) {
            $pdf->SetXY($text_x, $text_y_in_country);
            $pdf->Write(0, $location_text);
        }
    } elseif ($location === 'ต่างประเทศ') {
        $pdf->Image(__DIR__ . '/correct1.png', $out_country_check_x, $out_country_check_y, 5, 5);
        if (!empty($location_text)) {
            $pdf->SetXY($text_x, $text_y_out_country);
            $pdf->Write(0, $location_text);
        }
    }


    $pdf->SetXY(100, 213);
    $pdf->Write(0, "$submission_date");

    $pdf->SetXY(105, 221);
    $pdf->Write(0, "$registration_fee");

    $pdf->SetXY(85, 239);
    $pdf->Write(0, "$presentation_times");

    // // ตั้งค่าความกว้าง ความสูงบรรทัด และข้อความ
    // $text_width = 110; // ความกว้างของ MultiCell
    // $text_line_height = 12; // ระยะห่างระหว่างบรรทัด

    // // ตำแหน่งเริ่มต้น
    // $start_x_first_line = 50; // ตำแหน่ง X สำหรับบรรทัดแรก
    // $start_y_first_line = 242; // ตำแหน่ง Y สำหรับบรรทัดแรก
    // $start_x_other_lines = 27; // ตำแหน่ง X สำหรับบรรทัดถัดไป
    // $line_spacing = 10; // ระยะห่างระหว่างบรรทัดถัดไป

    // // แยกข้อความเป็นบรรทัดๆ ละไม่เกิน 40 ตัวอักษร
    // $wrapped_lines = explode("\n", wordwrap($details, 60, "\n", true));

    // // วาดข้อความทีละบรรทัด
    // foreach ($wrapped_lines as $line_index => $wrapped_line) {
    //     if ($line_index === 0) {
    //         // บรรทัดแรก
    //         $pdf->SetXY($start_x_first_line, $start_y_first_line);
    //     } else {
    //         // บรรทัดที่สองและถัดไป
    //         $pdf->SetXY($start_x_other_lines, $start_y_first_line + ($line_spacing * $line_index));
    //     }
    //     $pdf->MultiCell($text_width, $text_line_height, $wrapped_line, 0, 'L'); // 'L' คือการจัดข้อความแบบชิดซ้าย
    // }
    // กำหนดค่าความยาวข้อความสำหรับแต่ละบรรทัด

    // ข้อมูลการกำหนดบรรทัด
    // ข้อมูลการกำหนดบรรทัด
    $max_words_first_line = 22; // จำนวนคำสูงสุดสำหรับบรรทัดแรก
    $max_words_other_lines = 25; // จำนวนคำสูงสุดสำหรับบรรทัดถัดไป
    $max_lines = 3; // จำนวนบรรทัดสูงสุด

    // ตำแหน่งเริ่มต้น
    $first_line_x = 50; // ตำแหน่ง X สำหรับบรรทัดแรก
    $first_line_y = 243; // ตำแหน่ง Y สำหรับบรรทัดแรก
    $other_lines_x = 20; // ตำแหน่ง X สำหรับบรรทัดถัดไป
    $line_height = 8; // ระยะห่างระหว่างบรรทัด

    // แยกข้อความเป็นคำ
    $words = explode(' ', $details);

    // ตัดข้อความสำหรับบรรทัดแรก
    $first_line_words = array_slice($words, 0, $max_words_first_line);
    $first_line = implode(' ', $first_line_words);

    // เหลือข้อความที่เหลือจากบรรทัดแรก
    $remaining_words = array_slice($words, $max_words_first_line);

    // แยกข้อความที่เหลือสำหรับบรรทัดถัดไป
    $other_lines = [];
    while (!empty($remaining_words)) {
        $current_line_words = array_slice($remaining_words, 0, $max_words_other_lines);
        $other_lines[] = implode(' ', $current_line_words);
        $remaining_words = array_slice($remaining_words, $max_words_other_lines);
    }

    // จำกัดจำนวนบรรทัดที่จะแสดง
    $lines_to_print = array_slice(array_merge([$first_line], $other_lines), 0, $max_lines);

    $current_y = $first_line_y;

    // แสดงข้อความในแต่ละบรรทัด
    foreach ($lines_to_print as $index => $line) {
        // ปรับตำแหน่ง X สำหรับบรรทัดแรกและบรรทัดถัดไป
        $current_x = $index === 0 ? $first_line_x : $other_lines_x;

        // กำหนดตำแหน่งและแสดงข้อความ
        $pdf->SetXY($current_x, $current_y);
        $pdf->MultiCell(130, $line_height, $line, 0, 'L'); // ใช้ MultiCell เพื่อจัดข้อความและหลีกเลี่ยงกรอบ
        $current_y += $line_height; // เพิ่มตำแหน่ง Y สำหรับบรรทัดถัดไป
    }



    // --- ดึงหน้า 2 ---
    $pdf->AddPage();
    $page2 = $pdf->importPage(2);
    $pdf->useTemplate($page2);


    // กำหนดตำแหน่งและเติมข้อมูล
    // แผนการส่งบทความ
    $article_plan_x = 62; // ตำแหน่ง X
    $article_plan_y = 25; // ตำแหน่ง Y
    $other_article_plan_y = 33; // ตำแหน่ง Y สำหรับ "อื่นๆ"
    $article_plan_x1 = 65; // ตำแหน่ง X
    $other_article_plan_y1 = 36;
    // $article_plan_y1 = 25; // ตำแหน่ง Y

    if ($article_plan === 'ตามแผนการดำเนินงานของสำนัก') {
        $pdf->SetXY($article_plan_x, $article_plan_y);
        $pdf->Image(__DIR__ . '/correct1.png', $article_plan_x - 5, $article_plan_y, 5, 5); // เครื่องหมายถูก
    } elseif ($article_plan === 'อื่นๆ') {
        $pdf->SetXY($article_plan_x, $other_article_plan_y);
        $pdf->Image(__DIR__ . '/correct1.png', $article_plan_x - 5, $other_article_plan_y, 5, 5); // เครื่องหมายถูก
        $pdf->SetXY($article_plan_x1 + 10, $other_article_plan_y1);
        $pdf->Write(0, $article_plan_text); // ข้อความที่กรอก
    }

    // แหล่งงบประมาณในการเสนอผลงาน
    $budget_source_x = 88; // ตำแหน่ง X
    $budget_source_y = 40; // ตำแหน่ง Y
    $pdf->SetXY($budget_source_x, $budget_source_y);
    $pdf->MultiCell(120, 8, $budget_source, 0, 'L');

    // ระบุรายละเอียดการเสนอผลงานในช่วง 3 ปีที่ผ่านมา
    $past_presentation_x = 130; // ตำแหน่ง X
    $past_presentation_x_text = 25; // ตำแหน่ง X
    $past_presentation_x6 = 109; // ตำแหน่ง X
    $past_presentation_y = 50; // ตำแหน่ง Y
    $past_presentation_y1 = 40; // ตำแหน่ง Y
    $past_presentation_details_y = 57; // ตำแหน่ง Y สำหรับข้อความ "เคยเสนอ"

    if ($past_presentation === 'ไม่เคยเสนอ') {
        $pdf->SetXY($past_presentation_x, $past_presentation_y);
        $pdf->Image(__DIR__ . '/correct1.png', $past_presentation_x - 5, $past_presentation_y, 5, 5); // เครื่องหมายถูก
    } elseif ($past_presentation === 'เคยเสนอ') {
        $pdf->SetXY($past_presentation_x6, $past_presentation_y1 + 10);
        $pdf->Image(__DIR__ . '/correct1.png', $past_presentation_x6 - 5, $past_presentation_y1 + 10, 5, 5); // เครื่องหมายถูก
        $pdf->SetXY($past_presentation_x_text, $past_presentation_details_y);
        $pdf->MultiCell(160, 8, $past_presentation_text, 0, 'L'); // ข้อความที่กรอก
    }

    // ตำแหน่งเครื่องหมายถูกและข้อความสำหรับแต่ละตัวเลือก
    // ตำแหน่งเครื่องหมายถูกและข้อความ
    // ตำแหน่งเครื่องหมายถูกและข้อความ
    $options_positions = [
        'สงป' => ['checkmark_x' => 39, 'checkmark_y' => 84, 'text_x' => 70, 'text_y' => 84],
        'อว' => ['checkmark_x' => 39, 'checkmark_y' => 92, 'text_x' => 70, 'text_y' => 92],
        'กพร' => ['checkmark_x' => 39, 'checkmark_y' => 100, 'text_x' => 70, 'text_y' => 100],
        'ยุทธศาสตร์' => ['checkmark_x' => 39, 'checkmark_y' => 109, 'text_x' => 90, 'text_y' => 109],
        'โครงการที่ได้รับทุนสนับสนุน' => ['checkmark_x' => 39, 'checkmark_y' => 117, 'text_x' => 110, 'text_y' => 117],
    ];

    if (!empty($presentation_purpose) && isset($options_positions[$presentation_purpose])) {
        // ดึงตำแหน่งของตัวเลือกที่เลือก
        $position = $options_positions[$presentation_purpose];

        // แสดงเครื่องหมายถูก
        $pdf->Image(__DIR__ . '/correct1.png', $position['checkmark_x'], $position['checkmark_y'], 5, 5);

        // แสดงข้อความของตัวเลือกที่เลือก
        $pdf->SetXY($position['text_x'], $position['text_y']);
        $pdf->MultiCell(120, 8, ($purpose_text), 0, 'L');

        // ตรวจสอบกรณี "โครงการที่ได้รับทุนสนับสนุน"
        if ($presentation_purpose === 'โครงการที่ได้รับทุนสนับสนุน') {
            if ($sub_purpose_select === 'ในประเทศ') {
                // ตำแหน่งเครื่องหมายถูกสำหรับ "ในประเทศ"
                $checkmark_in_x = 85;
                $checkmark_in_y = 126;
                // $text_in_x = 50;
                // $text_in_y = 125;

                // แสดงเครื่องหมายถูกและข้อความ "ในประเทศ"
                $pdf->Image(__DIR__ . '/correct1.png', $checkmark_in_x, $checkmark_in_y, 5, 5);
                // $pdf->SetXY($text_in_x, $text_in_y);
                // $pdf->MultiCell(120, 8, 'L');
            } elseif ($sub_purpose_select === 'ต่างประเทศ') {
                // ตำแหน่งเครื่องหมายถูกและข้อความสำหรับ "ต่างประเทศ"
                $checkmark_foreign_x = 85;
                $checkmark_foreign_y = 134;
                $text_foreign_x = 127;
                $text_foreign_y = 134;

                // แสดงเครื่องหมายถูก
                $pdf->Image(__DIR__ . '/correct1.png', $checkmark_foreign_x, $checkmark_foreign_y, 5, 5);

                // แสดงข้อความจาก foreign_purpose_text
                if (!empty($foreign_purpose_text)) {
                    $pdf->SetXY($text_foreign_x, $text_foreign_y);
                    $pdf->MultiCell(120, 8, ($foreign_purpose_text), 0, 'L');
                }
            }
        }
    }

    // ตรวจสอบกรณี "อื่นๆ"
    if (!empty($presentation_purpose) && $presentation_purpose === 'อื่นๆ') {
        // ตำแหน่งเครื่องหมายถูกและข้อความสำหรับ "อื่นๆ"
        $checkmark_other_x = 39;
        $checkmark_other_y = 142;
        $text_other_x = 70;
        $text_other_y = 142;

        // แสดงเครื่องหมายถูก
        $pdf->Image(__DIR__ . '/correct1.png', $checkmark_other_x, $checkmark_other_y, 5, 5);

        // ตรวจสอบว่ามีข้อความเพิ่มเติมจาก other_purpose_text หรือไม่
        if (!empty($purpose_text)) {
            $pdf->SetXY($text_other_x, $text_other_y);
            $pdf->MultiCell(120, 8, ($purpose_text), 0, 'L'); // แสดงข้อความที่กรอก
        }
    }

    $max_chars_first_line = 110; // ความยาวสูงสุดสำหรับบรรทัดแรก
    $max_chars_other_lines = 120; // ความยาวสูงสุดสำหรับบรรทัดถัดไป

    // ตำแหน่งเริ่มต้น
    $first_line_x = 70; // ตำแหน่ง X สำหรับบรรทัดแรก
    $first_line_y = 165.5; // ตำแหน่ง Y สำหรับบรรทัดแรก
    $other_lines_x = 30; // ตำแหน่ง X สำหรับบรรทัดถัดไป (เยื้องเข้ามา)
    $line_height = 8; // ความสูงระหว่างบรรทัด

    // แยกข้อความตามการกด Enter (\n)
    $lines = explode("\n", $benefit_of_use);
    $current_y = $first_line_y; // ตำแหน่ง Y เริ่มต้น

    foreach ($lines as $index => $line) {
        // ตัดข้อความยาวเกินในแต่ละบรรทัด
        $wrapped_lines = explode("\n", wordwrap($line, $index === 0 ? $max_chars_first_line : $max_chars_other_lines, "\n", true));

        foreach ($wrapped_lines as $wrapped_index => $wrapped_line) {
            // กำหนดตำแหน่ง X
            $current_x = ($index === 0 && $wrapped_index === 0) ? $first_line_x : $other_lines_x;

            // แสดงข้อความ
            $pdf->SetXY($current_x, $current_y);
            $pdf->MultiCell(0, $line_height, $wrapped_line, 0, 'L');

            // ปรับตำแหน่ง Y สำหรับบรรทัดถัดไป
            $current_y += $line_height;
        }
    }


    $attached_documents_positions = [
        'abstract' => ['checkmark_x' => 57, 'checkmark_y' => 190],
        'fullpaper' => ['checkmark_x' => 85, 'checkmark_y' => 190],
        'powerpoint' => ['checkmark_x' => 116, 'checkmark_y' => 190],
        'อื่นๆ' => ['checkmark_x' => 154, 'checkmark_y' => 190, 'text_x' => 167, 'text_y' => 190],
    ];

    if (!empty($attached_documents) && isset($attached_documents_positions[$attached_documents])) {
        $position = $attached_documents_positions[$attached_documents];

        // แสดงเครื่องหมายถูก
        $pdf->Image(__DIR__ . '/correct1.png', $position['checkmark_x'], $position['checkmark_y'], 5, 5);

        // หากเลือก "อื่นๆ" ให้แสดงข้อความเพิ่มเติม
        if ($attached_documents === 'อื่นๆ' && !empty($other_attached_documents_text)) {
            $pdf->SetXY($position['text_x'], $position['text_y']);
            $pdf->MultiCell(120, 8, $other_attached_documents_text, 0, 'L');
        }
    }

    // กำหนดตำแหน่งสำหรับหมายเหตุ
    $notes_x = 45; // ตำแหน่ง X สำหรับข้อความ
    $notes_y = 198; // ตำแหน่ง Y สำหรับข้อความ
    $max_chars_per_line = 120; // จำนวนตัวอักษรสูงสุดต่อบรรทัด
    $line_height = 8; // ระยะห่างระหว่างบรรทัด

    // ใช้ MultiCell เพื่อแสดงข้อความหมายเหตุ
    $pdf->SetXY($notes_x, $notes_y);
    $pdf->MultiCell(0, $line_height, $notes, 0, 'L');
    // กำหนดตำแหน่งสำหรับวันที่
    $date_x = 147; // ตำแหน่ง X
    $date_y = 258;  // ตำแหน่ง Y
    $pdf->SetXY($date_x, $date_y);
    $pdf->Write(0, $date_today); // แสดงวันที่

    // --- ดึงหน้า 3 ---
    $pdf->AddPage();
    $page3 = $pdf->importPage(3);
    $pdf->useTemplate($page3);

    // ตำแหน่งเครื่องหมายถูกและข้อความสำหรับ "ผู้อำนวยการสำนัก"
    $director_positions = [
        'เห็นชอบ' => ['checkmark_x' => 39, 'checkmark_y' => 44],
        'ไม่เห็นชอบ' => ['checkmark_x' => 39, 'checkmark_y' => 55, 'text_x' => 77, 'text_y' => 54],
    ];

    // ตำแหน่งเครื่องหมายถูกและข้อความสำหรับ "ผู้จัดการโครงการ"
    $project_manager_positions = [
        'เห็นชอบ' => ['checkmark_x' => 39, 'checkmark_y' => 150],
        'ไม่เห็นชอบ' => ['checkmark_x' => 39, 'checkmark_y' => 160, 'text_x' => 77, 'text_y' => 160],
    ];

    // แสดงผลสำหรับ "ผู้อำนวยการสำนัก"
    if (!empty($director_approval) && isset($director_positions[$director_approval])) {
        $position = $director_positions[$director_approval];

        // แสดงเครื่องหมายถูก
        $pdf->Image(__DIR__ . '/correct1.png', $position['checkmark_x'], $position['checkmark_y'], 5, 5);

        // หากเลือก "ไม่เห็นชอบ" ให้แสดงเหตุผล
        if ($director_approval === 'ไม่เห็นชอบ' && !empty($director_reason)) {
            $pdf->SetXY($position['text_x'], $position['text_y']);
            $pdf->MultiCell(120, 8, $director_reason, 0, 'L');
        }
    }

    // แสดงผลสำหรับ "ผู้จัดการโครงการ"
    if (!empty($project_manager_approval) && isset($project_manager_positions[$project_manager_approval])) {
        $position = $project_manager_positions[$project_manager_approval];

        // แสดงเครื่องหมายถูก
        $pdf->Image(__DIR__ . '/correct1.png', $position['checkmark_x'], $position['checkmark_y'], 5, 5);

        // หากเลือก "ไม่เห็นชอบ" ให้แสดงเหตุผล
        if ($project_manager_approval === 'ไม่เห็นชอบ' && !empty($project_manager_reason)) {
            $pdf->SetXY($position['text_x'], $position['text_y']);
            $pdf->MultiCell(120, 8, $project_manager_reason, 0, 'L');
        }
    }
    $pdf->SetXY(145, 125);
    $pdf->Write(0, $date_today); // แสดงวันที่

    $pdf->SetXY(145, 230);
    $pdf->Write(0, $date_today); // แสดงวันที่
    // --- ดึงหน้า 4 ---
    $pdf->AddPage();
    $page4 = $pdf->importPage(4);
    $pdf->useTemplate($page4);

    $pdf->SetXY(145, 117);
    $pdf->Write(0, $date_today); // แสดงวันที่
    // ตำแหน่งเครื่องหมายถูกและข้อความสำหรับ "ผู้ร่วมวิจัย"
    $research_collaborator_positions = [
        'เห็นชอบ' => ['checkmark_x' => 39, 'checkmark_y' => 36],
        'ไม่เห็นชอบ' => ['checkmark_x' => 39, 'checkmark_y' => 47, 'text_x' => 77, 'text_y' => 46],
    ];

    // แสดงผลสำหรับ "ผู้ร่วมวิจัย"
    if (!empty($research_collaborator_approval) && isset($research_collaborator_positions[$research_collaborator_approval])) {
        $position = $research_collaborator_positions[$research_collaborator_approval];

        // แสดงเครื่องหมายถูก
        $pdf->Image(__DIR__ . '/correct1.png', $position['checkmark_x'], $position['checkmark_y'], 5, 5);

        // หากเลือก "ไม่เห็นชอบ" ให้แสดงเหตุผล
        if ($research_collaborator_approval === 'ไม่เห็นชอบ' && !empty($research_collaborator_reason)) {
            $pdf->SetXY($position['text_x'], $position['text_y']);
            $pdf->MultiCell(120, 8, $research_collaborator_reason, 0, 'L');
        }
    }
    // ส่งออก PDF
    $pdf->Output('I', 'filled-form.pdf');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
