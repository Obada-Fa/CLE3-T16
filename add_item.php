<?php
session_start();
require_once 'includes/DB.php'; // Adjust the path as needed to your DB.php file

$message = '';

// Mapping from category IDs to table names
$tableMap = [
    1 => 'feelings',
    2 => 'needs',
    3 => 'belongings',
    4 => 'identitystatements'
];

try {
    $categories = FetchDataFromTable('Categories');
} catch (Exception $e) {
    die("Error fetching categories: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryID = $_POST['category_id'];
    $tableName = $tableMap[$categoryID] ?? null; // Determine the table name based on the selected category ID

    if ($tableName === null) {
        $message = "Invalid category selected.";
    } else {
        $itemData = [
            'CategoryID' => $categoryID, // Assuming each table has a CategoryID field
            'Description' => $_POST['description'],
            'Emoji' => $_POST['emoji'],
        ];

        try {
            InsertData($tableName, $itemData);
            $message = "Item added successfully!";
        } catch (Exception $e) {
            $message = "Error adding item: " . $e->getMessage();
        }
    }
}

$categoryMap = [
    1 => 'Ik voel',
    2 => 'Ik wil',
    3 => 'Ik heb',
    4 => 'Ik ben'
];
?>
<?php include 'includes/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Item</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="https://unpkg.com/picmo"></script>
    <script src="JS/script.js" defer></script>

</head>
<body>

<h1>Add New Item</h1>
<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>
<form action="add_item.php" method="post">
    <label for="category_id">Category:</label><br>
    <select id="category_id" name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo htmlspecialchars($category['CategoryID']); ?>">
                <?php echo htmlspecialchars($categoryMap[$category['CategoryID']] ?? 'Unknown'); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="description">Description:</label><br>
    <input type="text" id="description" name="description" required><br>

    <label for="emoji">Emoji:</label><br>
    <input type="text" id="emoji" name="emoji" readonly style="width: 100px; cursor: pointer;" placeholder="Choose emoji" required><br><br>

    <input type="submit" value="Add Item">
</form>
</body>
</html>
