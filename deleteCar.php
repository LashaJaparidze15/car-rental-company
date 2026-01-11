<!--Name:           Lasha Japaridze-->
<!--Student Number: C00303432-->
<!--Task:           Delete Car-->

<?php
// deleteCar.php
// Include the database connection file to connect to the database.
include("db.inc.php");

// Build a query to retrieve all cars that haven't been marked as deleted (DeleteFlag = 0)
// We only need the Car_ID and Registration Number (RegNumber) for the dropdown list.
// The results are sorted alphabetically by RegNumber.
$sql = "SELECT Car_ID, RegNumber FROM Car WHERE DeleteFlag = 0 ORDER BY RegNumber ASC";

// Execute the query.
$result = mysqli_query($con, $sql);
// If the query fails, stop execution and display an error message.
if (!$result) {
    die("Error retrieving cars: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete a Car</title>
  <!-- Link to the external CSS file for styling -->
  <link rel="stylesheet" href="style/styles.css">
  <script>
    // JavaScript function using async/await to fetch details for the selected car.
    async function fetchCarDetails() {
      // Get the dropdown element containing the car options.
      const carSelect = document.getElementById("carSelect");
      // Retrieve the selected Car_ID from the dropdown.
      const carID = carSelect.value;
      // If no car is selected, alert the user.
      if (carID === "") {
        alert("Please select a car.");
        return;
      }
      try {
        // Send a POST request to deleteCarDB.php to fetch the car details.
        const response = await fetch("deleteCarDB.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "action=fetchDetails&Car_ID=" + encodeURIComponent(carID)
        });
        // Parse the JSON response.
        const data = await response.json();
        console.log(data); // Log the response for debugging purposes.
        // If the response contains an error, show it in the message div and hide the car details.
        if (data.error) {
          document.getElementById("message").innerHTML = data.error;
          document.getElementById("carDetails").style.display = "none";
        } else {
          // Populate the form fields with the car's details.
          document.getElementById("RegNumber").value = data.RegNumber || "";
          document.getElementById("CarType_ID").value = data.CarType_ID || "";
          document.getElementById("Colour").value = data.Colour || "";
          document.getElementById("BodyStyle").value = data.BodyStyle || "";
          document.getElementById("NumberOfDoors").value = data.NumberOfDoors || "";
          document.getElementById("DateAddedToFleet").value = data.DateAddedToFleet || "";
          document.getElementById("CurrentStatus").value = data.CurrentStatus || "";
          // Store the Car_ID in a hidden field for later use (deletion).
          document.getElementById("hiddenCarID").value = data.Car_ID || "";
          // Display the car details section.
          document.getElementById("carDetails").style.display = "block";
          // Clear any previous messages.
          document.getElementById("message").innerHTML = "";
        }
      } catch (error) {
        // If there's an error in the fetch process, log it and display an error message.
        console.error(error);
        document.getElementById("message").innerHTML = "Error: " + error.message;
      }
    }

    // JavaScript function using async/await to delete the selected car.
    async function deleteCar() {
      // Confirm with the user that they really want to delete the car.
      if (!confirm("Are you sure you want to delete this car (Y/N)?")) {
        return;
      }
      // Get the Car_ID from the hidden field.
      const carID = document.getElementById("hiddenCarID").value;
      // If no Car_ID is available, alert the user.
      if (carID === "") {
        alert("No car selected for deletion.");
        return;
      }
      try {
        // Send a POST request to deleteCarDB.php to delete the car.
        const response = await fetch("deleteCarDB.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "action=deleteCar&Car_ID=" + encodeURIComponent(carID)
        });
        // Get the response text which contains the result message.
        const resultText = await response.text();
        // Display the result message.
        document.getElementById("message").innerHTML = resultText;
        // Hide the car details section since the car has been deleted.
        document.getElementById("carDetails").style.display = "none";
      } catch (error) {
        // If an error occurs during deletion, display the error message.
        document.getElementById("message").innerHTML = "Error: " + error.message;
      }
    }
  </script>
</head>
<body>
  <!-- Include the header file for a consistent look and navigation -->
  <?php include 'header.php'; ?>
  <!-- Main heading for the delete car page -->
  <h1 align="center">Delete a Car</h1>
  <!-- Message area to display status updates or errors -->
  <div id="message"></div>
  <!-- Form for selecting a car from the dropdown list -->
  <form>
    <label for="carSelect">Select Car:</label>
    <select id="carSelect" name="Car_ID" required>
      <option value="">-- Select a Car --</option>
      <?php
      // Loop through each car from the query result and add it as an option in the dropdown.
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['Car_ID'] . "'>" . htmlspecialchars($row['RegNumber']) . "</option>";
      }
      // Close the database connection now that we have the data.
      mysqli_close($con);
      ?>
    </select>
    <!-- Button to trigger the fetching of car details -->
    <button type="button" onclick="fetchCarDetails()">View Details</button>
  </form>
  
  <!-- Section to display detailed information about the selected car.
       This section is initially hidden until details are fetched. -->
  <div id="carDetails" style="display:none;">
    <h2 align="center">Car Details</h2>
    <form>
      <label for="RegNumber">Registration Number:</label>
      <input type="text" id="RegNumber" readonly>
      
      <label for="CarType_ID">Car Type:</label>
      <input type="text" id="CarType_ID" readonly>
      
      <label for="Colour">Colour:</label>
      <input type="text" id="Colour" readonly>
      
      <label for="BodyStyle">Body Style:</label>
      <input type="text" id="BodyStyle" readonly>
      
      <label for="NumberOfDoors">Number Of Doors:</label>
      <input type="text" id="NumberOfDoors" readonly>
      
      <label for="DateAddedToFleet">Date Added to Fleet:</label>
      <input type="text" id="DateAddedToFleet" readonly>
      
      <label for="CurrentStatus">Current Status:</label>
      <input type="text" id="CurrentStatus" readonly>
      
      <!-- Hidden field to store the Car_ID, which is needed when sending the delete request -->
      <input type="hidden" id="hiddenCarID">
      
      <br>
      <!-- Button to trigger the deletion of the car -->
      <button type="button" onclick="deleteCar()">Delete Car</button>
    </form>
  </div>
</body>
</html>
