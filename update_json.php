<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update JSON Data</title>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>

<main class="container">
    <h1 class="text-center mt-5 mb-4">Update JSON Data</h1>

    <?php
// Assuming you have the ID from the URL parameter
$id = $_GET['id'] ?? '';

// Function to retrieve data from JSON file
function getDataFromJson($id)
{
    $jsonData = file_get_contents('json_data/Student_json_data.json');
    $data = json_decode($jsonData, true);
    foreach ($data as $person) {
        if ($person['ID'] == $id) {
            return $person;
        }
    }
    return null;
}

// Get the data for the specified ID
$personData = getDataFromJson($id);
?>


<form action="update.php" method="post">
    <!-- Add hidden input field for ID -->
    <input type="hidden" name="ID" value="<?php echo $personData['ID'] ?? ''; ?>">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="Name" id="name" placeholder="Enter Name" value="<?php echo $personData['Name'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" class="form-control" name="Age" id="age" placeholder="Enter Age" value="<?php echo $personData['Age'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" name="City" id="city" placeholder="Enter City" value="<?php echo $personData['City'] ?? ''; ?>">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

</main>

</body>
</html>
