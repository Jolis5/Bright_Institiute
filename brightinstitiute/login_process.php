<?php
session_start();

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "bright_institute"); // تأكد من اسم قاعدة البيانات

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // جلب بيانات الطالب بناءً على البريد الإلكتروني
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // التحقق من كلمة المرور المشفّرة
        if (password_verify($password, $student['password'])) {
            $_SESSION["user"] = $student['email'];
            header("Location: courses_details.html");
            exit();
        } else {
            echo "<script>
                alert('كلمة المرور غير صحيحة');
                window.location.href = 'login.html';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('البريد الإلكتروني غير مسجل');
            window.location.href = 'login.html';
        </script>";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
