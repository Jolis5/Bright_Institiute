<?php
// إعدادات قاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brightinstitiute";

session_start();

$success_message = "";
$error_message = "";

if (isset($_GET['success'])) {
    $success_message = urldecode($_GET['success']);
}
if (isset($_GET['error'])) {
    $error_message = urldecode($_GET['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $id_number = trim($_POST['id_number']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    if (empty($full_name) || empty($phone) || empty($id_number) || empty($email) || empty($pass)) {
        header("Location: signup.php?error=" . urlencode("جميع الحقول مطلوبة."));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=" . urlencode("البريد الإلكتروني غير صالح."));
        exit();
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // تحقق من وجود البريد الإلكتروني مسبقًا في
