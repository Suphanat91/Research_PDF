<?php
session_start();

// ฟังก์ชันตรวจสอบการล็อกอิน
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// ฟังก์ชันบังคับให้ล็อกอิน
function require_login() {
    if (!is_logged_in()) {
        header("Location: /index.php"); // ส่งผู้ใช้ไปหน้า login
        exit();
    }
}