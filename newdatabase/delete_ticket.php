<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the incoming JSON data
    $data = json_decode(file_get_contents("php://input"));
    
    // Get the ticket ID from the request
    $id = $data->id;

    // Connect to MySQL
    $conn = new mysqli('localhost', 'root', '', 'newdatabase');

    // Check connection
    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    // Prepare and execute the DELETE SQL statement
    $stmt = $conn->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["message" => "Ticket deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
