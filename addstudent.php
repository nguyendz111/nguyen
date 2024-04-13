<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $rollno = $_POST['id'];
    $username = $_POST['username'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    
    // Basic validation
    if (empty($rollno) || empty($username) || empty($address) || empty($gender)) {
        die("Please fill in all fields.");
    }

    // Database connection
    $hostname = "localhost";
    $db_username = "root"; // Renamed to avoid variable overwriting
    $db_password = "";
    $database = "student";

    $conn = new mysqli($hostname, $db_username, $db_password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if username already exists using prepared statement
    $check_username_query = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($check_username_query);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        die("Username already exists. Please choose a different username.");
    }

    $stmt_check->close();

    // Insert new user using prepared statement
    $insert_query = "INSERT INTO users (id, username, address, gender) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($insert_query);
    $stmt_insert->bind_param("ssss", $rollno, $username, $address, $gender);

    if ($stmt_insert->execute()) {
        // Redirect user after successful insertion
        header("Location: student.php");
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }

    $stmt_insert->close();
    $conn->close();
}
?>
