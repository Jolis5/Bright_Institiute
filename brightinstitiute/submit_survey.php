<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

// اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استقبال بيانات الاستبيان
$user_email = $_SESSION['user'];
$rating = $conn->real_escape_string($_POST['rating']);
$instructor_opinion = $conn->real_escape_string($_POST['instructor_opinion']);

// حفظ في جدول survey (لازم يكون موجود)
$sql = "INSERT INTO survey (user_email, rating, instructor_opinion) VALUES ('$user_email', '$rating', '$instructor_opinion')";

if ($conn->query($sql) === TRUE) {
    echo "تم إرسال الاستبيان بنجاح. شكراً لمشاركتك!";
} else {
    echo "حدث خطأ: " . $conn->error;
}

$conn->close();
?>
<br><br>
<a href="index.html">العودة للرئيسية</a>
