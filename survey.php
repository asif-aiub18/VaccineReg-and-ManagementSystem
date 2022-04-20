<?php
session_start();
$N=$_SESSION['NID'];

$hos=null;

$mysqli = new mysqli ('localhost', 'root', '', 'mydb');

$sql = $mysqli->query("SELECT * FROM `national_database` where `national_database`.`NID NO` = $N limit 1");

$data=$sql->fetch_assoc();



?>

<!DOCTYPE html>
<html>
<head>
  <title>Vaccine Registration and Management System</title>
</head>

<style>
    .ox{
        position: absolute;
        left: 240px;
        top: 100px;
        
    }
</style>
<body style="background:  url(https://www.everbridge.com/wp-content/uploads/covid-vaccine-registration.jpg); height: 100%; width:100%;background-size: cover;
    position: fixed;">
<div class="ox">
<h2>Your Details:</h2>
<style>
    
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }
    th, td {
    padding: 7px;
    text-align: left;
    }
</style>
    
<table style="width:80%">
<tr>
<th>NID NO:</th>
<td><?php echo $data["NID NO"]; ?></td>
</tr>
<tr>
<th>First Name:</th>
<td><?php echo $data["First_Name"]; ?></td>
</tr>
<tr>
<th>Last Name:</th>
<td><?php echo $data["Last_Name"]; ?></td>
</tr>
<tr>
<th>Father's Name:</th>
<td><?php echo $data["Father's Name"]; ?></td>
</tr>
<tr>
<th>Mother's Name:</th>
<td><?php echo $data["Mother's Name"]; ?></td>
</tr>
<tr>
<th>Blood Group:</th>
<td><?php echo $data["Blood Group"]; ?></td>
</tr>


</table>
<br>
<br>
<style>
    .input-box {
    width: 40%;
    background: white;
    border: 1px solid rgb(0, 0, 0);
    margin: 6px 0;
    height: 32px;
    border-radius: 5px;
    padding: 0 10px;
    box-sizing: border-box;
    outline: none;
    text-align: center;
    color: rgb(10, 7, 7);
    }

    ::placeholder {
        color: rgb(0, 0, 0);
        font-size: 12px;
    }
</style>

<h2>From where you want to take your Vaccine:</h2>

    <form method="POST" action="">
        <input type="number" name="pstcode" class="input-box" placeholder="Post Code" required>
        <input type="submit" value="Enter" name="done" class="input-box">
    </form>

    <?php
    if(isset($_POST['done']))
    {
        $hos = $_POST['pstcode'];
        $check = $mysqli->query("SELECT * FROM `vaccinecenter`");

        while($tt=$check->fetch_assoc())
        {
            $dd=$tt['PostCode'];
            if($dd==$hos)
            {
                session_start();

                $_SESSION['num'] = $N;
                $_SESSION['post'] = $hos;

                header("Location: vaccine.php");
            }
        }
        die ("Post Code is wrong OR there are no Vaccine hospital on that postcode.");

    }

    
    
    ?>

</div>
  
</body>
</html>