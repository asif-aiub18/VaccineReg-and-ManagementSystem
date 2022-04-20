<?php
error_reporting(0);

$mysqli = new mysqli ('localhost', 'root', '', 'mydb');

if(isset($_POST['Done']))
{
    $code1=$_POST['code1'];
    $code=$_POST['code']; 
    $NID=$_POST['NID'];
    $pass=$_POST['pass'];


    if($code1!="$code")
    {
        die ("Your code is not correct");
    }
    else
    {
    
    $check = $mysqli->query("SELECT * FROM user_information WHERE NIDNO = $NID");

        $show = $check->fetch_assoc();
        if($show["NIDNO"]==$NID)
        {
            
            if($show["Password"]==$pass)
            {
                session_start();
                $_SESSION['sql'] = $show["RegistrationNO"];
                header("Location: Card.php");
            }
            else {
                die("Your Password is not Correct.");
            }

        }
        else {
            die ("YOU ARE NOT REGISTERED.");
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

                            <form method="POST" action="">
                                <input type="number" name="NID" class="input-box" placeholder="Your NID No" required>
                                <input type="password" name="pass" class="input-box" placeholder="Password" required>
                            
                                <br><br><br>
                                <div class="rand" style=" font-size: 25px; text-align: center; background:cornsilk; ">

                                
                                 <?php $Random_code= substr(md5((mt_rand(100,900))),0,5) ; echo $Random_code; ?> </p><br />
                                 <h4>Enter the Letters Correctly:</h4>
                                 <br>
                                <input type="text" name="code1" title="random code" class="input-box" placeholder="Enter the code:"/>
                                
                                <input type="hidden" name="code" value="<?php echo $Random_code; ?>"/>
                                </div>
                                <br><br><br>
                            

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