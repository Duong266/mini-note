<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO notes (user_id, title, content) VALUES ($user_id, '$title', '$content')";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
?>
<form method="POST">
    <h2>Tạo Note</h2>
    Tiêu đề: <input type="text" name="title"><br>
    Nội dung: <textarea name="content"></textarea><br>
    <button type="submit">Lưu</button>
</form>