<?php
error_reporting(0);
session_start();
$p=$_SESSION['message'];
$mysqli = new mysqli ('localhost', 'root', '', 'mydb');

if(isset($_POST['Done']))
{
    $code = $_POST['code'];
    $otp = $mysqli->query("select * from `user_information` where `user_information`.`NIDNO` = $p limit 1");
    $ll = $otp->fetch_assoc();

    if($ll["vkey"]==$code)
    {
        session_start();
        $_SESSION['NID'] = $p;
        header("Location: survey.php");
    }
    else
    {
        {
            die ("Verification Code Didn't matched.");
        }

    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Registration and Management System</title>
    <link rel="stylesheet" href="Rstyle.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="content">
            <div class="logo">
                <a href="index.php">Vaccine Registration and Management System</a>
            </div>
            <ul class="menu-list">
                <div class="icon cancel-btn">
                    <i class="fas fa-times"></i>
                </div>
                <li><a href="index.php">Home</a></li>
                <li><a href="registration.php">Registration</a></li>
                <li><a href="status.php">Registration Status</a></li>
                <li><a href="GetLogin.php">Vaccine card</a></li>
                <li><a href="certificate.php">Vaccine Certificate</a></li>
                <li><a href="Web-Portal-User-Manual.pdf">Manual</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>


        <div class="outer">

            <div class="container">


                <div class="card">
                    <div class="inner-box" id="card">
                        <div class="card-front">
                            <div class="custom">
                                <form method="POST" action="">
                                    <p>Enter the Verification Code that was sent to your email.</p>
                                    <br>
                                    <br>
                                    <input type="number" name="code" class="input-box" placeholder="Verification Code" required>
                                    <br>
                                    <br>
                                    <input type="submit" value="submit" name="Done" style="background-color:lime" class="input-box">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="banner"></div>
            <div class="about">
                <div class="content">
                    <div class="title"></div>
                    <li>
                        <a href="https://corona.gov.bd/?gclid=CjwKCAjw9uKIBhA8EiwAYPUS3NT1aqhKIvAlZh0jH0X_KkBCrrE15ZV10HJw6nRhlWYTeuWjKZ-xTxoCe40QAvD_BwE">Bangladesh Covid 19 Information</a>
                    </li>
                    <li>
                        <a href="https://www.worldometers.info/coronavirus/">World Covid 19 Information</a>
                    </li>

                </div>
    </nav>



    <script>
        const body = document.querySelector("body");
        const navbar = document.querySelector(".navbar");
        const menuBtn = document.querySelector(".menu-btn");
        const cancelBtn = document.querySelector(".cancel-btn");
        menuBtn.onclick = () => {
            navbar.classList.add("show");
            menuBtn.classList.add("hide");
            body.classList.add("disabled");
        }
        cancelBtn.onclick = () => {
            body.classList.remove("disabled");
            navbar.classList.remove("show");
            menuBtn.classList.remove("hide");
        }
        window.onscroll = () => {
            this.scrollY > 20 ? navbar.classList.add("sticky") : navbar.classList.remove("sticky");
        }
    </script>

</body>

</html>