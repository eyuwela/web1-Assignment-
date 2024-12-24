<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Login</title>
        
    </head>
    
    <body>

        <div class="container">
            <header>
                <h2><a href="AboutUs.php">About Us</a></h2>
            </header>

            <div class="formContainer">
                <h1>Login Page</h1>

                <form method="post" action="Login Page.html" id="loginForm">
                    <div class="formGroup">
                        <label for="username">Username</label>
                        <input type="text" name="UserName" id="user_name" required>
                    </div>

                    <div class="formGroup">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="PassWord" required>
                    </div>

                    <button type="submit">Login</button>
                </form>
            </div>
        </div>

        
    </body>
</html>

<style>
    *{
margin: 0;
padding: 0;
box-sizing: border-box;
}

body{
background-color: aliceblue;
display: grid;
height: 100vh;
}

header{
grid-area: header;
background-color: aquamarine;
height: 50%;
align-content: center;
}

header a{
text-decoration: none;
color: #333;
font-weight: bold;
}

.formContainer{
grid-area: formContainer;
margin: 0 auto;
align-content: center;
height: 65%;
width: 50%;

}

.formContainer h1{
margin-bottom: 20px;
font-size: 24px;
color: #333;
}

#loginForm{
margin: auto;
}

.formGroup{
position: relative;
margin-bottom: 20px;
width: 100%;
text-align: left;
}

.formGroup input{
width: 100%;
padding: 12px 40px;
border: 1px solid #ccc;
border-radius: 5px;
font-size: 16px;
}

.formGroup input:focus{
outline: none;
border-color: #007bff;
}

.formGroup label{
position: absolute;
top: -10px;
left: 45px;
background: white;
padding: 0 5px;
color: #555;
font-size: 14px;
}

button{
width: 100%;
padding: 12px;
background-color: aqua;
border-radius: 5px;
font-size: 16px;
cursor: pointer;
border: none;
transition: 0.3s;
}


.container{
display: grid;
grid-template-areas: 
'header header header header'
'formContainer formContainer formContainer formContainer'
'formContainer formContainer formContainer formContainer'
'formContainer formContainer formContainer formContainer';
}
</style>

<script>
    document.getElementById('loginForm').addEventListener('submit', function (event){
    //fetch the input
    const username = document.getElementById('user_name').value.trim();
    const password = document.getElementById('PassWord').value.trim();

    if(username === "" || password === ""){
        event.preventDefault();
        alert('Please fill in Username and Password.');
    }

    
    const usernamePattern = /^[a-z]+$/;
    const passowrdPattern = /^[a-z]+$/;

    if(!usernamePattern.test(username)){
        event.preventDefault();
        alert('Username must contain only lowercase letters without numbers or special characters.');

        return;
    }

    if(!passowrdPattern.test(password)){
        event.preventDefault();
        alert('Password must contain only lowercase letters without numbers or special characters.');

        return;
    }

    if(!isNaN(password)){
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

    // Check if the username and password match in the database
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