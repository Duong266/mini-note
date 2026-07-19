<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$search_query = "";
$keyword = "";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $search_query = "AND (title LIKE '%$keyword%' OR content LIKE '%$keyword%')";
}

$sql = "SELECT * FROM notes WHERE user_id = $user_id $search_query";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Note - Ghi chú của tôi</title>
    <!-- Tải Tailwind CSS qua CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tải Font Awesome cho Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font chữ Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#f0f2f5] text-gray-800 h-screen flex overflow-hidden">

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
                <a href="index.php" class="flex items-center px-3 py-3 bg-blue-50 text-blue-700 rounded-xl mb-2 transition hover:bg-blue-100">
                    <i class="fa-solid fa-lightbulb text-lg w-6 text-center"></i>
                    <span class="hidden md:block ml-3 font-medium">Ghi chú của tôi</span>
                </a>
            </nav>
        </div>

        <!-- Nút Đăng xuất -->
        <div class="p-4 border-t border-gray-100">
            <a href="logout.php" class="flex items-center px-3 py-2 text-gray-500 rounded-xl hover:bg-red-50 hover:text-red-600 transition">
                <i class="fa-solid fa-right-from-bracket text-lg w-6 text-center"></i>
                <span class="hidden md:block ml-3 font-medium">Đăng xuất</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen relative">
        <!-- HEADER -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 justify-between shrink-0">
            <!-- Form Tìm kiếm truyền tham số GET về chính file index.php -->
            <form method="GET" action="index.php" class="flex-1 max-w-2xl relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                </div>
                <!-- Giữ lại từ khóa tìm kiếm trên ô input -->
                <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm kiếm ghi chú..." 
                       class="block w-full pl-11 pr-4 py-2.5 bg-gray-100 border-transparent rounded-full text-sm placeholder-gray-500 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 transition shadow-sm outline-none">
            </form>
            
            <!-- User Avatar -->
            <div class="ml-4 w-9 h-9 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-semibold shadow-sm cursor-pointer">
                U
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8 no-scrollbar relative">
            
            <div class="max-w-2xl mx-auto mb-10">
                <!-- Form POST dữ liệu sang file create.php -->
                <form method="POST" action="create.php" class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden transition-shadow focus-within:shadow-lg">
                    <input type="text" name="title" placeholder="Tiêu đề" required
                           class="w-full px-5 pt-4 pb-2 text-lg font-semibold text-gray-800 placeholder-gray-400 outline-none">
                    <textarea name="content" placeholder="Tạo ghi chú..." rows="3" required
                              class="w-full px-5 py-2 text-gray-600 placeholder-gray-500 outline-none resize-none no-scrollbar"></textarea>
                    
                    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                            Lưu ghi chú
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <!-- Vòng lặp in ra các note -->
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-md hover:border-gray-300 transition relative flex flex-col min-h-[160px]">
                            <!-- Cố tình in trực tiếp không qua bộ lọc để tạo lỗ hổng XSS (Cross-Site Scripting) -->
                            <h3 class="font-bold text-gray-800 text-lg mb-2"><?= $row['title'] ?></h3>
                            <p class="text-gray-600 text-sm flex-1 whitespace-pre-wrap line-clamp-4"><?= $row['content'] ?></p>
                            
                            <!-- Các nút Action Sửa / Xóa (Truyền ID lên URL) -->
                            <div class="mt-4 pt-3 border-t border-gray-50 flex justify-end gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition" title="Sửa">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600 transition" title="Xóa">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-full text-center py-10">
                        <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3 block"></i>
                        <p class="text-gray-500">Chưa có ghi chú nào. Hãy tạo ghi chú đầu tiên của bạn!</p>
                    </div>
                <?php endif; ?>

            </div>
            
            <!-- <p class="text-center text-gray-400 text-xs mt-10">Mini Note Application - Internship Project</p> -->
        </div>
    </main>
</body>
</html>