<?php
// Assuming you have a MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guvi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST["email"];
  
    $password = $_POST["password"];

    // Check if the user already exists
    $checkUserQuery = "SELECT * FROM users WHERE email = ?";
    $checkUserStmt = $conn->prepare($checkUserQuery);
    $checkUserStmt->bind_param("s", $email);
    $checkUserStmt->execute();
    $checkUserResult = $checkUserStmt->get_result();

    if ($checkUserResult->num_rows > 0) {
        $response = array("status" => "exists", "message" => "user_already_registered");
    } else {
        // Insert the new user into the database using prepared statement
        $insertQuery = "INSERT INTO users (email,password) 
                        VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ss", $email,$password);

        if ($insertStmt->execute()) {
            
            $response = array("status" => "success", "message" => "Registration successful!");
        } else {
            $response = array("status" => "error", "message" => "Error in registration. Please try again.");
        }
        
        $insertStmt->close();
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    $checkUserStmt->close();
}

$conn->close();
?>