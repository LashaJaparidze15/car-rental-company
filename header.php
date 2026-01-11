<!-- Purpose: Contains the header of the website, which includes the navigation bar. -->

<header>
    <img src="../Website/source/images/logo.png" alt="Car Rental Logo" class="header-logo">
    <span class="header-title">Car Rental Management System</span>
	    <link rel="stylesheet" href="style/styles.css">

</header>

<nav>
    <ul>
        <li><a href="rentals.php">Rentals</a></li>
        <li><a href="returns.php">Returns</a></li>
        <li><a href="#payments">Accept Payments</a></li>
        <li>
            <a href="#blacklist">Blacklist</a>
            <ul class="dropdown">
                <li><a href="addBlacklist.php">Add to Blacklist</a></li>
                <li><a href="removeBlacklist.php">Remove from Blacklist</a></li>
                <li><a href="viewBlacklist.php">Amend/View Blacklist</a></li>
            </ul>
        </li>
        <li>
            <a href="#file-maintenance">Companies Maintenance</a>
            <ul class="dropdown">
                <li><a href="addCompany.php">Add a New Company</a></li>
                <li><a href="deleteCompany.php">Delete a Company</a></li>
                <li><a href="viewCompany.php">Amend / View a Company</a></li>
            </ul>
        </li>
        <li>
            <a href="#file-maintenance">Car Maintenance</a>
            <ul class="dropdown">
                <li><a href="addCar.php">Add a New Car</a></li>
                <li><a href="deleteCar.php">Delete a Car</a></li>
                <li><a href="viewCar.php">Amend / View a Car</a></li>
            </ul>
        </li>
        <li>
            <a href="#setup">Set-Up</a>
            <ul class="dropdown">
                <li><a href="addCarType.php">Add a New Car Type</a></li>
                <li><a href="deleteCarType.php">Delete a Car Type</a></li>
                <li><a href="viewCarType.php">Amend / View a Car Type</a></li>
                <li><a href="#add-rental-category">Add a New Rental Category</a></li>
                <li><a href="#delete-rental-category">Delete a Rental Category</a></li>
                <li><a href="#amend-rental-category">Amend / View a Rental Category</a></li>
            </ul>
        </li>
        <li>
            <a href="#reports">Reports</a>
            <ul class="dropdown">
                <li><a href="#company-report">Company Report</a></li>
                <li><a href="carReport.php">Car Report</a></li>
                <li><a href="#rental-report">Rental Report</a></li>
                <li><a href="viewBlacklistReport.php">Blacklist Report</a></li>
            </ul>
        </li>
        <li><a href="#exit">Exit</a></li>
    </ul>
</nav>