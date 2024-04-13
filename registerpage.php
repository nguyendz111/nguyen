<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .register-container {
        width: 50%;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .input-group {
        margin-bottom: 10px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"],
    textarea,
    select {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .input-group a {
        display: block;
        text-align: center;
        color: #007bff;
        text-decoration: none;
    }
</style>
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="address">Address:</label><br>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="input-group">
                <label for="gender">Gender:</label><br>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="input-group">
                <input type="submit" name="register" value="Register">
            </div>
            
            <div class="input-group">
                <a href="login.php">Already have an account? Login here</a>
            </div>
        </form>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Student";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        // Xử lý và làm sạch dữ liệu đầu vào
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $address = mysqli_real_escape_string($conn, $address);
        $gender = mysqli_real_escape_string($conn, $gender);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $check_query = "SELECT * FROM users WHERE username='$username'";
        $check_result = $conn->query($check_query);
        if ($check_result->num_rows > 0) {
            echo "Username already exists. Please choose another one.";
        } else {
            // Sử dụng Prepared Statements
            $insert_query = $conn->prepare("INSERT INTO users (username, password, address, gender) VALUES (?, ?, ?, ?)");
            $insert_query->bind_param("ssss", $username, $hashedPassword, $address, $gender);
            if ($insert_query->execute()) {
                echo "Registration successful!";
                // Chuyển hướng sau khi đăng ký thành công
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $insert_query->error;
            }
        }
    }
    $conn->close();
    ?>
</body>
</html>