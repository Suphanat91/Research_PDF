<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload
use setasign\Fpdi\Fpdi;

// เริ่ม session และเชื่อมต่อฐานข้อมูล
session_start();
require 'db.php';

// ตรวจสอบการเข้าสู่ระบบและสิทธิ์ของผู้ใช้
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // เปลี่ยนเส้นทางไปหน้า index หากไม่ใช่ admin
    exit();
};

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $article_id = $_GET['id']; // รับ ID ของบทความจาก GET

    // Query ดึงข้อมูลจากตาราง committee_evaluation ตาม articles_id
    $stmt = $pdo->prepare("SELECT * FROM committee_evaluation WHERE articles_id = ?");
    $stmt->execute([$article_id]);
    $evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evaluation) {
        die("Committee evaluation not found for article ID $article_id");
    }

    // ตำแหน่งสำหรับแต่ละหัวข้อ
    $position_map = [
        'appropriateness_of_presenter' => [
            'เหมาะสม' => ['x' => 128, 'y' => 44],
            'ไม่เหมาะสม' => ['x' => 153, 'y' => 44],
        ],
        'appropriateness_of_location' => [
            'เหมาะสม' => ['x' => 128, 'y' => 52],
            'ไม่เหมาะสม' => ['x' => 153, 'y' => 52],
        ],
        'overall_decision' => [
            'เห็นชอบ' => ['x' => 128, 'y' => 74],
            'ไม่เห็นชอบ' => ['x' => 153, 'y' => 74],
        ],
    ];

    // โหลด PDF template
    $pdf = new Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile(__DIR__ . '/template2.pdf');
    $template = $pdf->importPage(2);
    $pdf->useTemplate($template);

    // เพิ่มฟอนต์
    $pdf->AddFont('SarabunPSK', '', 'THSarabunNew.php');
    $pdf->SetFont('SarabunPSK', '', 16);

    // วาดเครื่องหมายถูกสำหรับแต่ละหัวข้อ
    foreach ($position_map as $key => $options) {
        $value = $evaluation[$key] ?? '';
        if (isset($options[$value])) {
            $pdf->Image(__DIR__ . '/correct1.png', $options[$value]['x'], $options[$value]['y'], 5, 5);
        }
    }

    // เพิ่มวันที่ใน PDF
    function thaiDate($date) {
        $thai_months = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
            4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
            7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
            10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $year = date('Y', strtotime($date)) + 543;
        $month = $thai_months[date('n', strtotime($date))];
        $day = date('j', strtotime($date));
        return "$day $month $year";
    }

    $current_date_thai = thaiDate(date('Y-m-d'));
    // $pdf->SetXY(130, 200); // ตำแหน่งวันที่
    // $pdf->Write(0, $current_date_thai);

    // ส่งออก PDF
    $pdf->Output('I', "committee_evaluation_$article_id.pdf");
} else {
    echo "Invalid request!";
}
?>