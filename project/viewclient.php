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
    <title>client List page</title>
</head>
<body>
<div>
        <header>
    <a href="updateclient.php">updateClients</a><br>
    <a href="client.php">Clients</a><br>
    <a href="deleteclient.php">deleteClients</a><br>
    </header>
    </div>

            <!-- separate form for client list -->
            <div class="client"><h1>View Clients</h1></div>
    <form action="viewclient.php" method="POST" id="view-client">
        <label for="clientID">ID:</label>
        <input type="text" id="clientID" name="clientID"><br><br>
      
        <label for="clientName">Name:</label>
        <input type="text" id="clientName" name="clientName"><br><br>
      
        <label for="clientPhone">Phone:</label>
        <input type="text" id="clientPhone" name="clientPhone"><br><br>

        <button type="submit" name="viewclient">View Clients</button>
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

.client {
    text-align: center;
    margin-top: 20px;
}

form {
    background-color: white; 
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 20px;
    max-width: 500px;
    margin: 20px auto; 
}

label {
    display: block; /* Stack labels and inputs */
    margin: 10px 0 5px;
}

input[type="text"],
input[type="email"],
textarea {
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

table {
    width: 100%;
    border-collapse: collapse; /* Combine borders */
    margin-top: 20px; /* Space above the table */
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd; /* Light border for rows */
}

th {
    background-color: #f4f4f4; /* Light background for header */
}

tr:hover {
    background-color: #f1f1f1; /* Change background on row hover */
}

        </style>


<script>
    document.getElementById("view-client").addEventListener("submit", function(event) {
         var clientID = document.getElementById("clientID").value;
        var clientName = document.getElementById("clientName").value;
         var clientPhone = document.getElementById("clientPhone").value;
        if (clientID === "" && clientName === "" && clientPhone === "") {
            alert("Please fill at least one of the fields (Client ID, Client Name, or Client Phone)!");
            event.preventDefault();
            return; // Stop further validation if this fails
        }
             if (clientID !== "" && isNaN(clientID)) {
            alert("Client ID must be a number!");
            event.preventDefault();
        } else if (clientID !== "" && !clientID.match(/^[0-9]+$/)) {
            alert("Client ID must be a positive integer!");
            event.preventDefault();
        }
           if (clientName !== "" && !clientName.match(/^[a-zA-Z\s]+$/)) {
            alert("Client Name must only contain letters and spaces!");
            event.preventDefault();
        }

        if (clientPhone !== "" && (isNaN(clientPhone) || !clientPhone.match(/^[0-9]+$/))) {
            alert("Client Phone must be a positive integer!");
            event.preventDefault();
        }
    });
</script>



<?php
    /* for viewing the client */
    if (isset($_POST['viewclient'])) {
         $id = mysqli_real_escape_string($conn, $_POST['clientID']);
          $name = mysqli_real_escape_string($conn, $_POST['clientName']);
        $phone = mysqli_real_escape_string($conn, $_POST['clientPhone']);

         $query = "SELECT * FROM clients WHERE 1=1"; // '1=1' is a placeholder to make adding conditions easier
            if (!empty($id)) {
            $query .= " AND clientID = '$id'";
         }
            if (!empty($name)) {
            $query .= " AND clientName LIKE '%$name%'";
          }
        if (!empty($phone)) {
            $query .= " AND clientPhone = '$phone'";
        }

       
     $result = $conn->query($query); // Execute the query

        if ($result && $result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>
                    <tr>
                         <th>Client ID</th>
                         <th>Client Name</th>
                        <th>Client Phone</th>
                        <th>Client Email</th>
                        <th>Contract Terms</th>
                        <th>Contract Details</th>
                    </tr>";
 while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['clientID']}</td>
                        <td>{$row['clientName']}</td>
                         <td>{$row['clientPhone']}</td>
                        <td>{$row['clientEmail']}</td>
                         <td>{$row['contractTerms']}</td>
                          <td>{$row['contractDetails']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No clients found matching the criteria.";
        }
    }

$conn->close(); 
?>