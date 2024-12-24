<?php
require "connection.php";
$conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>client updateing page</title>
</head>
<body>

<div>
        <header>
    <a href="client.php">Clients</a><br>
    <a href="viewclient.php">viewClients</a><br>
    <a href="deleteclient.php">deleteClients</a><br>
    </header>
    </div>
      <!--for updating client -->
      <div class="client"><h1>Update Client</h1></div>
    <form action="updateclient.php" method="POST" id="update-client">
        <label for="updateClientID">Client ID:</label>
            <input type="text" id="updateClientID" name="updateClientID" required><br><br>

            <label for="updateClientName">New Name:</label>
        <input type="text" id="updateClientName" name="updateClientName"><br><br>
        
            <label for="updateClientPhone">New Phone:</label>
        <input type="text" id="updateClientPhone" name="updateClientPhone"><br><br>
        
        <label for="updateClientEmail">New Email:</label>
            <input type="email" id="updateClientEmail" name="updateClientEmail"><br><br>
        
        <label for="updateContractTerms">New Contract Terms:</label>
            <textarea id="updateContractTerms" name="updateContractTerms"></textarea><br><br>
        
            <label for="updateContractDetails">New Contract Details:</label>
        <textarea id="updateContractDetails" name="updateContractDetails"></textarea><br><br>
        
        <button type="submit" name="updateclient">Update Client</button>
    </form>
</body>
</html>

        <style>
            
body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Header styling */
header {
    background-color: #007bff;
    padding: 10px 20px;
    text-align: center;
    color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Header links styling */
header a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    transition: color 0.3s;
}

header a:hover {
    color: #ffcc00; 
}

/* Main container for the form */
.client {
    text-align: center;
    margin-top: 30px;
}

/* Form styling */
form {
    width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
}

/* Form heading */
.client h1 {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Form labels */
label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: #666;
}

/* Input styling */
input[type="text"],
input[type="email"],
textarea {
    width: calc(100% - 16px); /* Ensures padding doesn't affect width */
    padding: 10px;
    margin-bottom: 14px;
    border: 1px solid #c4c4c4;
    border-radius: 6px;
    font-size: 14px;
    color: #333;
    background-color: #fafafa;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.03);
}

/* Textarea specific styling */
textarea {
    resize: vertical;
}

/* Input focus state */
input:focus,
textarea:focus {
    border-color: #007bff;
    background-color: #f0f8ff;
    outline: none;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
}

/* Button styling */
button {
    width: 100%;
    padding: 12px;
    background-color: #28a745; /* Green for success */
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button hover effect */
button:hover {
    background-color: #218838; /* Darker green on hover */
}

/* Notification messages */
.notification {
    text-align: center;
    margin-top: 20px;
    font-size: 16px;
}

.success {
    color: #28a745; /* Green for success */
}

.error {
    color: #dc3545; /* Red for error */
}

        </style>


<script>
    document.getElementById("update-client").addEventListener("submit", function(event) {
          var clientID = document.getElementById("updateClientID").value;
        var clientName = document.getElementById("updateClientName").value;
            var clientPhone = document.getElementById("updateClientPhone").value;
        var clientEmail = document.getElementById("updateClientEmail").value;

            if (clientID === "" || isNaN(clientID) || !clientID.match(/^[0-9]+$/)) {
            alert("Please provide a valid Client ID (must be a positive number).");
            event.preventDefault(); // Prevent form submission
            return;
        }
        if (clientName !== "" && !clientName.match(/^[a-zA-Z\s]+$/)) {
            alert("Client Name must only contain letters and spaces.");
            event.preventDefault();
            return;
        }
            if (clientPhone !== "" && (isNaN(clientPhone) || !clientPhone.match(/^[0-9]+$/))) {
            alert("Client Phone must be a positive number.");
            event.preventDefault();
            return;
        }
        if (clientEmail !== "" && !clientEmail.match(/^\S+@\S+\.\S+$/)) {
            alert("Please provide a valid email address.");
            event.preventDefault();
            return;
        }

    });
</script>

<?php
if (isset($_POST['updateclient'])) {
    $updateClientID = mysqli_real_escape_string($conn, $_POST['updateClientID']);
       $updateClientName = mysqli_real_escape_string($conn, $_POST['updateClientName']);
    $updateClientPhone = mysqli_real_escape_string($conn, $_POST['updateClientPhone']);
      $updateClientEmail = mysqli_real_escape_string($conn, $_POST['updateClientEmail']);
     $updateContractTerms = mysqli_real_escape_string($conn, $_POST['updateContractTerms']);
    $updateContractDetails = mysqli_real_escape_string($conn, $_POST['updateContractDetails']);

    // Update query using COALESCE to keep existing values if fields are empty
    $sql = "UPDATE clients SET 
                 clientName = COALESCE(NULLIF('$updateClientName', ''), clientName),
                clientPhone = COALESCE(NULLIF('$updateClientPhone', ''), clientPhone),
                clientEmail = COALESCE(NULLIF('$updateClientEmail', ''), clientEmail),
                contractTerms = COALESCE(NULLIF('$updateContractTerms', ''), contractTerms),
                contractDetails = COALESCE(NULLIF('$updateContractDetails', ''), contractDetails)
            WHERE clientID = '$updateClientID'";

    if (mysqli_query($conn, $sql)) {
        echo "Client updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


$conn->close(); 
?>