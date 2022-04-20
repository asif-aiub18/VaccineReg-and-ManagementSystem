<?php
//Include required PHPMailer files
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create instance of PHPMailer
$mail = new PHPMailer();
//Set mailer to use smtp
$mail->isSMTP();
//Define smtp host
$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
$mail->SMTPSecure = "tls";
//Port to connect smtp
$mail->Port = "587";
//Set gmail username
$mail->Username = "sadik@gmail.com";
//Set gmail password
$mail->Password = "sadik";
//Email subject
$mail->Subject = "Confirmation code from Vaccine Registration";
//Set sender email
$mail->setFrom("asif@gmail.com");
//Enable HTML
$mail->isHTML(true);

error_reporting(0);


$mysqli = new mysqli ('localhost', 'root', '', 'mydb');

    if(isset($_POST['submit']))
    {
        $NID = $_POST['NID'];
        $DB = $_POST['DB'];
        $Email = $_POST['Email'];
        $pass = $_POST['pass'];
        $copass = $_POST['CoPass'];
        $type = $_POST['options'];

        $type = $mysqli->real_escape_string($type);
        $NID = $mysqli->real_escape_string($NID);
        $DB = $mysqli->real_escape_string($DB);
        $Email = $mysqli->real_escape_string($Email);
        $pass = $mysqli->real_escape_string($pass);


        $NIDcheck = $mysqli->query("SELECT * FROM `national_database` where `national_database`.`NID NO` = $NID limit 1");
        $NIDcheck2 = $mysqli->query("SELECT * FROM `user_information` where `user_information`.`NIDNO` = $NID limit 1");

        $check = $NIDcheck->fetch_assoc();
        $check2 = $NIDcheck2->fetch_assoc();
        $date = $check["Date of Birth"];

        if($NIDcheck->num_rows > 0 && !($NID == $check2["NIDNO"]))
        {
            if( $date == $DB)
            {
                if($pass != $copass)
                {
                    die("Passwords didn't matched.");
                }
                else
                {

                    $vkey = rand();
                    $insert = $mysqli->query("INSERT INTO `user_information` (`NIDNO`, `Date of Birth`, `Email`, `vkey`, `Password`,`Type`) VALUES ('$NID','$DB', '$Email', '$vkey', '$pass', '$type')");
                    $otp = $mysqli->query("select * from `user_information` where `user_information`.`NIDNO` = $NID limit 1");
                    $ll = $otp->fetch_assoc();
                    //Email body
                    $mail->Body = $ll["vkey"];

                    //Add recipient
                    $mail->addAddress($Email);
                    //Finally send email

                    if ( $mail->send() ) 
                    {
                        session_start();
                        $_SESSION['message'] = $NID;
                        header("Location: Authentication.php");

                        
                    }
                    else
                    {
                        $Deleterow = $mysqli->query("Delete from `user_information` where `user_information`.`NID NO` = '$NID' ");
                        if($Deleterow)
                        {
                            die ("Message could not be sent. Mailer Error:");
                        }

                    }

                }
            }
            else
            {
                Die("Enter your Date of Birth Correctly.");
            }
        }
        else
        {
            die("Please enter your NID number Correctly OR you are already registered.");
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
                <li><a href="GetLogin.php">Vaccine Certificate</a></li>
                <li><a href="WebPortalUserManual.pdf">Manual</a></li>
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
                            
                            <br>
                            <br>

                            <form method="POST" action="">

                                <select name="options">
                                  <option value="AGE: 35 or Above" class="custom">AGE: 35 or Above</option>
                                  <option value="Government job" class="custom">Government job</option>
                                  <option value="Private job" class="custom">Private job</option>
                                  <option value="University Student" class="custom">University Student</option>
                                  <option value="Infnt" class="custom">Infant</option>
                                </select>


                                <input type="number" name="NID" class="input-box" placeholder="Your NID No" required>
                                <input type="date" name="DB" class="input-box" placeholder="Date of Birt" required>
                                <input type="Email" name="Email" class="input-box" placeholder="Your Email ID" required>
                                <input type="password" name="pass" class="input-box" minlength="4" maxlength="10" placeholder="Password" required>
                                <input type="password" name="CoPass" class="input-box" placeholder="Confirm Password" required> 
                                <br>
                                <br>
                                <input type="submit" value="Register" name="submit" style="background-color:lime" class="input-box" >
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
