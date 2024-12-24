<?php
require "connection.php";
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
    <title>Client Deletion Page</title>
</head>
<body>
<div>
        <header>
    <a href="updateclient.php">updateClients</a><br>
    <a href="viewclient.php">viewClients</a><br>
    <a href="client.php">Clients</a><br>
    </header>
    </div>

    <div class="client"><h1>Delete Client</h1></div>
    <form action="deleteclient.php" method="POST" id="deleting-client">
        <label for="clientID">Client ID:</label>
        <input type="text" id="clientID" name="clientID" required><br><br>
        <button type="submit" name="deleteclient">Delete Client</button>
    </form>

</body>
</html>

    <style>
        /* General body styling */
body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background-color: #e9f0f5;
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
    margin: 0 10px;
    transition: color 0.3s;
}

header a:hover {
    color: #ffcc00; /* Change color on hover for better visibility */
}

/* Main container for the form */
.client {
    text-align: center;
    margin-top: 30px;
}

/* Form styling */
form {
    width: 360px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
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
input[type="text"] {
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

/* Input focus state */
input[type="text"]:focus {
    border-color: #007bff;
    background-color: #f0f8ff;
    outline: none;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
}

/* Button styling */
button {
    width: 100%;
    padding: 12px;
    background-color: #dc3545; /* Red for deletion */
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button hover effect */
button:hover {
    background-color: #c82333;
}

/* Notification messages */
.success, .error {
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
        document.getElementById("deleting-client").addEventListener("submit", function(event) {
            var clientID = document.getElementById("clientID").value;

         if (clientID === "") {
                alert("Please fill in the Client ID!");
                event.preventDefault(); 
            } 
             else if (isNaN(clientID)) {
                alert("Client ID must be a number!");
                event.preventDefault(); 
            } 
            // Check if clientID is a positive integer
              else if (!clientID.match(/^[0-9]+$/)) {
                alert("Client ID must be a positive integer!");
                event.preventDefault();
            }
        });
    </script>

<?php
if (isset($_POST['deleteclient'])) {
    $clientID = mysqli_real_escape_string($conn, $_POST['clientID']);

    $sql = "DELETE FROM clients WHERE clientID = '$clientID'";
    $delete = $conn->query($sql);

    if ($delete) {
        echo "Client deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
