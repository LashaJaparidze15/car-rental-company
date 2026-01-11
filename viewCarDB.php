<?php
// viewCarDB.php
header('Content-Type: application/json'); // Ensure JSON is sent


//<!--Name:           Lasha Japaridze-->
//<!--Student Number: C00303432-->
//<!--Task:           Amend/View Car DB-->
	
	
include("db.inc.php");

if (!isset($_POST['action'])) {
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

$action = $_POST['action'];

if ($action === 'fetchDetails') {
    if (!isset($_POST['Car_ID'])) {
        echo json_encode(['error' => 'Car_ID not provided.']);
        exit;
    }
    $Car_ID = $_POST['Car_ID'];
    
    $sql = "SELECT Car_ID, RegNumber, CarType_ID, Colour, chassisNumber, BodyStyle, NumberOfDoors, PurchasePrice, DateAddedToFleet, CurrentStatus 
            FROM Car 
            WHERE Car_ID = ? AND DeleteFlag = 0
            LIMIT 1";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $Car_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (!empty($row['DateAddedToFleet']) && $row['DateAddedToFleet'] != "0000-00-00") {
                $row['DateAddedToFleet'] = date("Y-m-d", strtotime($row['DateAddedToFleet']));
            } else {
                $row['DateAddedToFleet'] = "";
            }
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Car not found or already deleted.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error preparing statement: ' . $con->error]);
    }
    
} elseif ($action === 'amendCar') {
    $required = ['Car_ID', 'CarType_ID', 'RegNumber', 'Colour', 'chassisNumber', 'BodyStyle', 'NumberOfDoors', 'PurchasePrice', 'DateAddedToFleet'];
    foreach ($required as $field) {
        if (!isset($_POST[$field])) {
            echo json_encode(['error' => "Missing field: $field"]);
            exit;
        }
    }
    
    $RegNumber = $_POST['RegNumber'];
    $Car_ID = $_POST['Car_ID'];
    $CarType_ID = $_POST['CarType_ID'];
    $Colour = $_POST['Colour'];
    $chassisNumber = $_POST['chassisNumber'];
    $BodyStyle = $_POST['BodyStyle'];
    $NumberOfDoors = (int)$_POST['NumberOfDoors'];
    $PurchasePrice = (float)$_POST['PurchasePrice'];
    $DateAddedToFleet = $_POST['DateAddedToFleet'];
    $CurrentStatus = $_POST['CurrentStatus'] ?? ''; // Using null coalescing for safety
    
    // Validate date format
    if (!empty($DateAddedToFleet) && !strtotime($DateAddedToFleet)) {
        echo json_encode(['error' => 'Invalid date format for DateAddedToFleet']);
        exit;
    }
    
    $sql = "UPDATE Car 
            SET CarType_ID = ?, Colour = ?, chassisNumber = ?, BodyStyle = ?, 
                NumberOfDoors = ?, PurchasePrice = ?, DateAddedToFleet = ?, CurrentStatus = ?, RegNumber = ?
            WHERE Car_ID = ? AND DeleteFlag = 0";
            
    if ($stmt = $con->prepare($sql)) {
        // Correct type string and parameter order:
        // "isssidsssi" corresponds to:
        // CarType_ID (i), Colour (s), chassisNumber (s), BodyStyle (s),
        // NumberOfDoors (i), PurchasePrice (d), DateAddedToFleet (s), 
        // CurrentStatus (s), RegNumber (s), Car_ID (i)
        $stmt->bind_param("isssidsssi", 
            $CarType_ID, 
            $Colour, 
            $chassisNumber, 
            $BodyStyle, 
            $NumberOfDoors, 
            $PurchasePrice, 
            $DateAddedToFleet,
            $CurrentStatus,
            $RegNumber,
            $Car_ID
        );
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to update car details: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error preparing update statement: ' . $con->error]);
    }
    
} else {
    echo json_encode(['error' => 'Unknown action.']);
}

$con->close();
?>
