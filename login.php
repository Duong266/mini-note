<?php
require 'config.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không chính xác!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
            <div class="w-14 h-14 bg-blue-600 rounded-2xl mx-auto flex items-center justify-center text-white font-bold text-2xl shadow-lg mb-4">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Chào mừng trở lại!</h1>
            <p class="text-gray-500 mt-2 text-sm">Vui lòng đăng nhập để xem ghi chú của bạn.</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-5">
            <!-- Ô nhập Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5" for="username">Tên đăng nhập</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="username" name="username" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition shadow-sm outline-none bg-gray-50 focus:bg-white" 
                           placeholder="Nhập tên đăng nhập">
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
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition shadow-sm outline-none bg-gray-50 focus:bg-white" 
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                Đăng nhập
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-600">
            Bạn chưa có tài khoản? 
            <a href="register.php" class="font-semibold text-blue-600 hover:text-blue-500 transition">
                Đăng ký ngay
            </a>
        </div>

    </div>

</body>
</html>