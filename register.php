<?php
session_start();
include 'includes/DB.php'; // Your database connection file

if (isset($_POST['register'])) {
    // Ensure the field names match your database schema
    $userData = [
        'Username' => $_POST['username'],
        'Email' => $_POST['email'],
        'Password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ];

    try {
        // The function name should be the one you've defined for inserting data
        InsertData('users', $userData); // Assuming your function is named dynamicInsert
        // Redirect to login or some other page after successful registration
        header("Location: login.php");
        exit;
    } catch (Exception $e) {
        // Handle the exception, such as displaying an error message
        echo 'Registration failed: ',  $e->getMessage(), "\n";
    }
}
?>
<?php include 'includes/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>
<form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="register">Register</button>
</form>
</body>
</html>
