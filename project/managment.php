<?php
require "connection.php";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//$notifications = mysqli_query($conn, "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");

$target = (isset($_GET['target'])) ? $_GET['target'] : 'all';  // Optional filter by target
$notificationQuery = "SELECT * FROM notifications";
if ($target !== 'all') {
    $notificationQuery .= " WHERE target = '$target'";
}
$notificationQuery .= " ORDER BY created_at DESC LIMIT 5";
$notifications = mysqli_query($conn, $notificationQuery);



$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY created_at DESC");


$vendorQuery = "SELECT * FROM vendors";
$vendors = mysqli_query($conn, $vendorQuery);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Management Page</title>
</head>
<body>
    <div>
        <header>
            <a href="vendors.php">Vendor Page</a><br>
            <a href="job.php">Job Page</a><br>
            <a href="client.php">Client Registration Page</a><br>
        </header>
    </div>
    <h1>Management Dashboard</h1>

    <h2>Recent Notifications</h2>
<ul>
    <?php while ($row = mysqli_fetch_assoc($notifications)): ?>
        <li>
            <?php echo $row['message']; ?> - <?php echo $row['created_at']; ?>
            <!-- Add a delete button -->
            <form method="POST" action="managment.php" style="display:inline;">
                <input type="hidden" name="notificationID" value="<?php echo $row['id']; ?>">
                <button type="submit" name="delete_notification">Delete</button>
            </form>
        </li>
    <?php endwhile; ?>
</ul>


            <!-- Notification Section for sending notification to either for client or vendor -->
<h2>Send Notification</h2>
<form action="managment.php" method="POST">
    <label for="notification_message">Notification Message:</label><br>
    <textarea name="notification_message" id="notification_message" required></textarea><br>

    <label for="target">Send To:</label><br>
    <select name="target" id="target" required>
        <option value="client">Client</option>
        <option value="vendor">Vendor</option>
    </select><br><br>

    <button type="submit" name="send_notification">Send Notification</button>
</form>


    <!-- Recently Registered Clients Section -->
    <h2>Recently Registered Clients</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Client ID</th>
            <th>Client Name</th>
            <th>Client Phone</th>
            <th>Client Email</th>
            <th>Contract Terms</th>
            <th>Contract Details</th>
            <th>Created At</th>
            <th>file Name</th>
            <th>file Path</th>
            <th>Download file</th>
            <th>Action</th> 
        </tr>
        <?php if (mysqli_num_rows($clients) > 0): ?>
            <?php while ($client = mysqli_fetch_assoc($clients)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['clientID']); ?></td>
                    <td><?php echo htmlspecialchars($client['clientName']); ?></td>
                    <td><?php echo htmlspecialchars($client['clientPhone']); ?></td>
                    <td><?php echo htmlspecialchars($client['clientEmail']); ?></td>
                    <td><?php echo htmlspecialchars($client['contractTerms']); ?></td>
                    <td><?php echo htmlspecialchars($client['contractDetails']); ?></td>
                    <td><?php echo htmlspecialchars($client['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($client['filename']); ?></td>
                    <td><?php echo htmlspecialchars($client['filepath']); ?></td>                   
                    <td>
                    <!-- Create a Download Button -->
                    <?php if (!empty($client['filepath'])): ?>
                        <a href="<?php echo htmlspecialchars($client['filepath']); ?>" download="<?php echo htmlspecialchars($client['filename']); ?>">Download</a>
                        </a>
        
                    <?php endif; ?>
                
                </td>
                    
                    <td>
                        <!-- Reject Button Form inside the loop -->
                        <form method="POST" action="managment.php" onsubmit="return confirm('Are you sure you want to reject this client?');">
                            <input type="hidden" name="clientID" value="<?php echo htmlspecialchars($client['clientID']); ?>">
                            <button type="submit" name="reject_client">Reject Client</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No clients found.</td></tr>
        <?php endif; ?>
    </table>


    <h2>Vendor Files</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Vendor ID</th>
        <th>Vendor Name</th>
        <th>Abilities</th>
        <th>File Name</th>
        <th>Download File</th>
    </tr>
    <?php if (mysqli_num_rows($vendors) > 0): ?>
        <?php while ($vendor = mysqli_fetch_assoc($vendors)): ?>
            <tr>
                <td><?php echo htmlspecialchars($vendor['vendorID']); ?></td>
                <td><?php echo htmlspecialchars($vendor['vendorName']); ?></td>
                <td><?php echo htmlspecialchars($vendor['ability']); ?></td>
                <td><?php echo htmlspecialchars($vendor['filename']); ?></td>
                <td>
                    <?php if (!empty($vendor['filePath'])): ?>
                        <a href="<?php echo htmlspecialchars($vendor['filePath']); ?>" download="<?php echo htmlspecialchars($vendor['filename']); ?>">Download</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">No vendor files found.</td></tr>
    <?php endif; ?>
</table>



<h2>Confirm or Reject Vendors</h2>
<form action="managment.php" method="POST">
    <label for="vendorID">Enter Vendor ID:</label>
    <input type="text" name="vendorID" id="vendorID" required placeholder="Enter Vendor ID"><br><br>

    <button type="submit" name="confirm_vendor">Confirm Vendor</button>
    <button type="submit" name="reject_vendor">Reject Vendor</button>
</form>


  <!-- Task Assignment Form (Assign Task to Vendor) -->
  <h2>Assign Task to Vendor</h2>
    <form action="managment.php" method="POST">
        <label for="clientID">Select Client:</label>
        <select id="clientID" name="clientID" required>
            <?php
            
            $clientsForTask = mysqli_query($conn, "SELECT * FROM clients ORDER BY created_at DESC");
            while ($client = mysqli_fetch_assoc($clientsForTask)) {
                echo "<option value='" . htmlspecialchars($client['clientID']) . "'>" . htmlspecialchars($client['clientName']) . " (ID: " . htmlspecialchars($client['clientID']) . ")</option>";
            }
            ?>
        </select><br>

        <label for="vendorID">Select Vendor:</label>
        <select name="vendorID" required>
            <?php
         
            $vendors = mysqli_query($conn, "SELECT * FROM vendors ORDER BY vendorName ASC");
            while ($vendor = mysqli_fetch_assoc($vendors)) {
                echo "<option value='" . htmlspecialchars($vendor['vendorID']) . "'>" . htmlspecialchars($vendor['vendorName']) . " (Ability: " . htmlspecialchars($vendor['ability']) . ")</option>";
            }
            ?>
        </select><br>

        <label for="taskName">Task Name:</label>
        <textarea name="taskName" required></textarea><br>

        <button type="submit" name="assign_task_to_vendor">Assign Task</button>
    </form>

    </body>
    </html>
        <!-- ----------------------------------------- -->
            <style>
            
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
    margin: 0;
    padding: 20px;
}

header {
    background-color: #12343b; /* Night Blue Shadow */
    padding: 10px;
    text-align: center;
}

header a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
}

