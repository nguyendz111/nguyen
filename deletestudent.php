<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Kết nối đến cơ sở dữ liệu
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "student";

    $conn = new mysqli($hostname, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Thực hiện câu lệnh SQL để xóa sinh viên khỏi cơ sở dữ liệu
    $sql = "DELETE FROM users WHERE id=$student_id";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng người dùng sau khi xóa sinh viên thành công
        header("Location: student.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>