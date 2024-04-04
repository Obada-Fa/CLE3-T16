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
?>
