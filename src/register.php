<?php
require 'db.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'author';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $error_message = "อีเมลนี้ถูกใช้แล้ว!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$firstname, $lastname, $email, $password, $role])) {
            $success_message = "ลงทะเบียนสำเร็จ!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียน</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Sarabun', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            border: 1px solid #e0e4e8;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e4e8;
        }

        .register-header h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }

        .form-group input {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-size: 15px;
            color: #2c3e50;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-group input:focus {
            border-color: #4a90e2;
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-btn:hover {
            background-color: #34495e;
        }

        .error-message {
            color: #c0392b;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background-color: #fdeaea;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            font-size: 14px;
        }

        .success-message {
            color: #27ae60;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e4e8;
        }

        .login-link a {
            color: #34495e;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .login-link a:hover {
            color: #4a90e2;
        }

        @media (max-width: 480px) {
            .register-container {
                margin: 10px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h2>ระบบลงทะเบียน</h2>
        </div>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="firstname" placeholder="ชื่อ" required>
            </div>
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lastname" placeholder="นามสกุล" required>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="อีเมล" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="รหัสผ่าน" required>
            </div>
            <button type="submit" class="submit-btn">ลงทะเบียน</button>
        </form>
        <div class="login-link">
            <a href="index.php">มีบัญชีอยู่แล้ว? เข้าสู่ระบบ</a>
        </div>
    </div>
</body>

</html>