<?php
require "connection.php";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$vendorID = null;



$notificationsQuery = mysqli_query($conn, "SELECT * FROM notifications WHERE message LIKE '%Vendor ID $vendorID%'");
// Fetch notifications targeted to vendors
$vendorNotifications = mysqli_query($conn, "SELECT * FROM notifications WHERE target = 'vendor' ORDER BY created_at DESC LIMIT 5");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Management</title>
</head>
<body>
    <div>
        <header>
        <a href="managment.php">managment page</a><br>
        <a href="job.php">job page</a><br>
        <a href="client.php">client registeral page</a><br>
    </div>
    </header>

    <!-- Display Vendor Notifications -->
    <h2>Your Notifications</h2>
    <ul>
    <?php
    
    $notificationQuery = "SELECT * FROM notifications WHERE target = 'vendor' ORDER BY created_at DESC LIMIT 5";
    $notifications = mysqli_query($conn, $notificationQuery);
    
    // Check if notifications exist
    if ($notifications && mysqli_num_rows($notifications) > 0): 
        while ($row = mysqli_fetch_assoc($notifications)): ?>
            <li>
                <?php echo htmlspecialchars($row['message']); ?> - <?php echo htmlspecialchars($row['created_at']); ?>
                <form method="POST" action="vendors.php" style="display:inline;">
                    <input type="hidden" name="notificationID" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <button type="submit" name="delete_notification">Delete</button>
                </form>
            </li>
        <?php endwhile;
    else: ?>
        <li>No notifications found.</li>
    <?php endif; ?>
</ul>

        <!-- Form to send notification to management -->
<h3>Send a Notification to Management</h3>
<form method="POST" action="vendors.php">
    <label for="managementMessage">Message:</label><br>
    <textarea name="managementMessage" id="managementMessage" rows="4" cols="50" required></textarea><br><br>
    <button type="submit" name="send_notification">Send Notification</button>
</form>
    
    <!-- Vendor Registration Form -->
    <h2>Register Vendor</h2>
    <form action="vendors.php" method="POST">
        <label for="vendorName">Vendor Name:</label>
        <input type="text" name="vendorName" required><br>

        <label for="ability">Ability (Skill for specific tasks):</label>
        <input type="text" name="ability" required><br>

        <button type="submit" name="submit_vendor">Register Vendor</button>
    </form>

        <!--uploading file form -->

        <form action="vendors.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="file">
            <br><button type="submit" name="upload">upload file</button>
        </form>

    <!-- Vendor Search Form -->
    <h2>Search Vendor</h2>
    <form action="vendors.php" method="POST">
        <label for="searchVendorName">Vendor Name:</label>
        <input type="text" name="searchVendorName" required><br>

        <button type="submit" name="search_vendor">Search Vendor</button>
    </form>


   <!-- Vendor Task Completion Form -->
<h2>Mark Task as Completed</h2>
<form action="vendors.php" method="POST">
    <label for="taskID">Enter Task ID to Mark as Completed:</label>
    <input type="number" name="taskID" required><br><br>

    <label for="vendorID">Enter Vendor ID:</label>
    <input type="number" name="vendorID" required><br><br>

    <button type="submit" name="complete_task">Complete Task</button>
</form>


        <!-- Vendor Update Form -->
<h2>Update Vendor Information</h2>
<form action="vendors.php" method="POST">
    <label for="vendorID">Vendor ID:</label>
    <input type="text" name="vendorID" required><br>

    <label for="vendorName">New Vendor Name:</label>
    <input type="text" name="newVendorName"><br>

    <label for="newAbility">New Ability (Skill for specific tasks):</label>
    <input type="text" name="newAbility"><br>

    <button type="submit" name="update_vendor">Update Vendor</button>
</form>



     <!-- Vendor Deletion Form -->
     <h2>Delete Vendor</h2>
    <form action="vendors.php" method="POST">
        <label for="vendorID">Vendor ID :</label>
        <input type="text" name="vendorID"><br>

        <label for="vendorName">Vendor Name:</label>
        <input type="text" name="vendorName"><br>

        <button type="submit" name="delete_vendor">Delete Vendor</button>
    </form>

</body>
</html>

                <style>
                 
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4; /* Light background for contrast */
}

header {
    background-color: #12343b; /* Night Blue Shadow */
    color: white;
    padding: 10px 20px;
    text-align: center;
}

header a {
    color: white;
    text-decoration: none;
    margin: 0 15px; 
}

