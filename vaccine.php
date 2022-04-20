<?php
session_start();
$NID=$_SESSION['num'];
$pc=$_SESSION['post'];
$mysqli = new mysqli ('localhost', 'root', '', 'mydb');
$sql = $mysqli->query("SELECT * FROM `vaccinecenter` where `vaccinecenter`.`PostCode` = $pc ");
$sqll = $mysqli->query("SELECT * FROM VACCINE");



if(isset($_POST['done']))
{
    $cid = $_POST['center'];
    $vid = $_POST['vaccine'];

    $cid = (int) $cid;
    $vid = (int) $vid;

    


    $uew=$mysqli->query("select RegistrationNO from `user_information` where `NIDNO`= $NID");
    $uu=$uew->fetch_assoc();

    $pt= (int)$uu["RegistrationNO"];

    $winset = $mysqli->query("INSERT INTO `workeraccess`(`RegistrationNO`,`Dose1`, `Dose2`) VALUES ('$pt','NO','NO')");

    $lsdf = $mysqli->query("INSERT INTO `msg`(`Reg`) VALUES ('$pt')");

    $update = $mysqli->query("UPDATE user_information SET VaccineBatch = $vid, CenterID = $cid WHERE RegistrationNO = $pt ");
    if($update)
    {
        echo "your registration is successfully completed.";
            header("Location: connect.php");

    }
    else {
        die("Please Enter Center ID and VACCINE BATCH NO CORRECTLY.");
    }

}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Vaccine Registration and Management System</title>
</head>

<body style="background:  url(https://news.cgtn.com/news/2021-03-19/China-s-latest-COVID-19-vaccine-may-ease-high-production-pressure-YLdBQZG2qI/img/63586a48be50438b99118ace17e19bd5/63586a48be50438b99118ace17e19bd5-1920.jpeg); height: 100%; width:100%;background-size: cover;
    position: fixed;">
<style>
    .choose{
        background: url("https://png.pngtree.com/thumb_back/fh260/background/20200821/pngtree-light-white-background-wallpaper-image_396584.jpg");
        position: absolute;
        right: 300px;
        top: 100px;
    }
</style>

    <div class="choose">
        <?php
            echo "<h2> LIST OF HOSPITAL </h2>". "<br>";

            echo "<table border='1'>
            <tr>
            <th>Center ID:</th>
            <th>Center Name:</th>
            </tr>";

            while($row = $sql->fetch_assoc())
            {
            echo "<tr>";
            echo "<td>" . $row['CenterID'] . "</td>";
            echo "<td>" . $row['HospitalName'] . "</td>";
            echo "</tr>";
            }
            echo "</table>";

            echo "<br>"."<h2> LIST OF VACCINE </h2>". "<br>";

            echo "<table border='1'>
            <tr>
            <th>BATCH NO:</th>
            <th>VACCINE Name:</th>
            </tr>";

            while($rowW = $sqll->fetch_assoc())
            {
            echo "<tr>";
            echo "<td>" . $rowW['VID'] . "</td>";
            echo "<td>" . $rowW['Name'] . "</td>";
            echo "</tr>";
            }
            echo "</table>";
        ?>
    </div>
    <style>
    .box{
        position: absolute;
        left: 200px;
        top: 100px;
        
    }
</style>


    <Div class="box">
    <style>
        .input-box {
            width: 50%;
            background: transparent;
            border: 1px solid rgb(0, 0, 0);
            margin: 6px 0;
            height: 32px;
            border-radius: 20px;
            padding: 0 10px;
            box-sizing: border-box;
            outline: none;
            text-align: center;
            color: rgb(10, 7, 7);
        }
    </style>

    <form method="POST" action="">

    <h3>Enter the Hospital Center ID you want to choose:</h3>
        <input type="number" name="center" class="input-box" placeholder="Center ID" required>
        <br>
        <h3>Enter Vaccine Batch No. you want to take:</h3>
        <input type="number" name="vaccine" class="input-box" placeholder="Batch No" required>
        <h3>Click submit If you enter the correct ID and No.</h3>
        <input type="submit" value="submit" name="done" class="input-box">
    </form>
    </Div>
   
</body>
</html>
