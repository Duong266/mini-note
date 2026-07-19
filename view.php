<?php
require 'config.php';
$id = $_GET['id'];
$sql = "SELECT * FROM notes WHERE id = $id";
$result = mysqli_query($conn, $sql);
$note = mysqli_fetch_assoc($result);
?>
<h2><?= $note['title'] ?></h2>
<p><?= $note['content'] ?></p>
<a href="index.php">Quay lại</a>