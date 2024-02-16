<?php

// Check if ID is provided in the request
if (!isset($_GET['id'])) {
    echo "ID not provided";
    exit;
}

$id = $_GET['id'];

// Delete data from the JSON file
$jsonFile = 'json_data/Student_json_data.json';

// Read the existing JSON data from the file
$jsonData = file_get_contents($jsonFile);

// Decode the JSON data to an associative array
$data = json_decode($jsonData, true);

// Find the index of the data with the provided ID
$index = -1;
foreach ($data as $key => $person) {
    if ($person['ID'] == $id) {
        $index = $key;
        break;
    }
}

// If data with the provided ID is found, remove it from the array
if ($index !== -1) {
    array_splice($data, $index, 1);

    // Encode the updated data back to JSON format
    $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Write the updated JSON data back to the file
    if (file_put_contents($jsonFile, $updatedJsonData)) {
        echo "Data deleted successfully from JSON file<br>";
    } else {
        echo "Failed to delete data from JSON file<br>";
    }
} else {
    echo "Data with ID $id not found in JSON file<br>";
}

// Delete data from the database
$conn = mysqli_connect('localhost', 'root', '', 'test');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SQL statement to delete data by ID
$sql = "DELETE FROM students WHERE ID = ?";

// Prepare and bind parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);

// Execute SQL statement
if ($stmt->execute()) {
    echo "Data deleted successfully from database<br>";
} else {
    echo "Failed to delete data from database: " . $conn->error . "<br>";
}

// Close connection
$stmt->close();
$conn->close();

?>
