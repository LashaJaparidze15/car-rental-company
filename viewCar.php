<!--Name:           Lasha Japaridze-->
<!--Student Number: C00303432-->
<!--Task:           Amend/View Car-->

<?php
// viewCar.php
// Include the database connection file to connect to our database.
include("db.inc.php");

// Retrieve all non-deleted cars (where DeleteFlag is 0) to populate the dropdown list.
// We only need Car_ID and RegNumber, and we order them alphabetically by RegNumber.
$sql = "SELECT Car_ID, RegNumber FROM Car WHERE DeleteFlag = 0 ORDER BY RegNumber ASC";
$result = mysqli_query($con, $sql);
if (!$result) {
    die("Error retrieving cars: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Amend / View a Car</title>
  <!-- Link to our external CSS stylesheet -->
  <link rel="stylesheet" href="style/styles.css">
  
  <script>
    // Wait until the page's content is loaded before attaching event listeners.
    document.addEventListener('DOMContentLoaded', function() {
      // When the "View Details" button is clicked, trigger the fetchCarDetails function.
      document.getElementById('viewDetailsBtn').addEventListener('click', fetchCarDetails);
    });

    // Asynchronous function to fetch the details of the selected car.
    async function fetchCarDetails() {
      console.log("fetchCarDetails started");
      
      // Get the selected car's ID from the dropdown.
      const carSelect = document.getElementById("carSelect");
      const carID = carSelect.value;
      if (carID === "") {
        alert("Please select a car.");
        return;
      }
      
      try {
        console.log("Fetching car ID:", carID);
        // Send a POST request to viewCarDB.php with action 'fetchDetails' and the selected Car_ID.
        const response = await fetch("viewCarDB.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "action=fetchDetails&Car_ID=" + encodeURIComponent(carID)
        });
        
        // Parse the JSON response.
        const data = await response.json();
        console.log("API Response:", data);

        // If an error is returned from the API, display it and hide the car details section.
        if (data.error) {
          document.getElementById("message").innerHTML = data.error;
          document.getElementById("carDetails").style.display = "none";
          return;
        }
        
        // List of fields we expect to get from the API response.
        const fields = [
          'RegNumber', 'CarType_ID', 'chassisNumber', 'Colour', 
          'BodyStyle', 'NumberOfDoors', 'DateAddedToFleet', 
          'PurchasePrice', 'CurrentStatus'
        ];
        
        // Loop through each field and set the corresponding input value.
        fields.forEach(field => {
          const element = document.getElementById(field);
          if (!element) {
            console.error(`Element with ID '${field}' not found!`);
          } else {
            console.log(`Setting ${field} to:`, data[field] || "");
            element.value = data[field] || "";
          }
        });
        
        // Explicitly set the hidden Car_ID field for later use (like saving amendments).
        document.getElementById('hiddenCarID').value = data['Car_ID'];
        
        // Make the car details form visible and clear any previous messages.
        document.getElementById("carDetails").style.display = "block";
        document.getElementById("message").innerHTML = "";
        
      } catch (error) {
        console.error("Error in fetchCarDetails:", error);
        document.getElementById("message").innerHTML = "Error: " + error.message;
      }
    }

    // Function to lock (disable) all form fields so they cannot be edited.
    function lockFields() {
      document.getElementById('RegNumber').disabled = true;
      document.getElementById('CarType_ID').disabled = true;
      document.getElementById('Colour').disabled = true;
      document.getElementById('chassisNumber').disabled = true;
      document.getElementById('BodyStyle').disabled = true;
      document.getElementById('NumberOfDoors').disabled = true;
      document.getElementById('PurchasePrice').disabled = true;
      document.getElementById('DateAddedToFleet').disabled = true;
      document.getElementById('CurrentStatus').disabled = true;
    }

    // Function to enable fields for editing; some remain locked (like RegNumber and CurrentStatus).
    function enableFields() {
      // Registration Number and Current Status remain locked.
      document.getElementById('CarType_ID').disabled = false;
      document.getElementById('Colour').disabled = false;
      document.getElementById('chassisNumber').disabled = false;
      document.getElementById('BodyStyle').disabled = false;
      document.getElementById('NumberOfDoors').disabled = false;
      document.getElementById('PurchasePrice').disabled = false;
      document.getElementById('DateAddedToFleet').disabled = false;
    }

    // Function to initiate the amendment process.
    function amendDetails() {
      // Enable fields for editing.
      enableFields();
      // Disable the "Amend Details" button to prevent multiple clicks.
      document.getElementById('amendButton').disabled = true;
      // Show the "Save Changes" button.
      document.getElementById('saveButton').style.display = 'inline';
    }

    // Asynchronous function to save changes made to the car details.
    async function saveChanges() {
      // Confirm with the user that they want to save the changes.
      if(!confirm("Please confirm that the details are correct (Y/N)")) {
         return;
      }
      // Prepare the data to be sent to the server using URLSearchParams.
      const formData = new URLSearchParams();
      formData.append('action', 'amendCar');
      formData.append('Car_ID', document.getElementById('hiddenCarID').value);
      formData.append('RegNumber', document.getElementById('RegNumber').value);
      formData.append('CarType_ID', document.getElementById('CarType_ID').value);
      formData.append('Colour', document.getElementById('Colour').value);
      formData.append('chassisNumber', document.getElementById('chassisNumber').value);
      formData.append('BodyStyle', document.getElementById('BodyStyle').value);
      formData.append('NumberOfDoors', document.getElementById('NumberOfDoors').value);
      formData.append('PurchasePrice', document.getElementById('PurchasePrice').value);
      formData.append('DateAddedToFleet', document.getElementById('DateAddedToFleet').value);
      formData.append('CurrentStatus', document.getElementById('CurrentStatus').value);
      
      try {
         // Send the updated car details to viewCarDB.php using a POST request.
         const response = await fetch('viewCarDB.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData.toString()
         });
         // Parse the JSON response.
         const result = await response.json();
         // If the update was successful, show a success message.
         if(result.success) {
            document.getElementById('message').innerHTML = "Car details successfully amended.";
            // Lock fields again so they are not editable.
            lockFields();
            // Re-enable the "Amend Details" button.
            document.getElementById('amendButton').disabled = false;
            // Hide the "Save Changes" button.
            document.getElementById('saveButton').style.display = 'none';
         } else {
            // If there was an error, display the error message.
            document.getElementById('message').innerHTML = "Error: " + result.error;
         }
      } catch(error) {
         // Catch and display any errors that occur during the save process.
         document.getElementById('message').innerHTML = "Error: " + error.message;
      }
    }
  </script>
