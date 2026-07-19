<?php
require 'config.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$success_message = "";
$error_message = "";
$is_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $error_message = "Mật khẩu nhập lại không khớp!";
    } else {
        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Tên đăng nhập này đã tồn tại!";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            
            if (mysqli_query($conn, $sql)) {
                $success_message = "Đăng ký tài khoản thành công!";
                $is_success = true; 
            } else {
                $error_message = "Có lỗi xảy ra trong quá trình đăng ký.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-8 border border-gray-100">
        
        <!-- Header của Form -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-indigo-600 rounded-2xl mx-auto flex items-center justify-center text-white font-bold text-2xl shadow-lg mb-4">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Tạo tài khoản mới</h1>
            <p class="text-gray-500 mt-2 text-sm">Bắt đầu ghi chú những ý tưởng tuyệt vời của bạn.</p>
        </div>

        <!-- Khu vực hiển thị khi đăng ký thành công -->
        <?php if ($is_success): ?>
            <div class="text-center bg-green-50 border border-green-200 p-6 rounded-xl mb-2">
                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3 class="text-lg font-bold text-green-800 mb-2"><?= $success_message ?></h3>
                <p class="text-green-600 text-sm mb-6">Tài khoản của bạn đã được tạo. Vui lòng đăng nhập để tiếp tục.</p>
                <a href="login.php" class="inline-flex w-full justify-center py-2.5 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition duration-200">
                    Đăng nhập ngay
                </a>
            </div>
        <?php else: ?>
            <!-- Khu vực thông báo Lỗi -->
            <?php if (!empty($error_message)): ?>
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" class="space-y-5">
                <!-- Ô nhập Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5" for="username">Tên đăng nhập</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" required
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm transition shadow-sm outline-none bg-gray-50 focus:bg-white" 
                               placeholder="Chọn tên đăng nhập">
                    </div>
                </div>

            <!-- Ô nhập Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="password">Mật khẩu</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm transition shadow-sm outline-none bg-gray-50 focus:bg-white" 
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Ô nhập lại Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="confirm_password">Nhập lại mật khẩu</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-shield-halved text-gray-400"></i>
                    </div>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm transition shadow-sm outline-none bg-gray-50 focus:bg-white" 
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                Đăng ký tài khoản
            </button>
        </form>

        <!-- Nút chuyển sang trang đăng nhập -->
        <div class="mt-8 text-center text-sm text-gray-600">
            Bạn đã có tài khoản? 
            <a href="login.php" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">
                Đăng nhập ngay
            </a>
        </div>
        <?php endif; ?>

    </div>

</body>
</html>