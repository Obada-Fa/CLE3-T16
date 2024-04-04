
<?php
require_once 'includes/DB.php'; // Adjust the path as needed to reach DB.php from your current location

try {
    $feelingsData = FetchDataFromTable('Feelings');
} catch (Exception $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feelings List</title>
</head>
<body>
    <h1>Feelings List</h1>
    <?php if (!empty($feelingsData)): ?>
        <ul>
            <?php foreach ($feelingsData as $feeling): ?>
                <li><?php echo htmlspecialchars($feeling['OptionalDescription']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No feelings found.</p>
    <?php endif; ?>
</body>
</html>
