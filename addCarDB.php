<?php

//<!--Name:           Lasha Japaridze-->
//<!--Student Number: C00303432-->
//<!--Task:           Add Car DB-->
// addCarDB.php
// Include the database connection file to establish a connection to the database.
include("db.inc.php");

// Check if the form was submitted using the POST method.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form fields.
    // Trim is used to remove any extra spaces from the input.
    $RegNumber         = trim($_POST['RegNumber']);
    // Convert CarType_ID to an integer value.
    $CarType_ID        = intval($_POST['CarType_ID']);
    $Colour            = trim($_POST['Colour']);
    $ChassisNumber     = trim($_POST['ChassisNumber']);
    $BodyStyle         = trim($_POST['BodyStyle']);
    // Convert NumberOfDoors to an integer.
    $NumberOfDoors     = intval($_POST['NumberOfDoors']);
    // Convert PurchasePrice to a float for decimal values.
    $PurchasePrice     = floatval($_POST['PurchasePrice']);
    $DateAddedToFleet  = $_POST['DateAddedToFleet'];

    // If no date is provided, default to today's date.
    if (empty($DateAddedToFleet)) {
        $DateAddedToFleet = date("Y-m-d");
    }
    
    // Set default values for newly added cars.
    $CurrentStatus = 'Available';  // Newly added cars are available by default.
    $DeleteFlag    = 0;            // 0 indicates the car is not deleted.

    // Prepare an SQL INSERT statement with placeholders for parameters.
    // The parameters use the correct types: 
    // "i" for integer, "s" for string, and "d" for double (decimal).
    $sql = "INSERT INTO Car (
                CarType_ID,
                Colour,
                BodyStyle,
                RegNumber,
                ChassisNumber,
                NumberOfDoors,
                PurchasePrice,
                DateAddedToFleet,
                CurrentStatus,
                DeleteFlag
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement.
    if ($stmt = $con->prepare($sql)) {
        // Bind the variables to the parameter markers in the SQL statement.
        $stmt->bind_param("issssidssi",
            $CarType_ID,
            $Colour,
            $BodyStyle,
            $RegNumber,
            $ChassisNumber,
            $NumberOfDoors,
            $PurchasePrice,
            $DateAddedToFleet,
            $CurrentStatus,
            $DeleteFlag
        );
        // Execute the prepared statement.
        if ($stmt->execute()) {
            // If the execution is successful, display a success message with the new Car_ID.
            echo "<p style='color: green;'>Car added successfully. New Car_ID: " . $stmt->insert_id . "</p>";
        } else {
            // If there is an error during execution, display an error message with details.
            echo "<p style='color: red;'>Error inserting car: " . $stmt->error . "</p>";
        }
        // Close the prepared statement to free resources.
        $stmt->close();
    } else {
        // If the statement cannot be prepared, output an error message.
        echo "<p style='color: red;'>Error preparing statement: " . $con->error . "</p>";
    }
} else {
    // If the request method is not POST, show an error message.
    echo "<p style='color: red;'>Invalid request method.</p>";
}

// Close the database connection.
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car - Result</title>
    <!-- Link to the external stylesheet for common styles -->
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <!-- Include the header for consistent navigation or branding -->
    <?php include 'header.php'; ?>
    <!-- Provide a link for the user to go back to the Add Car form -->
    <p><a href="addCar.php">Back to Add Car</a></p>
</body>
</html>
