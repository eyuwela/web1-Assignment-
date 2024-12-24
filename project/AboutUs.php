<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="loginpage.php" class="home-link">Home Page</a>
        </nav>
    </header>

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

body {
    background-color: #f5f8fa;
    color: #333;
    line-height: 1.6;
    padding: 0 20px;
}

header {
    background-color: #12343b;
    padding: 20px 0;
    text-align: center;
}

nav .home-link {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
    padding: 10px 20px;
    background-color: #ff9900;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav .home-link:hover {
    background-color: #ff7700;
}

.about-us {
    padding: 100px 0;
    background-color: #fff;
}

.about {
    width: 90%;
    max-width: 1130px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.pic {
    height: auto;
    width: 300px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-right: 30px;
    transition: transform 0.3s ease;
}

.pic:hover {
    transform: scale(1.05);
}

.text {
    max-width: 540px;
    text-align: left;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.text h2 {
    color: #12343b;
    font-size: 40px;
    margin-bottom: 10px;
}

.text h5 {
    color: #ff9900;
    font-size: 24px;
    margin-bottom: 20px;
}

span {
    color: #12343b;
}

.text p {
    color: #555;
    font-size: 18px;
    line-height: 1.8;
    letter-spacing: 0.5px;
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
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.pic-large:hover {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media screen and (max-width: 768px) {
    .about {
        flex-direction: column;
    }

    .pic {
        margin-right: 0;
        margin-bottom: 20px;
    }

    .text h2 {
        font-size: 32px;
    }

    .text h5 {
        font-size: 20px;
    }
}
</style>
