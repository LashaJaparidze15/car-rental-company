<?php
// carReport.php

//<!--Name:           Lasha Japaridze-->
//<!--Student Number: C00303432-->
//<!--Task:           Car Report-->
	
	
include("db.inc.php");

// Determine which sort order is requested; default to "model"
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'model';

// Decide the ORDER BY clause based on the requested sort
switch ($sort) {
    case 'popular':
        // Sort by CumulativeRentals descending from Car table
        $orderBy = "c.CumulativeRentals DESC";
        break;
    case 'age':
        // Sort by DateAddedToFleet ascending from Car table
        $orderBy = "c.DateAddedToFleet ASC";
        break;
    default:
        // Default sort is alphabetical by ModelName from CarType table
        $orderBy = "ct.ModelName ASC";
        $sort = 'model';
        break;
}

// Fetch records by joining Car and CarType
$sql = "SELECT 
            c.RegNumber,
            c.CurrentStatus,
            c.CumulativeRentals,
            c.DateAddedToFleet,
            ct.ModelName,
            ct.Manufacturer
        FROM Car c
        INNER JOIN CarType ct ON c.CarType_ID = ct.CarType_ID
        WHERE c.DeleteFlag = 0
        ORDER BY $orderBy";

$result = mysqli_query($con, $sql);
if (!$result) {
    die('Error retrieving car data: ' . mysqli_error($con));
}

// Determine which button to disable based on current sort
$modelDisabled   = ($sort === 'model')   ? 'disabled' : '';
$popularDisabled = ($sort === 'popular') ? 'disabled' : '';
$ageDisabled     = ($sort === 'age')     ? 'disabled' : '';
?>
<html>
<head>
    <title>Car Report</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
        /* Container for the report table */
        .report-container {
            width: 80%;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.9);
            border-radius: 5px;
        }
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: white;
        }
        /* Centering buttons */
        .button-container {
            text-align: center;
            margin-bottom: 20px;
            color: black;
        }
        .button-container a {
            margin: 0 5px;
        }
        /* Button styling */
        .button-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color:rgba(0, 255, 255, 0.3); /* Green background */
            color: Black;              
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-container button:disabled {
            background-color: rgba(255, 255, 255, 0.5);    
            cursor: not-allowed;
        }
        .button-container button:hover:not(:disabled) {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    
    <?php include 'header.php'; ?><!--Header of the file-->
    <h1 style="text-align: center;">Car Report</h1>
    <div class="report-container">
        <!-- Buttons to switch sort order -->
        <div class="button-container">
            <a href="?sort=model">
                <button <?= $modelDisabled ?>>Model</button>
            </a>
            <a href="?sort=popular">
                <button <?= $popularDisabled ?>>Popular</button>
            </a>
            <a href="?sort=age">
                <button <?= $ageDisabled ?>>Age of Fleet</button>
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Registration Number</th>
                    <th>Model Name</th>
                    <th>Manufacturer</th>
                    <th>Current Status</th>
                    <th>Date Added to Fleet</th>
                    <th>Cumulative Rentals</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['RegNumber']) ?></td>
                        <td><?= htmlspecialchars($row['ModelName']) ?></td>
                        <td><?= htmlspecialchars($row['Manufacturer']) ?></td>
                        <td><?= htmlspecialchars($row['CurrentStatus']) ?></td>
                        <?php
                            // Format the date if valid
                            $dateAdded = $row['DateAddedToFleet'];
                            if (!empty($dateAdded) && $dateAdded !== '0000-00-00') {
                                $dateAdded = date("Y-m-d", strtotime($dateAdded));
                            } else {
                                $dateAdded = "";
                            }
                        ?>
                        <td><?= htmlspecialchars($dateAdded) ?></td>
                        <td><?= htmlspecialchars($row['CumulativeRentals']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
mysqli_close($con);
?>
