<?php 
//session_start();
ob_start(); // Start output buffering
require("connection.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration Page</title>
</head>
<body>

<!-- Navigation Links -->
<div>
    <header id="links">
        <a href="updateclient.php">Update Clients</a><br>
        <a href="viewclient.php">View Clients</a><br>
        <a href="deleteclient.php">Delete Clients</a><br>
        <a href="vendors.php">Vendor Page</a><br>
        <a href="managment.php">Management Page</a><br>
        <a href="job.php">Job Page</a><br>
    </header>
</div>

<!-- Display client Notifications -->
<ul>
    <?php
    
    $notificationQuery = "SELECT * FROM notifications WHERE target = 'client' ORDER BY created_at DESC LIMIT 5";
    $notifications = mysqli_query($conn, $notificationQuery);
    
    // Check if notifications exist
    if ($notifications && mysqli_num_rows($notifications) > 0): 
        while ($row = mysqli_fetch_assoc($notifications)): ?>
            <li>
                <?php echo htmlspecialchars($row['message']); ?> - <?php echo htmlspecialchars($row['created_at']); ?>
                <form method="POST" action="client.php" style="display:inline;">
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
<form method="POST" action="client.php">
    <label for="managementMessage">Message:</label><br>
    <textarea name="managementMessage" id="managementMessage" rows="4" cols="50" required></textarea><br><br>
    <button type="submit" name="send_notification">Send Notification</button>
</form>

<!-- ---------------------------------------------------------- -->

<!-- Client Registration Form -->
<div class="client"><h1>Clients Registration</h1></div>
<form id="client-registeral" action="client.php" method="POST">
    <label for="clientName">Name:</label>
    <input type="text" id="clientName" name="clientName" required><br><br>
  
    <label for="clientPhone">Phone:</label>
    <input type="text" id="clientPhone" name="clientPhone" required><br><br>

    <label for="clientEmail">Email:</label>
    <input type="email" id="clientEmail" name="clientEmail" required><br><br>
  
    <label for="contractTerms">Contract Terms:</label>
    <textarea id="contractTerms" name="contractTerms" required></textarea><br><br>
  
    <label for="contractDetails">Contract Details:</label>
    <textarea id="contractDetails" name="contractDetails" required></textarea><br><br>
  
    <button type="submit" name="submit">Register</button><br>
</form>

        <!--uploading file form -->

        <form action="client.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="file">
            <br><button type="submit" name="upload">upload file</button>
        </form>

</body>
</html>

    <!--css styling -->
 <style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: aliceblue;
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: auto 1fr;
    height: 100vh;
    justify-content: center;
    align-items: center;
    color: #333;
}

/* Navigation Links */
header {
    background-color: aquamarine;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
}

header a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    font-size: 18px;
    margin-right: 20px;
    transition: color 0.3s, background-color 0.3s;
}

header a:hover {
    color: white;
    background-color: #007bff;
    padding: 5px 10px;
    border-radius: 5px;
}

/* Client Section */
.client {
    background-color: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 600px;
    margin: 0 auto 30px;
    transition: transform 0.3s;
}

.client:hover {
    transform: scale(1.02);
}

.client h1 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 20px;
}

form label {
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 5px;
}

form input,
form textarea {
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    font-size: 16px;
    transition: border-color 0.3s;
}

form input:focus,
form textarea:focus {
    border-color: #007bff;
    background-color: white;
}

form button {
    padding: 12px;
    background-color: aqua;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #007bff;
    color: white;
}

/* Notifications Section */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background-color: #f0f8ff;
    border-left: 4px solid #007bff;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

ul li:hover {
    background-color: #e0f0ff;
}

/* File Upload */
input[type="file"] {
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    font-size: 16px;
}

@media (max-width: 768px) {
    body {
        grid-template-rows: auto;
    }

    header a {
        font-size: 16px;
        margin-right: 10px;
    }

    .client {
        width: 90%;
    }

    form {
        padding: 10px;
    }
}

    </style>

<!-- JavaScript for Form Validation -->
<script>
    document.getElementById("client-registeral").addEventListener("submit", function(event) {
        var name = document.getElementById("clientName").value;
        var phone = document.getElementById("clientPhone").value;
        var email = document.getElementById("clientEmail").value;
        var contractDetails  = document.getElementById("contractDetails").value;
        var contractTerms = document.getElementById("contractTerms").value;

        if (name === "" || phone === "" || email === "" || contractDetails === "" || contractTerms === "") {
            alert("All fields are required!");
            event.preventDefault();
        } else if (isNaN(phone) || phone.length !== 10) {
            alert("Phone number must be a 10-digit number.");
            event.preventDefault();
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert("Enter a valid email!");
            event.preventDefault();
        }
    });
</script>

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


// PHP for handling client registration and notifications

if (isset($_POST['submit'])) {
    
      $clientName = mysqli_real_escape_string($conn, $_POST['clientName']);
    $clientPhone = mysqli_real_escape_string($conn, $_POST['clientPhone']);
     $clientEmail = mysqli_real_escape_string($conn, $_POST['clientEmail']);
    $contractTerms = mysqli_real_escape_string($conn, $_POST['contractTerms']);
      $contractDetails = mysqli_real_escape_string($conn, $_POST['contractDetails']);


    $sql = "INSERT INTO clients (clientName, clientPhone, clientEmail, contractTerms, contractDetails) 
            VALUES ('$clientName', '$clientPhone', '$clientEmail', '$contractTerms', '$contractDetails')";

    
    if (mysqli_query($conn, $sql)) {
        
        $notification = "New client registered: $clientName";
        mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");

        
        header("Location: client.php");// Redirect to prevent form resubmission
        exit(); // Stop script execution after redirection
    } else {
        // Error handling and notification for registration failure
        $error_message = mysqli_error($conn);
        $notification = "Client registration failed for: $clientName. Error: $error_message";
        mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");

        echo "Error: " . $sql . "<br>" . $error_message;
    }
}


if (isset($_POST['upload'])) {
    $targetDir = "upload/";
    $file = $_FILES['file'];

    if ($file['error'] === 0) {
        $fileName = basename($file['name']);
        $targetPath = $targetDir . $fileName;

        // Move the file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            
            $sql = "INSERT INTO clients (filename, filePath) VALUES ('$fileName', '$targetPath')";

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
ob_end_flush(); // End output buffering
$conn->close();
?>
