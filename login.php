<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .login-container {
            width: 300px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 7px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Form</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username">
            </div>
            <div class="input-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password">
            </div>
            <div class="input-group">
                <input type="submit" value="Login">
            </div>
            <div class="links">
                Don't have an account? <a href="registerpage.php">Sign Up Now</a>
            </div>
        </form>
    </div>

    <?php
    session_start();
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'student') or die("Can not connect database" . mysqli_connect_error());

    // Xử lý dữ liệu đăng nhập
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra thông tin đăng nhập
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
        // Đăng nhập thành công
        echo "Login successful!";
        header("Location: student.php"); // Chuyển hướng sang trang sau khi đăng nhập thành công
        exit();
            } else {
                // Sai mật khẩu
                echo "Invalid password.";
            }
        } else {
            // Tài khoản không tồn tại
            echo "User not found.";
        }
    }

    // Đóng kết nối
    mysqli_close($conn);
    ?>
</body>
</html>