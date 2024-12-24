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
    <title>Document</title>
</head>
<body>
    <div>
        <header>
    <a href="vendors.php">vendor page</a><br>
    <a href="managment.php">managment page</a><br>
    <a href="client.php">client registeral page</a><br>
    </header>    
   </div>
<h2>Retrieve Tasks</h2>
<form action="job.php" method="POST">
    <label for="taskID">Task ID:</label>
    <input type="text" name="taskID"><br>

    <label for="clientName">Client Name:</label>
    <input type="text" name="clientName"><br>

    <label for="status">Task Status:</label>
    <select name="status">
        <option value="">Any</option>
        <option value="pending">Pending</option>
        <option value="assigned">Assigned</option>
        <option value="completed">Completed</option>
    </select><br>

    <button type="submit">Retrieve Tasks</button>
</form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $clientName = mysqli_real_escape_string($conn, $_POST['clientName']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "SELECT tasks.*, clients.clientName FROM tasks 
              JOIN clients ON tasks.clientID = clients.clientID 
              WHERE 1=1";

    if (!empty($taskID)) {
        $query .= " AND tasks.taskID = '$taskID'";
    }
    if (!empty($clientName)) {
        $query .= " AND clients.clientName LIKE '%$clientName%'";
    }
    if (!empty($status)) {
        $query .= " AND tasks.status = '$status'";
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Client Name</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>";
        while ($task = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$task['taskID']}</td>
                    <td>{$task['taskName']}</td>
                    <td>{$task['clientName']}</td>
                    <td>{$task['status']}</td>
                    <td>{$task['created_at']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No tasks found.";
    }
}

$notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE message LIKE '%task%' ORDER BY created_at DESC LIMIT 5");

echo "<h2>Recent Task Notifications</h2><ul>";
while ($notification = mysqli_fetch_assoc($notifications)) {
    echo "<li>" . $notification['message'] . " - " . $notification['created_at'] . "</li>";
}
echo "</ul>";


?>

<style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4; /* Light background */
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
    color: #12343b; /* Dark blue for headings */
    margin: 20px 0 10px; 
    text-align: center;
}

form {
    background-color: white; /* White background for form */
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 20px;
    max-width: 500px;
    margin: 20px auto;
}

label {
    display: block;
    margin: 10px 0 5px; 
}

input[type="text"],
select {
    width: calc(100% - 20px); 
    padding: 10px; 
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
}

button {
    background-color: #12343b; /* Night Blue Shadow */
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s; /* Smooth transition */
    display: block;
    margin: 0 auto; /* Center the button */
}

button:hover {
    background-color: #0f2a47; /* Darker blue on hover */
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ddd; /* Light border for table and cells */
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #12343b; /* Dark blue header for table */
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Alternate row colors for readability */
}

ul {
    list-style-type: none; /* Remove default bullet points */
    padding: 0;
    max-width: 500px;
    margin: 20px auto;
}

ul li {
    background-color: white; /* White background for list items */
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin: 5px 0;
}

ul li:hover {
    background-color: #f1f1f1; /* Light gray hover effect */
}

</style>