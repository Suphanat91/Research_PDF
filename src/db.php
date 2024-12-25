<?php
// ใช้ค่า environment variables ที่กำหนดใน docker-compose.yml
$host = getenv('DB_HOST') ?: 'database'; // ใช้ชื่อ service จาก docker-compose
$dbname = getenv('DB_DATABASE') ?: 'app_db';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'root';

try {
    // สร้างการเชื่อมต่อกับฐานข้อมูล
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);

    // ตั้งค่าการแสดงข้อผิดพลาด
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "เชื่อมต่อฐานข้อมูลสำเร็จ!";
} catch (PDOException $e) {
    // แสดงข้อผิดพลาดถ้าเชื่อมต่อไม่สำเร็จ
    echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
}
?>