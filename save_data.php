<?php

// Function to insert data into the database and return the generated ID
function insertIntoDatabaseAndGetID($Name, $Age, $City)
{
    // Create connection
    $conn = mysqli_connect('localhost', 'root', '', 'test') or die('Cannot connect to MySQL server'); // Connecting to the database

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO students (name, age, city) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $Name, $Age, $City);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        // Return the auto-generated ID
        return $conn->insert_id;
    } else {
        echo "<h3>Data Saving Failed in Database</h3>";
        return null;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}

if ($_POST['Name'] != '' && $_POST['Age'] != '' && $_POST['City'] != '') {
    // Insert into database and get the generated ID
    $generatedID = insertIntoDatabaseAndGetID($_POST['Name'], $_POST['Age'], $_POST['City']);

    if ($generatedID !== null) {
        // Insert into JSON file
        if (file_exists('json_data/Student_json_data.json')) {
            $current_data = file_get_contents('json_data/Student_json_data.json');
            $array_data = json_decode($current_data, true);
            
            $new_data  = array(
                'ID' => $generatedID,
                'Name' => $_POST['Name'],
                'Age' => $_POST['Age'],
                'City' => $_POST['City']
            );
            $array_data[] = $new_data;
            $json_data = json_encode($array_data, JSON_PRETTY_PRINT);
            if (file_put_contents('json_data/Student_json_data.json', $json_data)) {
                echo "<h3>Data Saved Successfully in JSON</h3>"."</br>"; 
                echo "<h3>Data Saved Successfully in Database .</h3>"."</br>"; 
            } else {
                echo "<h3>Data Saving Failed in JSON</h3>";
            }
        } else {
            echo "<h3>File Does Not Exist</h3>";
        }
    } else {
        echo "<h3>Data Saving Failed in Database</h3>";
    }
} else {
    echo "<h3>All Form Fields are Required</h3>";
}

?>
