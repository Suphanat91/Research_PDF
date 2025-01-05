<?php
// session_start(); // ต้องมี session_start() ทุกครั้งที่ต้องการใช้ $_SESSION

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // ถ้าไม่ได้ล็อกอิน ให้กลับไปที่หน้า login
    exit();
}

// ดึงข้อมูลผู้ใช้จาก Session
$logged_in_user = $_SESSION['firstname'] ?? 'Guest'; // ชื่อผู้ใช้
$logged_in_role = $_SESSION['role'] ?? 'User'; // บทบาทผู้ใช้
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "Academic Portal"; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Merriweather', serif;
        min-height: 100vh;
    }
</style>

<body class="bg-gray-50 " style="padding: 0px;">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <nav class="w-64 bg-blue-900 text-white h-screen fixed top-0 z-20">
            <!-- Logo/Brand -->
            <div class="p-6 border-b border-blue-800">
                <h2 class="text-xl font-bold text-center text-white">
                    <i class="fas fa-university mr-2"></i>
                    Academic Portal
                </h2>
            </div>

            <!-- Navigation Links -->
            <div class="mt-6">
                <a href="dashboard_reviewer.php" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors duration-200">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Unreviewed academic article</span>
                </a>
                <a href="Edit_Article_Evaluation_form.php" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors duration-200">
                    <i class="fas fa-file-alt w-5"></i>
                    <span class="ml-3">Edit Article Evaluation</span>
                </a>
                <a href="courses.php" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors duration-200">
                    <i class="fas fa-book w-5"></i>
                    <span class="ml-3">Verified Article</span>
                </a>
                <!-- <a href="edit_article.php?id=<?php echo $article['id']; ?>"
                    class="inline-flex items-center justify-center px-4 py-2.5 text-yellow-600 hover:text-yellow-700 bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 rounded-lg font-medium transition duration-200 group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 114.243 4.243L8.475 20.475a3 3 0 01-1.414.829l-4.242.848a1 1 0 01-1.2-1.2l.848-4.242a3 3 0 01.829-1.414L15.232 5.232z"></path>
                    </svg>
                    Edit Article
                </a> -->
               
                <!-- <a href="library.php" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors duration-200">
                    <i class="fas fa-books w-5"></i>
                    <span class="ml-3">Library</span>
                </a>
                <a href="calendar.php" class="flex items-center px-6 py-3 hover:bg-blue-800 transition-colors duration-200">
                    <i class="fas fa-calendar-alt w-5"></i>
                    <span class="ml-3">Academic Calendar</span>
                </a> -->
            </div>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-64 bg-blue-950">
                <div class="flex items-center px-4 py-4">
                    <img src="Sample_User_Icon.png" alt="Profile" class="w-10 h-10 rounded-full bg-blue-800">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($logged_in_user); ?></p>
                        <p class="text-xs text-blue-200"><?php echo htmlspecialchars($logged_in_role); ?></p>
                    </div>
                </div>
                <!-- <a href="logout.php" class="text-gray-600 hover:text-red-600">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a> -->

            </div>
            <!-- <a href="logout.php" class="flex items-center px-6 py-3 hover:bg-red-800 transition-colors duration-200">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="ml-3">Logout</span>
            </a> -->

        </nav>

        <!-- Main Content -->
        <div class="flex-1 ml-64 flex flex-col min-h-screen">
            <!-- Top Header -->
            <header class="bg-white shadow-sm w-full sticky top-0 z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-serif font-semibold text-gray-800">
                        <?php echo $header ?? "Academic Dashboard"; ?>
                    </h1>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-bell text-gray-600"></i>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-search text-gray-600"></i>
                        </button>
                        <div class="border-l pl-4 ml-4">
                            <select class="bg-transparent text-sm text-gray-600">
                                <option>English</option>
                                <option>ภาษาไทย</option>
                            </select>
                        </div>
                        <a href="logout.php" class="text-gray-600 hover:text-red-600">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>

                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-grow p-6 bg-gray-50">
                <div class="rounded-lg shadow-sm p-6">
                    <?php echo $content ?? "Welcome to the Academic Portal"; ?>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600 text-sm">
                            &copy; <?php echo date('Y'); ?> Academic Institution. All rights reserved.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-500 hover:text-blue-900">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-900">
                                <i class="fas fa-globe"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-900">
                                <i class="fas fa-phone"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>