header a:hover {
    text-decoration: underline;
}

/* Page Title and Section Headers */
h1, h2 {
    color: #12343b;
}

h1 {
    font-size: 2em;
    margin-bottom: 20px;
}

h2 {
    font-size: 1.5em;
    margin-top: 30px;
    margin-bottom: 15px;
}

/* Form Styling */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

input[type="text"], textarea, select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

textarea {
    height: 100px;
}

button {
    background-color: #12343b;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
}

button:hover {
    background-color: #0e2b31;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #12343b;
    color: white;
}

td {
    background-color: #fff;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Notification Section */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background-color: #e7f0f5;
    padding: 10px;
    border: 1px solid #12343b;
    margin-bottom: 5px;
    border-radius: 3px;
}

            </style>

 <!-- ---------------------------------------- -->
<?php

// Handle deletion of notifications
if (isset($_POST['delete_notification'])) {
    $notificationID = mysqli_real_escape_string($conn, $_POST['notificationID']);
    
    
    $notificationQuery = "SELECT * FROM notifications WHERE id = '$notificationID'";
    $result = mysqli_query($conn, $notificationQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
                           // Escape the values before inserting into the deleted_notifications table
        $escapedMessage = mysqli_real_escape_string($conn, $row['message']);
        $escapedTarget = mysqli_real_escape_string($conn, $row['target']);
        $escapedCreatedAt = mysqli_real_escape_string($conn, $row['created_at']);
        
      
        $deleteNotificationSQL = "INSERT INTO deleted_notifications (message, target, original_created_at)
                                  VALUES ('$escapedMessage', '$escapedTarget', '$escapedCreatedAt')";
        
        if (mysqli_query($conn, $deleteNotificationSQL)) {
            
            
            $deleteOriginalSQL = "DELETE FROM notifications WHERE id = '$notificationID'";
            if (mysqli_query($conn, $deleteOriginalSQL)) {
                echo "<p style='color: green;'>Notification deleted and stored successfully!</p>";
            } else {
                echo "<p style='color: red;'>Failed to delete original notification: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Failed to store deleted notification: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Notification not found.</p>";
    }
}



     // Handle notification sending
if (isset($_POST['send_notification'])) {
    $notificationMessage = mysqli_real_escape_string($conn, $_POST['notification_message']);
    $target = mysqli_real_escape_string($conn, $_POST['target']);

   
    if ($target === 'client') {
        $notificationSQL = "INSERT INTO notifications (message, target) VALUES ('$notificationMessage', 'client')";
    } elseif ($target === 'vendor') {
        $notificationSQL = "INSERT INTO notifications (message, target) VALUES ('$notificationMessage', 'vendor')";
    }

    if (mysqli_query($conn, $notificationSQL)) {
        echo "<p style='color: green;'>Notification sent to $target!</p>";
    } else {
        echo "<p style='color: red;'>Failed to send notification: " . mysqli_error($conn) . "</p>";
    }
}


    // Handle rejecting a client
    if (isset($_POST['reject_client'])) {
        $clientID = mysqli_real_escape_string($conn, $_POST['clientID']);

       
        $checkClient = mysqli_query($conn, "SELECT * FROM clients WHERE clientID = '$clientID'");
        if (mysqli_num_rows($checkClient) > 0) {
            
            $deleteClient = "DELETE FROM clients WHERE clientID = '$clientID'";
            if (mysqli_query($conn, $deleteClient)) {
                
                $notificationMessage = "Client ID $clientID has been rejected by management.";

             
                $insertNotification = "INSERT INTO notifications (message,target) VALUES ('$notificationMessage','client')";
                if (mysqli_query($conn, $insertNotification)) {
                    echo "<p style='color: green;'>Client has been rejected and notification sent!</p>";
                } else {
                    echo "<p style='color: red;'>Client deleted but failed to insert notification: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p style='color: red;'>Error deleting client: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Client not found.</p>";
        }
    }

    // Handle assigning task to vendors
 
    if (isset($_POST['assign_task_to_vendor'])) {
        $clientID = mysqli_real_escape_string($conn, $_POST['clientID']);
        $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
        $taskName = mysqli_real_escape_string($conn, $_POST['taskName']);

        if (!empty($clientID) && !empty($vendorID) && !empty($taskName)) {
        $assignTask = "INSERT INTO tasks (taskName, clientID, status, vendorID) 
                       VALUES ('$taskName', '$clientID', 'assigned', '$vendorID')";

        if (mysqli_query($conn, $assignTask)) {
           
            $notificationMessage = mysqli_real_escape_string($conn, "Task '$taskName' has been assigned to Vendor ID $vendorID for Client ID $clientID.");

            // Create notification and include vendorID
            $notificationSQL = "INSERT INTO notifications (message, vendorID,target) VALUES ('$notificationMessage', '$vendorID','vendor')";
            if (mysqli_query($conn, $notificationSQL)) {
                echo "<p style='color: green;'>Task assigned to vendor and notification sent!</p>";
            } else {
                echo "<p style='color: red;'>Task assigned but failed to insert notification: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error assigning task: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>All fields are required.</p>";
        }
    }
    


    // Handle confirmation
if (isset($_POST['confirm_vendor'])) {
    if (!empty($_POST['vendorID'])) {
        $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
        
        
        $checkVendor = mysqli_query($conn, "SELECT * FROM vendors WHERE vendorID='$vendorID'");
        if (mysqli_num_rows($checkVendor) > 0) {
            $notification = "Vendor ID $vendorID has been confirmed.";
            mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");
            echo "Vendor confirmed successfully!";
        } else {
            echo "Vendor ID $vendorID does not exist.";
        }
    } else {
        echo "Please enter a vendor ID to confirm.";
    }
}

// Handle rejection
if (isset($_POST['reject_vendor'])) {
    if (!empty($_POST['vendorID'])) {
        $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
        
        $checkVendor = mysqli_query($conn, "SELECT * FROM vendors WHERE vendorID='$vendorID'");
        if (mysqli_num_rows($checkVendor) > 0) {
            $notification = "Vendor ID $vendorID has been rejected.";
            mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");
            
            $deleteVendor = "DELETE FROM vendors WHERE vendorID='$vendorID'";
            if (mysqli_query($conn, $deleteVendor)) {
                echo "Vendor rejected and removed successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Vendor ID $vendorID does not exist.";
        }
    } else {
        echo "Please enter a vendor ID to reject.";
    }
}

    $conn->close();
 ?>

