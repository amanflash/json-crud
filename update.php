<?php

// Function to update data in the database
function updateInDatabase($ID, $Name, $Age, $City)
{
    // Create connection
    $conn = mysqli_connect('localhost', 'root', '', 'test') or die('Cannot connect to MySQL server'); // Connecting to the database

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE students SET name=?, age=?, city=? WHERE id=?");
    $stmt->bind_param("sisi", $Name, $Age, $City, $ID);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        echo "<h3>Data Updated Successfully in Database</h3>";
    } else {
        echo "<h3>Data Update Failed in Database</h3>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}

// Function to update data in the JSON file
function updateInJson($ID, $Name, $Age, $City)
{
    $jsonFile = 'json_data/Student_json_data.json';

    // Read the existing JSON data from the file
    $jsonData = file_get_contents($jsonFile);

    // Decode the JSON data to an associative array
    $data = json_decode($jsonData, true);

    // Loop through the data to find the user with the matching ID
    foreach ($data as &$person) {
        if ($person['ID'] == $ID) {
            // Update the user's data with the new data
            $person['Name'] = $Name;
            $person['Age'] = $Age;
            $person['City'] = $City;
            break;
        }
    }

    // Encode the updated data back to JSON format
    $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Write the updated JSON data back to the file
    if (file_put_contents($jsonFile, $updatedJsonData)) {
        echo "<h3>Data Updated Successfully in JSON</h3>";
    } else {
        echo "<h3>Data Update Failed in JSON</h3>";
    }
}

// Check if all form fields are submitted
if (isset($_POST['ID']) && isset($_POST['Name']) && isset($_POST['Age']) && isset($_POST['City'])) {
    // Update in database
    updateInDatabase($_POST['ID'], $_POST['Name'], $_POST['Age'], $_POST['City']);

    // Update in JSON
    updateInJson($_POST['ID'], $_POST['Name'], $_POST['Age'], $_POST['City']);
} else {
    echo "<h3>All Form Fields are Required</h3>";
}

?>
