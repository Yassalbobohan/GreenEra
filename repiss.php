<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "greenera_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the user inputs
    $user_id = $_POST['user_id'];
    $category = $_POST['cats'];
    $description = $_POST['description'];

     // Generate the current date and time
     $report_date = date('Y-m-d');
    
    // Define the target directory
    $target_dir = __DIR__ . "/uploads/";  // Use absolute path

    // Check if the directory exists, if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory with full permissions
    }

    // Handle image upload
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Validate image file type
    $valid_image = true;
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        $message = "Only JPG, JPEG, PNG, & GIF files are allowed.";
        $valid_image = false;
    }
    
    // If everything is valid, move the uploaded file and insert into the database
    if ($valid_image && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Prepare the SQL query
        $sql = "INSERT INTO report (user_id, cats, description, fileName) 
                VALUES ('$user_id', '$category', '$description', '$image_name')";  // Store the image name in the database
        
        if ($conn->query($sql) === TRUE) {
            $message = "Report submitted successfully. Report ID: " . $conn->insert_id;
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Error uploading image.";
    }
    
    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Sidebar and Hamburger Menu -->
    <div class="menu-overlay" id="menuOverlay"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-btn" id="closeBtn">&times;</button>
        <ul>
            <li><a href="#"><b>Schedule Waste PickUp</b></a></li>
            <li><a href="#"><b>View Waste Pick Up</b></a></li>
            <li><a href="#"><b>Report Issues</b></a></li>
            <li><a href="#"><b>Manage Notifications</b></a></li>
            <li><a href="#"><b>Report</b></a></li>
        </ul>
    </div>

    <!-- Header -->
<header class="header">
    <div class="header-container">
        <!-- Hamburger Icon -->
        <div class="hamburger" id="hamburger">
            &#9776;
        </div>

        <!-- Logo in the center -->
        <div class="logo">
            <img src="https://i.ibb.co/vZw0zzL/Green-Era-Logo.png" alt="GreenEra Logo" />
        </div>

        <!-- User Profile on the right -->
        <div class="user-profile">
            <a href="#">
                <img src="https://via.placeholder.com/40" alt="User Profile" class="profile-icon" />
                <span class="profile-name">John Doe</span>
            </a>
        </div>
    </div>
</header>

<!-- Cover Section -->
<section class="cover-section">
    <div class="cover-content">
        <h2>Let us know what you've experienced <br>
            & help it's on the way</h2>
        <p>Submit a report to let your management team know what's wrong help will be provided accordingly.</p>
    </div>
</section>
<script src="script.js"></script>

    <div class="container">
        <h1>Submit your report</h1>

        <!-- Display confirmation message -->
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="repiss.php" method="post" enctype="multipart/form-data">
            <!-- User ID -->
            <div>
                <label for="user_id">User ID:</label>
                <p><input type="number" id="user_id" name="user_id" required></p>
            </div>

            <!-- Dropdown categories -->
<div class="custom-dropdown">
    <label for="cats">Category:</label>
    <div class="dropdown-selected">Select a category</div>
    <div class="dropdown-options">
        <div class="dropdown-option" data-value="Missed Pickup">Missed Pickup</div>
        <div class="dropdown-option" data-value="Overflowing Bin">Overflowing Bin</div>
        <div class="dropdown-option" data-value="Illegal Dumping">Illegal Dumping</div>
    </div>
    <input type="hidden" id="cats" name="cats" required>
</div>

            <!-- Description -->
            <div>
                <label for="description">Description:</label>
                <p><textarea id="description" name="description" rows="4" required></textarea></p>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image">Upload an Image:</label>
                <p><input type="file" id="fileName" name="image" accept="image/*" required></p>
            </div>

            <!-- Submit Button -->
            <button type="submit">Submit Report</button>
        </form>
    </div>
          

    
</body>
</html>