<?php
// deleteCarDB.php
// Author: Lasha Japaridze
// Student Number: C00303432
// Task: Delete Car from DB

// Include the database connection file to connect to the database.
include("db.inc.php");

// Retrieve the 'action' parameter from the POST data; if not set, default to an empty string.
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'fetchDetails') {
    // Fetch car details for confirmation before deletion.
    if (!isset($_POST['Car_ID'])) {
        echo json_encode(['error' => 'No Car_ID provided.']);
        exit;
    }
    
    // Cast Car_ID to integer
    $Car_ID = intval($_POST['Car_ID']);
    
    // Prepare a SQL query to get the car's details, ensuring the car is not marked as deleted.
    $sql = "SELECT Car_ID, RegNumber, CarType_ID, Colour, BodyStyle, NumberOfDoors, DateAddedToFleet, CurrentStatus
            FROM Car
            WHERE Car_ID = ? AND DeleteFlag = 0
            LIMIT 1";
    
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $Car_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Car not found or already deleted.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error preparing statement: ' . $con->error]);
    }
    
} elseif ($action === 'deleteCar') {
    // Handle deletion of a car (logical delete by setting DeleteFlag to 1).
    if (!isset($_POST['Car_ID'])) {
        echo "Error: No Car_ID provided.";
        exit;
    }
    
    // Cast Car_ID to integer
    $Car_ID = intval($_POST['Car_ID']);
    
    // Check if the car is currently on rental by fetching its current status.
    $sql = "SELECT CurrentStatus FROM Car WHERE Car_ID = ? AND DeleteFlag = 0 LIMIT 1";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $Car_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $status = strtolower(trim($row['CurrentStatus']));
            // Prevent deletion if the car is currently rented.
            if ($status === 'rented' || $status === 'on rental') {
                echo "<p style='color:red;'>This car is currently out on rental. Deletion refused.</p>";
                $stmt->close();
                exit;
            }
        } else {
            echo "<p style='color:red;'>Car not found or already deleted.</p>";
            $stmt->close();
            exit;
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Error preparing status check: " . $con->error . "</p>";
        exit;
    }
    
    // Perform the logical deletion by updating DeleteFlag to 1.
    $sql = "UPDATE Car SET DeleteFlag = 1 WHERE Car_ID = ? AND DeleteFlag = 0";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $Car_ID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<p style='color:green;'>Car successfully deleted.</p>";
        } else {
            echo "<p style='color:red;'>Deletion failed. Car might have already been deleted.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Error preparing delete statement: " . $con->error . "</p>";
    }
    
} else {
    echo "No valid action specified.";
}

// Close the database connection.
$con->close();
?>
