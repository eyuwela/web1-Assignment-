<ul>
    <?php while ($row = mysqli_fetch_assoc($vendorNotifications)): ?>
        <li><?php echo $row['message']; ?> - <?php echo $row['created_at']; ?></li>
    <?php endwhile; ?>
</ul>
    <ul>
        <?php
        if (mysqli_num_rows($notificationsQuery) > 0) {
            while ($notification = mysqli_fetch_assoc($notificationsQuery)) {
                echo "<li>" .$notification['message'] . "</li>";
            }
        } else {
            echo "<li>No notifications found.</li>";
        }
        ?>
    </ul>


    <h2>Confirm or Reject Vendors</h2>
    <form action="managment.php" method="POST">
        <label for="vendorID">Select Vendor:</label>
        <select name="vendorID">
            <?php while ($vendor = mysqli_fetch_assoc($vendors)) { ?>
                <option value="<?php echo $vendor['vendorID']; ?>">
                    <?php echo $vendor['vendorName']; ?> (ID: <?php echo $vendor['vendorID']; ?>)
                </option>
            <?php } ?>
        </select><br><br>
        <button type="submit" name="confirm_vendor">Confirm Vendor</button>
        <button type="submit" name="reject_vendor">Reject Vendor</button>
    </form>

    // Handle confirmation/rejection for vendor
    if (isset($_POST['confirm_vendor'])) {
        if (!empty($_POST['vendorID'])) {
            $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
    
            $notification = "Vendor ID $vendorID has been confirmed.";
            mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");
            echo "Vendor confirmed successfully!";
        } else {
            echo "Please select a vendor to confirm.";
        }
    }
    
    if (isset($_POST['reject_vendor'])) {
        if (!empty($_POST['vendorID'])) {
            $vendorID = mysqli_real_escape_string($conn, $_POST['vendorID']);
            
            $notification = "Vendor ID $vendorID has been rejected.";
            mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification')");
            
            $deleteVendor = "DELETE FROM vendors WHERE vendorID='$vendorID'";
            if (mysqli_query($conn, $deleteVendor)) {
                echo "Vendor rejected and removed successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Please select a vendor to reject.";
        }
    }<h2>Confirm or Reject Vendors</h2>
    <form action="managment.php" method="POST">
        <label for="vendorID">Select Vendor:</label>
        <select name="vendorID">
            <?php while ($vendor = mysqli_fetch_assoc($vendors)) { ?>
                <option value="<?php echo $vendor['vendorID']; ?>">
                    <?php echo $vendor['vendorName']; ?> (ID: <?php echo $vendor['vendorID']; ?>)
                </option>
            <?php } ?>
        </select><br><br>
        <button type="submit" name="confirm_vendor">Confirm Vendor</button>
        <button type="submit" name="reject_vendor">Reject Vendor</button>
    </form>



    // Handle deletion of notifications
if (isset($_POST['delete_notification'])) {
    $notificationID = mysqli_real_escape_string($conn, $_POST['notificationID']);
    
    // Fetch the original notification details
    $notificationQuery = "SELECT * FROM notifications WHERE id = '$notificationID'";
    $result = mysqli_query($conn, $notificationQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        
        $deleteNotificationSQL = "INSERT INTO deleted_notifications (message, target, original_created_at)
                                  VALUES ('{$row['message']}', '{$row['target']}', '{$row['created_at']}')";
        
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



 <!-- Vendor Task Completion Form -->
 <h2>Mark Task as Completed</h2>
<form action="vendors.php" method="POST">
    <label for="taskID">Select Task to Mark as Completed:</label>
    <select name="taskID" required>
        <?php
       
    $vendorID = 1; 
        $tasksQuery = "SELECT * FROM tasks WHERE vendorID = '$vendorID' AND status = 'assigned'";
        $tasks = mysqli_query($conn, $tasksQuery);

        // Check if the query ran successfully
        if (!$tasks) {
            echo "Error fetching tasks: " . mysqli_error($conn);
        }

        if (mysqli_num_rows($tasks) > 0) {
            while ($task = mysqli_fetch_assoc($tasks)) { ?>
                <option value="<?php echo $task['taskID']; ?>">
                    <?php echo htmlspecialchars($task['taskName']); ?> (Task ID: <?php echo htmlspecialchars($task['taskID']); ?>)
                </option>
            <?php }
        } 
        ?>
    </select><br>

    <input type="hidden" name="vendorID" value="<?php echo ($vendorID); ?>">
    <button type="submit" name="complete_task">Complete Task</button>
</form>




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
    <title> Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<header>
        <a href="AboutUs.php">About Us</a>
    </header>

    <div class="container">
        <h1 class="title">Login Page</h1>
        <form method="post" action="loginpage.php" id="loginForm">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="UserName" id="UserName" placeholder="User Name" required>
                <label for="UserName">User Name</label>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>


</body>
</html>

<script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            // Fetch the input values
             const username = document.getElementById('UserName').value.trim();
        const password = document.getElementById('password').value.trim();

             if (username === "" || password === "") {
                event.preventDefault();
                alert('Please fill in both Username and Password fields.');
            }  
            
             const usernamePattern = /^[a-z]+$/;
            const passwordPattern = /^[a-z]+$/;
         if (!usernamePattern.test(username)) {
                event.preventDefault();
                alert('Username must contain only lowercase letters without numbers or special characters.');
                return;
            }
              if (!passwordPattern.test(password)) {
                event.preventDefault();
                alert('password must contain only lowercase letters without numbers or special characters.');
                return;
            }
               if(!isNaN(username)){
                event.preventDefault();
                alert('username must not be a number!');
                return;
            }
        if(!isNaN(password)){
                event.preventDefault();
                alert('password must not be a number!');
                return;
            }
        });
    </script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = mysqli_real_escape_string($conn, $_POST['UserName']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        header("Location: client.php");
        exit;
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}
?>
<!--
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        header {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        header a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .title {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
            text-align: left;
        }

        .form-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .form-group input {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-group label {
            position: absolute;
            top: -10px;
            left: 45px;
            background: white;
            padding: 0 5px;
            color: #555;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
-->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <header>
            <a href="loginpage.php">Home Page</a> <!-- Removed duplicate home page link -->
        </header>
    </div>

    <section class="about-us">
        <div class="about">
            <!-- Project explanation image appears first -->
            <img src="project explanation.png" class="pic" alt="Project Explanation Image" />
            <div class="text">
                <h2>Project Explanation</h2>
                <h5><span>Mado's</span> Digital Outsourcing Platform</h5>
                <p>
                    This platform is an outsourcing application designed to bridge the gap between clients
                    seeking mainly creative services and pre-vetted vendors offering their expertise. This application
                    serves as a mediator, ensuring that clients can easily find reliable service providers while vendors
                    gain access to a steady stream of job opportunities.
                </p>
            </div>
        </div>
        <!-- Larger Project 2 image below all -->
        <div class="image-container">
            <img src="project2.png" alt="Project 2 Image" class="pic-large">
        </div>
    </section>
</body>
</html>



<style>
 @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

.about-us {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 140px 0 90px; /* Added 140px top padding to avoid content being covered */
  background: #fff;
}

#link a {
  color: #12343b;
  text-decoration: none;
  font-size: 18px;
  font-weight: bold;
}

#link a:hover {
  color: #ff9900;
  text-decoration: underline;
}

.about {
  width: 1130px;
  max-width: 85%;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-around;
}

.pic {
  height: auto;
  width: 300px;
  border-radius: 12px;
  margin-right: 20px; /* Space between image and text */
}

.text {
  width: 540px;
  text-align: center;
}

.text h2 {
  color: #333;
  font-size: 50px;
  font-weight: 600;
  margin-bottom: 10px;
}

.text h5 {
  color: #333;
  font-size: 22px;
  font-weight: 500;
  margin-bottom: 20px;
}

span {
  color: #4070f4;
}

.text p {
  color: #333;
  font-size: 18px;
  line-height: 25px;
  letter-spacing: 1px;
}

.image-container {
  margin-top: 40px;
  text-align: center;
}

.pic-large {
  height: auto;
  width: 80%;
  max-width: 800px;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

@media screen and (max-width: 768px) {
  .text {
    width: 100%;
  }

  .text h2 {
    font-size: 40px;
  }

  .text h5 {
    font-size: 18px;
  }

  .text p {
    font-size: 16px;
  }

  .pic-large {
    width: 100%;
    max-width: 400px;
  }
}
</style>


        <!-- client css -->

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #eaeff2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
    color: #333;
}

/* Navigation Links */
header {
    text-align: center;
    margin-bottom: 30px;
}

header a {
    text-decoration: none;
    color: #007bff;
    font-weight: 600;
    font-size: 18px;
    margin-right: 20px;
    transition: color 0.3s;
}

header a:hover {
    color: #0056b3;
}

/* Container for Form */
.client {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    text-align: center;
    width: 100%;
    max-width: 600px;
    transition: transform 0.3s;
}

.client:hover {
    transform: scale(1.02);
}

.client h1 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

form label {
    font-weight: bold;
    color: #555;
    margin-bottom: 5px;
    font-size: 16px;
}

form input[type="text"],
form input[type="email"],
form textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    background-color: #f9f9f9;
    transition: border-color 0.3s;
}

form input[type="text"]:focus,
form input[type="email"]:focus,
form textarea:focus {
    border-color: #007bff;
    background-color: #ffffff;
}

form textarea {
    min-height: 100px;
    resize: vertical;
}

form button {
    padding: 12px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #0056b3;
}

/* File Upload */
input[type="file"] {
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

/* Notifications Section */
h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #007bff;
    text-align: center;
}

ul {
    list-style-type: none;
    padding-left: 0;
}

ul li {
    background-color: #f0f8ff;
    color: #333;
    border-left: 4px solid #007bff;
    padding: 12px;
    margin-bottom: 12px;
    border-radius: 6px;
    font-size: 16px;
}

@media (max-width: 768px) {
    form {
        width: 100%;
        padding: 0 15px;
    }

    header a {
        font-size: 16px;
        margin-right: 10px;
    }

    .client {
        padding: 20px;
    }
}
    </style>

    <!-- ------------------------------------------------ -->

   