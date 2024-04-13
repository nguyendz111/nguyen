<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        
        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }
        
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        
        th {
            background-color: #007bff;
            color: #fff;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "student";

    // Create a connection
    $conn = mysqli_connect($hostname, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Execute the SELECT query
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Error executing the query: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
    <h2>Students</h2>
    <!-- Add Student Form -->
    <form method="post" action="addstudent.php">
        <label for="id">Roll No:</label>
        <input type="text" id="id" name="id"><br><br>
        <label for="username">Name:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address"><br><br>
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender"><br><br>
        <button type="submit" class="btn add-student">Add Student</button>
    </form>
    <!-- Students Table -->
    <table>
        <tr>
            <th>Roll No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td>
                    <a href="editstudent.php?id=<?php echo $row['id']; ?>">Edit</a> 
                    <a href="deletestudent.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
