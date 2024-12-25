<?php
session_start();
require 'db.php';
// require 'routes.php'; // เรียกไฟล์กำหนด Route

// // เรียกดูไฟล์ที่ต้องการตามเส้นทาง
// $route_file = resolve_route($routes);

// // ตรวจสอบไฟล์ก่อน include
// if (file_exists($route_file)) {
//     include $route_file;
// } else {
//     include 'views/404.php'; // หากไฟล์ไม่มีให้แสดงหน้าข้อผิดพลาด
// }



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ค้นหาผู้ใช้ในฐานข้อมูล
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // เก็บข้อมูลใน session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['role'] = $user['role'];

        // ตรวจสอบ role และเปลี่ยนเส้นทาง
        if ($user['role'] === 'author') {
            header("Location: dashboard.php");
        } elseif ($user['role'] === 'evaluator') {
            header("Location: dashboard_reviewer.php");
        } 
        elseif ($user['role'] === 'admin') {
            header("Location: dashboard_admin.php");}
            else {
            // ถ้า role ไม่ตรง ให้เปลี่ยนไปยังหน้าหลักหรือแสดงข้อความ
            header("Location: index.php");
        }
        exit();
    } else {
        $error_message = "อีเมลหรือรหัสผ่านไม่ถูกต้อง!";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Logo หรือชื่อแอพ -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome</h1>
            <p class="text-gray-600 mt-2">กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ</p>
        </div>

        <!-- แสดงข้อความ error -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <!-- อีเมล -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">อีเมล</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" id="email"
                        class="pl-10 block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2"
                        placeholder="your@email.com" required>
                </div>
            </div>

            <!-- รหัสผ่าน -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">รหัสผ่าน</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password" id="password"
                        class="pl-10 block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2"
                        placeholder="••••••••" required>
                </div>
            </div>

            <!-- ปุ่มเข้าสู่ระบบ -->
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    เข้าสู่ระบบ
                </button>
            </div>
        </form>

        <!-- ลิงก์เพิ่มเติม -->
        <div class="mt-6 text-center text-sm">
            <a href="#" class="text-blue-600 hover:text-blue-800">ลืมรหัสผ่าน?</a>
            <span class="mx-2 text-gray-500">•</span>
            <a href="register.php" class="text-blue-600 hover:text-blue-800">สมัครสมาชิก</a>
        </div>
    </div>
</body>

</html>