<?php
require_once 'DB.php'; // Make sure this path correctly points to where your DB.php file is located.

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    try {
        $data = FetchDataFromTable($category);
        echo json_encode(["success" => true, "data" => $data]);
    } catch (Exception $e) {
        // If there's an error (like an invalid table name), return an error message in JSON format
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No category specified"]);
}
?>
