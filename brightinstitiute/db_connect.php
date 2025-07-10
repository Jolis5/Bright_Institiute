<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "bright_institute"; // غيّريه إذا كان اسم قاعدة البيانات مختلف

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}
?>
