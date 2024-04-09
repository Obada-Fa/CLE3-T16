<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar">
    <a href="./index.php" class="logo">
        <img src="./img/logo.png" alt="SpeakEase">
    </a>
    <div class="navbar-right">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <a href="./add_item.php">Add item</a>
            <a href="./logout.php">Logout</a>
        <?php else: ?>
            <a href="./register.php">Register</a>
            <a href="./login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>
