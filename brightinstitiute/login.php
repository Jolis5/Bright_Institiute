<?php
// بدء الجلسة
session_start();

// التحقق من إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // الاتصال بقاعدة البيانات
  $conn = new mysqli("localhost", "root", "", "brightinstitiute");
  if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
  }

  // استقبال البيانات
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);

  // استخدام prepared statement لتجنب SQL Injection
  $stmt = $conn->prepare("SELECT id, password FROM students WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // تحقق من كلمة المرور المشفّرة
    if (password_verify($password, $user['password'])) {
      $_SESSION["user"] = $email;
      header("Location: courses_details.html");
      exit();
    } else {
      echo "<script>alert('كلمة المرور غير صحيحة'); window.location.href = 'login.php';</script>";
      exit();
    }
  } else {
    echo "<script>alert('البريد الإلكتروني غير مسجل'); window.location.href = 'login.php';</script>";
    exit();
  }

  $stmt->close();
  $conn->close();
}
?>
