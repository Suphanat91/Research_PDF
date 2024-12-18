<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload

use setasign\Fpdi\Fpdi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $additional_comments = $_POST['additional_comments'] ?? ''; // รับข้อความความคิดเห็น
    $scores = [
        'article_score' => $_POST['article_score'] ?? '',
        'work_quality' => $_POST['work_quality'] ?? '',
        'writing_quality' => $_POST['writing_quality'] ?? '',
        'practical_benefit' => $_POST['practical_benefit'] ?? '',
        'innovation_score' => $_POST['innovation_score'] ?? ''

    ];
    $additional_comments = iconv('UTF-8', 'cp874', $additional_comments);

    // $thai_months = iconv('UTF-8', 'cp874', $thai_months);
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

    // วนลูปแสดงเครื่องหมายถูก
    foreach ($scores as $key => $score) {
        if (isset($score_positions[$key])) {
            drawCheckmark($pdf, $score, $score_positions[$key], $x_positions);
        }
    }
    // ตำแหน่งสำหรับ "ความคิดเห็น"
    $comments_x = 30;      // ตำแหน่ง X (เริ่มจากด้านซ้าย)
    $comments_y = 177;     // ตำแหน่ง Y (ความสูงจากด้านบน)
    $comments_width = 150; // ความกว้างของพื้นที่ข้อความ
    $line_height = 8;      // ความสูงระหว่างบรรทัด
    $indent_space = "     "; // จำนวนช่องว่างสำหรับย่อหน้า (4 ช่องว่าง)

    // แยกข้อความเป็นบรรทัดเพื่อเพิ่มย่อหน้า
    if (!empty($additional_comments)) {
        $lines = explode("\n", wordwrap($additional_comments, 90, "\n", true)); // ตัดข้อความตามจำนวนอักษร

        // แสดงข้อความใน PDF
        foreach ($lines as $index => $line) {
            $pdf->SetXY($index === 0 ? $comments_x + 5 : $comments_x, $comments_y); // บรรทัดแรกขยับ X เพื่อย่อหน้า
            $line_with_indent = $index === 0 ? $indent_space . $line : $line; // เพิ่มย่อหน้าที่บรรทัดแรก
            $pdf->MultiCell($comments_width, $line_height, $line_with_indent, 0, 'L');
            $comments_y += $line_height; // เลื่อน Y สำหรับบรรทัดถัดไป
        }
    }
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

    // แปลงวันที่เป็นภาษาไทยและแปลงเป็น cp874
    $current_date_thai = thaiDate(date('Y-m-d'));
    $current_date_thai_cp874 = iconv('UTF-8', 'cp874', $current_date_thai);

    // ตำแหน่งแสดงวันที่ใน PDF
    $date_x = 143; // ตำแหน่ง X
    $date_y = 260.5;  // ตำแหน่ง Y

    $pdf->SetXY($date_x, $date_y);
    $pdf->SetFont('SarabunPSK', '', 16);
    $pdf->Write(0, $current_date_thai_cp874); // แสดงวันที่ใน PDF
    // ส่งออก PDF
    $pdf->Output('I', 'article_evaluation.pdf');
} else {
    echo "Method not allowed!";
}
