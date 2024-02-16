<?php

$conn = mysqli_connect('localhost', 'root', '', 'test')or die('Cannot connect to MySQL server'); // Connecting to the database

$sql = "SELECT * FROM  students";

$result =  mysqli_query( $conn, $sql) or die('Sql querry failed');

$output = mysqli_fetch_all($result , MYSQLI_ASSOC);

$json = json_encode($output , JSON_PRETTY_PRINT);

$_FILES = "my" . date('d-m-Y') . ".json";

if (file_put_contents( "json_data/{$_FILES}", $json)) {
    echo $_FILES . " has been uploaded.";
    } else{
        echo 'Error: Unable to upload file.' ;
        
    
}

?>