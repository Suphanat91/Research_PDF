<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload

use setasign\Fpdi\Fpdi;

// เชื่อมต่อฐานข้อมูล
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $article_id = $_GET['id']; // รับ ID ของบทความจาก GET

    // Query ดึงข้อมูลจากตาราง evaluations ตาม articles_id
    $stmt = $pdo->prepare("
        SELECT * FROM evaluations WHERE articles_id = ?
    ");
    $stmt->execute([$article_id]);
    $evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if (!$evaluation) {
        die("Evaluation not found for article ID $article_id");
    }

    // แปลงข้อมูลเป็นภาษาไทย
    $evaluation = array_map(function ($value) {
        return iconv('UTF-8', 'cp874', $value);
    }, $evaluation);

    // ตำแหน่งเครื่องหมายถูกสำหรับแต่ละหัวข้อ
    $score_positions = [
        'article_score' => 72,
        'work_quality' => 87,
        'writing_quality' => 102,
        'practical_benefit' => 117,
        'innovation_score' => 132
    ];

    $x_positions = [
        '5' => 138,
        '4' => 147.5,
        '3' => 157,
        '2' => 166,
        '1' => 176
    ];

    // ฟังก์ชันแสดงเครื่องหมายถูก
    function drawCheckmark($pdf, $score, $base_y, $x_positions)
    {
        if (!empty($score) && isset($x_positions[$score])) {
            $pdf->Image(__DIR__ . '/correct1.png', $x_positions[$score], $base_y, 5, 5);
        }
    }

    // โหลด PDF template
    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile(__DIR__ . '/template2.pdf');
    $template = $pdf->importPage(1);
    $pdf->useTemplate($template);

    // เพิ่มฟอนต์ภาษาไทย
    $pdf->AddFont('SarabunPSK', '', 'THSarabunNew.php');
    $pdf->SetFont('SarabunPSK', '', 16);

    // วนลูปแสดงเครื่องหมายถูกสำหรับคะแนน
    foreach ($score_positions as $key => $base_y) {
        $score = $evaluation[$key] ?? '';
        drawCheckmark($pdf, $score, $base_y, $x_positions);
    }

    // เพิ่มความคิดเห็นใน PDF
    $comments_x = 30;
    $comments_y = 177;
    $comments_width = 150;
    $line_height = 8;

    $additional_comments = $evaluation['additional_comments'] ?? '';
    if (!empty($additional_comments)) {
        $lines = explode("\n", wordwrap($additional_comments, 90, "\n", true));
        foreach ($lines as $index => $line) {
            $pdf->SetXY($comments_x, $comments_y + ($index * $line_height));
            $pdf->MultiCell($comments_width, $line_height, $line, 0, 'L');
        }
    }
    // คำนวณผลรวมคะแนน
    $total_score = 0;
    foreach ($score_positions as $key => $base_y) {
        $score = $evaluation[$key] ?? 0;
        $total_score += (int)$score;
    }

    // เพิ่มผลรวมคะแนนใน PDF
    $total_score_text = "$total_score";
    $total_score_text_cp874 = iconv('UTF-8', 'cp874', $total_score_text);

    // กำหนดตำแหน่งสำหรับแสดงผลรวมคะแนน
    $pdf->SetXY(155, 155); // ตำแหน่ง X และ Y (ปรับตามที่ต้องการ)
    $pdf->Write(0, $total_score_text_cp874);
    // ฟังก์ชันแปลงวันที่เป็นภาษาไทย
    function thaiDate($date)
    {
        $thai_months = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม'
        ];

        $year = date('Y', strtotime($date)) + 543;
        $month = $thai_months[date('n', strtotime($date))];
        $day = date('j', strtotime($date));

        return "$day $month $year";
    }

    // เพิ่มวันที่ใน PDF
    $current_date_thai = thaiDate(date('Y-m-d'));
    $current_date_thai_cp874 = iconv('UTF-8', 'cp874', $current_date_thai);

    $pdf->SetXY(143, 260.5);
    $pdf->Write(0, $current_date_thai_cp874);

    // ส่งออก PDF
    $pdf->Output('I', "evaluation_article_$article_id.pdf");
} else {
    echo "Invalid Request!";
}
