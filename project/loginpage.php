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
    <title>Login Page</title>
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
            <input type="text" name="UserName" id="user_name" placeholder="User Name" required>
            <label for="user_name">User Name</label>
        </div>

        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="PassWord" placeholder="Password" required>
            <label for="PassWord">Password</label>
        </div>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>


<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: aliceblue;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: Arial, sans-serif;
}

header {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: aquamarine;
    padding: 10px 20px;
    border-radius: 5px;
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
    background-color: aqua;
    color: #333;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    transition: 0.3s;
}

button:hover {
    background-color: #00ced1;
}

</style>

<script>
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        // Fetch the input values
        const username = document.getElementById('user_name').value.trim();
        const password = document.getElementById('PassWord').value.trim();

        if (username === "" || password === "") {
            event.preventDefault();
            alert('Please fill in Username and Password.');
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
            alert('Password must contain only lowercase letters without numbers or special characters.');
            return;
        }

        if (!isNaN(password)) {
            event.preventDefault();
            alert('Password must not be a number!');
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
