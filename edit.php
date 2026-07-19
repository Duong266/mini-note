<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = "UPDATE notes SET title='$title', content='$content' WHERE id=$id AND user_id=$user_id";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit;
}

$sql = "SELECT * FROM notes WHERE id=$id";
$result = mysqli_query($conn, $sql);
$note = mysqli_fetch_assoc($result);
if (!$note) {
    die("Không tìm thấy ghi chú!");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa ghi chú - Mini Note</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f0f2f5] text-gray-800 h-screen flex overflow-hidden">

    <!-- SIDEBAR (Giống trang chủ) -->
    <aside class="w-20 md:w-64 bg-white border-r border-gray-200 flex flex-col justify-between transition-all duration-300">
        <div>
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center md:justify-start md:px-6 border-b border-gray-100">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <span class="hidden md:block ml-3 font-bold text-xl text-gray-800 tracking-tight">Mini Note</span>
            </div>
            
            <!-- Menu -->
            <nav class="mt-6 px-3">
                <a href="index.php" class="flex items-center px-3 py-3 text-gray-600 rounded-xl mb-2 transition hover:bg-gray-50">
                    <i class="fa-solid fa-arrow-left text-lg w-6 text-center"></i>
                    <span class="hidden md:block ml-3 font-medium">Quay lại trang chủ</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen relative">
        
        <!-- HEADER -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 justify-between shrink-0 shadow-sm z-10">
            <h1 class="text-xl font-semibold text-gray-800">Chỉnh sửa ghi chú</h1>
            <!-- User Avatar -->
            <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-semibold shadow-sm cursor-pointer">
                U
            </div>
        </header>

        <!-- KHU VỰC FORM CHỈNH SỬA -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 flex justify-center items-start pt-10">
            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                
                <form method="POST" action="edit.php?id=<?= $id ?>" class="flex flex-col">
                    
                    <!-- Tiêu đề Note. Cố tình in trực tiếp để sinh lỗi XSS attribute -->
                    <input type="text" name="title" value="<?= $note['title'] ?>" placeholder="Tiêu đề ghi chú..." required
                           class="w-full px-8 pt-8 pb-4 text-3xl font-bold text-gray-800 placeholder-gray-300 outline-none border-b border-gray-100">
                    
                    <!-- Nội dung Note. Cố tình in trực tiếp để sinh lỗi Stored XSS -->
                    <textarea name="content" placeholder="Nội dung chi tiết..." rows="12" required
                              class="w-full px-8 py-6 text-gray-700 placeholder-gray-400 outline-none resize-none text-lg leading-relaxed"><?= $note['content'] ?></textarea>
                    
                    <!-- Footer Form (Nút Hủy / Lưu) -->
                    <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 items-center">
                        <a href="index.php" class="px-6 py-2.5 text-gray-600 hover:bg-gray-200 hover:text-gray-800 font-medium rounded-lg transition duration-200">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 shadow-md flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                        </button>
                    </div>
                    
                </form>

            </div>
        </div>
        
    </main>
</body>
</html>