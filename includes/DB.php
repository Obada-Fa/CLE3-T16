<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "speakease";

// Create a global MySQLi connection
global $conn;
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
function FetchDataFromTable($tableName){
    global $conn; // Use the global connection

    // Validate the table name to prevent SQL injection
    $allowedTables = ['Feelings', 'Needs', 'Belongings', 'IdentityStatements', 'Categories'];
    if (!in_array($tableName, $allowedTables)) {
        throw new InvalidArgumentException("Invalid table name provided.");
    }

    // Correctly concatenate the SQL statement
    $sql = "SELECT * FROM `$tableName`";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error executing query: " . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

function InsertData($tableName, $data) {
    global $conn; // Use the global connection

    // Check if the table name is allowed to prevent SQL injection
    $allowedTables = ['users', 'items', 'feelings', 'needs', 'belongings', 'identitystatements', 'categories'];
    if (!in_array($tableName, $allowedTables)) {
        throw new InvalidArgumentException("Invalid table name provided.");
    }

    // Create placeholders for the prepared statement
    $placeholders = implode(',', array_fill(0, count($data), '?'));

    // Start building the SQL statement
    $columns = implode(", ", array_keys($data));
    $sql = "INSERT INTO `$tableName` ($columns) VALUES ($placeholders)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Dynamically bind the parameters from the data array
    $types = str_repeat('s', count($data)); // Assuming all inputs are strings
    $stmt->bind_param($types, ...array_values($data));

    if ($stmt->execute()) {
        return $stmt->insert_id; // Returns the auto generated id used in the latest query
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
}


?>
