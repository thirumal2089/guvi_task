<?php
// Assuming you have a MySQL connection
session_start();

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
    $checkUserQuery = "SELECT * FROM users WHERE email = ? and password = ?";
    $checkUserStmt = $conn->prepare($checkUserQuery);
    $checkUserStmt->bind_param("ss", $email,$password);
    $checkUserStmt->execute();
    $checkUserResult = $checkUserStmt->get_result();

    if ($checkUserResult->num_rows > 0) {
        $_SESSION['user_email'] = $email;
        $response = array("status" => "exists");
    } else {
        $response = array("status" => "login_failed");
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    $checkUserStmt->close();
}

$conn->close();
?>