header a:hover {
    text-decoration: underline; 
}

h2 {
    color: #12343b; /* Darker text for headings */
    margin: 20px 0 10px; 
}

form {
    background-color: white; /* White background for forms */
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 20px;
    max-width: 500px;
    margin: 20px auto;
}

label {
    display: block; /* Stack labels and inputs */
    margin: 10px 0 5px; /* Spacing for labels */
}

input[type="text"],
input[type="file"],
select {
    width: calc(100% - 20px); /* Full width minus padding */
    padding: 10px; /* Padding inside input fields */
    border: 1px solid #ccc; /* Light border for inputs */
    border-radius: 4px; /* Rounded corners */
    margin-bottom: 15px; /* Spacing below each input */
}

button {
    background-color: #12343b; /* Night Blue Shadow */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s; /* Smooth background color transition */
}

button:hover {
    background-color: #0f2a47; /* Darker shade on hover */
}

ul {
    list-style-type: none; /* Remove default bullet points */
    padding: 0; /* Remove padding */
}

ul li {
    background-color: white; /* White background for list items */
    border: 1px solid #ddd; /* Light border for items */
    border-radius: 4px; /* Rounded corners */
    padding: 10px;
    margin: 5px 0; /* Space between items */
}

ul li:hover {
    background-color: #f1f1f1; /* Change background on hover */
}

        </style>
<!-- ----------------------------------------------------------- -->
    
    <?php

        // Handle sending notifications to management
if (isset($_POST['send_notification'])) {
    $message = mysqli_real_escape_string($conn, $_POST['managementMessage']);

      $insertNotification = "INSERT INTO notifications (message, target) VALUES ('$message', 'management')";

    if (mysqli_query($conn, $insertNotification)) {
        echo "<p style='color: green;'>Notification sent to management successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error sending notification: " . mysqli_error($conn) . "</p>";
    }
}

        // Check if a notification deletion request is sent by the client
