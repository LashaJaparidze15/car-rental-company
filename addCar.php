<?php
// Include the database connection file.
include("db.inc.php");

// Get today's date formatted as YYYY-MM-DD.
$today = date("Y-m-d");

// Query to fetch car types from the CarType table.
$query = "SELECT CarType_ID, ModelName FROM CarType ORDER BY ModelName";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add a New Car</title>
  <!-- Link to the external stylesheet for common styles -->
  <link rel="stylesheet" href="style/styles.css">
</head>
<body>
  <!-- Include the header file for consistent site navigation/design -->
  <?php include 'header.php'; ?>
  
  <!-- Main heading for the page -->
  <h1 align="center">Add a New Car</h1>
  
  <!-- Container for the form to add a new car -->
  <div class="form-container">
    <!-- Form starts here; form data will be sent to addCarDB.php using POST method -->
    <form action="addCarDB.php" method="POST">
      
      <!-- Input for Registration Number -->
      <label for="RegNumber">Registration Number:</label>
      <input type="text" name="RegNumber" id="RegNumber" required>
      
      <!-- Dropdown to select Car Type from the CarType table -->
      <label for="CarType_ID">Car Type:</label>
      <select name="CarType_ID" id="CarType_ID" required>
        <option value="">-- Select Car Type --</option>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
          <option value="<?php echo $row['CarType_ID']; ?>">
            <?php echo $row['ModelName']; ?>
          </option>
        <?php } ?>
      </select>
      
      <!-- Input for the car's Colour -->
      <label for="Colour">Colour:</label>
      <input type="text" name="Colour" id="Colour" required>
      
      <!-- Input for the car's Chassis Number -->
      <label for="ChassisNumber">Chassis Number:</label>
      <input type="text" name="ChassisNumber" id="ChassisNumber" required>
      
      <!-- Dropdown to select the Body Style of the car -->
      <label for="BodyStyle">Body Style:</label>
      <select name="BodyStyle" id="BodyStyle" required>
        <option value="">-- Select Body Style --</option>
        <option value="Hatchback">Hatchback</option>
        <option value="Saloon">Saloon</option>
        <option value="SUV">SUV</option>
        <option value="Coupe">Coupe</option>
        <option value="Convertible">Convertible</option>
        <option value="Van">Van</option>
        <option value="Pickup">Pickup</option>
        <option value="Estate">Estate</option>
      </select>
      
      <!-- Input for the Number of Doors -->
      <label for="NumberOfDoors">Number of Doors:</label>
      <input type="number" name="NumberOfDoors" id="NumberOfDoors" min="1" required>
      
      <!-- Input for the Purchase Price with step for decimal values -->
      <label for="PurchasePrice">Purchase Price:</label>
      <input type="number" name="PurchasePrice" id="PurchasePrice" min="0" step="0.01" required>
      
      <!-- Input for the Date Added to Fleet.
           The default value is set to today's date as calculated above -->
      <label for="DateAddedToFleet">Date Added to Fleet:</label>
      <input type="date" name="DateAddedToFleet" id="DateAddedToFleet" value="<?php echo $today; ?>">
      
      <!-- Submit button to send the form data to addCarDB.php -->
      <input type="submit" value="Add Car">
    </form>
  </div>
</body>
</html>
<?php
// Close the database connection when the script ends.
mysqli_close($con);
?>
