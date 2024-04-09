<?php
/**@var mysqli $conn*/
session_start();
include 'includes/DB.php'; // Your database connection file

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verify password
        if (password_verify($password, $user['Password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['UserID']; // Use the correct column name
            $_SESSION['username'] = $username;
            echo "Login successful!";
            $_SESSION['logged_in'] = true; // Set this when the user logs in
            $_SESSION['user_id'] = $user['UserID'];
            header("Location: index.php");
            // exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
}
?>
<?php include 'includes/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<form action="login.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>
</body>
</html>
