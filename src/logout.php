<?php
// เริ่มต้น Session
session_start();

// ลบข้อมูล Session ทั้งหมด
session_unset();
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้า Login
header("Location: index.php");
exit();
?>