if (isset($_POST['delete_notification'])) {
    $notificationID = mysqli_real_escape_string($conn, $_POST['notificationID']);

                                  // Get the notification details before deletion
    $notificationQuery = "SELECT * FROM notifications WHERE id = '$notificationID'";
    $notificationResult = mysqli_query($conn, $notificationQuery);
    if (mysqli_num_rows($notificationResult) > 0) {
        $notification = mysqli_fetch_assoc($notificationResult);
        
        // Insert into deleted_notifications before deleting from notifications
        $insertDeletedNotification = "
            INSERT INTO deleted_notifications (message, target, original_created_at) 
         VALUES ('" . mysqli_real_escape_string($conn, $notification['message']) . "', 
                     '" . mysqli_real_escape_string($conn, $notification['target']) . "', 
                    '" . mysqli_real_escape_string($conn, $notification['created_at']) . "')";
        if (mysqli_query($conn, $insertDeletedNotification)) {
            
            $deleteNotification = "DELETE FROM notifications WHERE id = '$notificationID'";
            if (mysqli_query($conn, $deleteNotification)) {
                echo "<p style='color: green;'>Notification deleted and moved to deleted_notifications!</p>";
            } else {
                echo "<p style='color: red;'>Error deleting notification: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error moving notification to deleted_notifications: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Notification not found.</p>";
    }
}



// Handle vendor registration
if (isset($_POST['submit_vendor'])) {
    $vendorName = mysqli_real_escape_string($conn, $_POST['vendorName']);
    $ability = mysqli_real_escape_string($conn, $_POST['ability']);
   
    $insertVendor = "INSERT INTO vendors (vendorName, ability) VALUES ('$vendorName', '$ability')";

    if (mysqli_query($conn, $insertVendor)) {
        $notification = "New vendor Registered!: $vendorName";
     mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");
        echo "Vendor added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

    // Handle vendor search
    if (isset($_POST['search_vendor'])) {
        $searchVendorName = mysqli_real_escape_string($conn, $_POST['searchVendorName']);
        $searchQuery = "SELECT * FROM vendors WHERE vendorName LIKE '%$searchVendorName%'";
        $vendorResult = mysqli_query($conn, $searchQuery);

        if (mysqli_num_rows($vendorResult) > 0) {
            echo "<h3>Search Results:</h3><ul>";
            while ($vendor = mysqli_fetch_assoc($vendorResult)) {
                echo "<li>" . $vendor['vendorName'] . " - Assigned Tasks: ";

                // Fetch assigned tasks for this vendor
                $assignedTasks = mysqli_query($conn, "SELECT * FROM tasks WHERE vendorID = '" . $vendor['vendorID'] . "' AND status = 'assigned'");
                $tasks = [];
                while ($task = mysqli_fetch_assoc($assignedTasks)) {
                    $tasks[] = htmlspecialchars($task['taskName']);
                }

                echo !empty($tasks) ? implode(", ", $tasks) : "No assigned tasks";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No vendors found.</p>";
        }
    }
    
//-------------------------------------------------------------
    // Handle task completion by vendor

   if (isset($_POST['complete_task'])) {
   
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);

      echo "Task ID: " . htmlspecialchars($taskID) . "<br>";
     echo "Vendor ID: " . htmlspecialchars($vendorID) . "<br>";
    
    $checkTask = "SELECT * FROM tasks WHERE taskID='$taskID' AND vendorID='$vendorID' AND status='assigned'";
    $result = mysqli_query($conn, $checkTask);

    if (!$result) {
        echo "<p style='color: red;'>Error fetching task: " . mysqli_error($conn) . "</p>";
        exit;
    }
    if (mysqli_num_rows($result) > 0) {
        $completeTask = "UPDATE tasks SET status='completed' WHERE taskID='$taskID' AND vendorID='$vendorID'";
        if (mysqli_query($conn, $completeTask)) {
            $notificationMessage = "Vendor ID $vendorID has completed Task ID $taskID.";
            $notificationSQL = "INSERT INTO notifications (message, target) VALUES ('$notificationMessage', 'management')";
            if (mysqli_query($conn, $notificationSQL)) {
                echo "<p style='color: green;'>Task marked as completed and notification sent to management!</p>";
            } else {
                echo "<p style='color: red;'>Error sending notification: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error updating task status: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Task ID $taskID does not exist or is not assigned to you.</p>";
    }
}
    
//---------------------------------------------------

                // Handle vendor update
if (isset($_POST['update_vendor'])) {
$vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
    $newVendorName = mysqli_real_escape_string($conn, $_POST['newVendorName']);
    $newAbility = mysqli_real_escape_string($conn, $_POST['newAbility']);

    
 $updateQuery = "UPDATE vendors SET ";// Prepare update query with both fields
    
        if (!empty($newVendorName)) {
        $updateQuery .= "vendorName = '$newVendorName'";
    }

    if (!empty($newAbility)) {// Append ability if provided, ensuring comma if both fields are provided
        if (!empty($newVendorName)) {
            $updateQuery .= ", ";
        }
        $updateQuery .= "ability = '$newAbility'";
    }

    $updateQuery .= " WHERE vendorID = '$vendorID'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Vendor updated successfully!";

        $notificationMessage = "Vendor ID $vendorID information has been updated.";
        $notificationSQL = "INSERT INTO notifications (message, target) VALUES ('$notificationMessage', 'vendor')";
        mysqli_query($conn, $notificationSQL);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

//------------------------------------------------------
    // Handle vendor deletion
    if (isset($_POST['delete_vendor'])) {
        $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
        $vendorName = mysqli_real_escape_string($conn, $_POST['vendorName']);

        if (!empty($vendorID)) {
            
            $deleteVendor = "DELETE FROM vendors WHERE vendorID='$vendorID'";
        } elseif (!empty($vendorName)) {
            
            $deleteVendor = "DELETE FROM vendors WHERE vendorName='$vendorName'";
        } else {
            echo "Please provide either Vendor ID or Vendor Name.";
            exit;
        }

        // Execute the query
        if (mysqli_query($conn, $deleteVendor)) {
            echo "Vendor deleted successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    //------------------------------------------------------
    //Handling file upload
    if (isset($_POST['upload'])) {
        $targetDir = "upload/";
        $file = $_FILES['file'];
    
        if ($file['error'] === 0) {
            $fileName = basename($file['name']);
            $targetPath = $targetDir . $fileName;
    
            // Move the file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                
                $sql = "INSERT INTO vendors (filename, filePath) VALUES ('$fileName', '$targetPath')";
    
                if (mysqli_query($conn, $sql)) {
                 
                    $notification = "New file uploaded: $fileName";
                    mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");
    
                    echo "File uploaded successfully!";
                } else {
                    echo "Error updating client table: " . mysqli_error($conn);
                }
            } else {
                echo "Error moving the file.";
            }
        } else {
            echo "File not uploaded. Error: " . $file['error'];
        }
    }
    
    $conn->close();
    ?>

</body>
</html>