</head>
<body>
  <!-- Include header for a consistent navigation and design -->
  <?php include 'header.php'; ?>
  <!-- Main title of the page -->
  <h1 align="center">Amend / View a Car</h1>
  <!-- Div for displaying any messages (errors or confirmations) -->
  <div id="message"></div>
  
  <!-- Car selection form: user selects a car to view or amend -->
  <form id="carSelectForm">
    <label for="carSelect">Select Car:</label>
    <select id="carSelect" name="Car_ID" required>
      <option value="">-- Select a Car --</option>
      <?php
         // Loop through each car retrieved from the database and add an option to the dropdown.
         while ($row = mysqli_fetch_assoc($result)) {
             echo "<option value='" . $row['Car_ID'] . "'>" . htmlspecialchars($row['RegNumber']) . "</option>";
         }
         // Close the database connection once the dropdown is populated.
         mysqli_close($con);
      ?>
    </select>
    <!-- Button to view details for the selected car -->
	<button type="button" id="viewDetailsBtn" onclick="fetchCarDetails()">View Details</button>
  </form>
  
  <!-- Car details form, initially hidden, which shows the details of the selected car -->
  <div id="carDetails" style="display:none;">
    <h2 align="center">Car Details</h2>
    <form id="viewCarForm">
      <label for="RegNumber">Registration Number:</label>
      <input type="text" id="RegNumber" readonly required>
	  
      <label for="CarType_ID">Car Type:</label>
      <input type="text" id="CarType_ID" disabled required>
      
      <label for="Colour">Colour:</label>
      <input type="text" id="Colour" disabled required>
      
      <label for="chassisNumber">Chassis Number:</label>
      <input type="text" id="chassisNumber" disabled required>
      
      <label for="BodyStyle">Body Style:</label>
      <input type="text" id="BodyStyle" disabled required>
      
      <label for="NumberOfDoors">Number Of Doors:</label>
      <input type="number" id="NumberOfDoors" disabled required>
      
      <label for="PurchasePrice">Purchase Price:</label>
      <input type="number" id="PurchasePrice" step="0.01" disabled required>
      
      <label for="DateAddedToFleet">Date Added to Fleet:</label>
      <input type="date" id="DateAddedToFleet" disabled required>
      
      <label for="CurrentStatus">Current Status:</label>
      <input type="text" id="CurrentStatus" readonly>
      
      <!-- Hidden field to store the Car_ID, necessary for saving changes -->
      <input type="hidden" id="hiddenCarID">
      
	  <br>
      <!-- Button to initiate amendment of the car details -->
      <button type="button" id="amendButton" onclick="amendDetails()">Amend Details</button>
      <!-- Button to save changes, initially hidden -->
      <button type="button" id="saveButton" style="display:none;" onclick="saveChanges()">Save Changes</button> 
	  </br>
	</form>
  </div>
</body>
</html>
