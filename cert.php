<?php

session_start();
$p=$_SESSION['sql'];

$mysqli = new mysqli ('localhost', 'root', '', 'mydb');

$sql = $mysqli->query("SELECT * FROM user_information u
                        join national_database n on n.`NID NO` = u.NIDNO
                        JOIN workeraccess w on u.RegistrationNO = w.RegistrationNO
                        JOIN vaccinecenter v on v.CenterID = u.CenterID
                        join vaccine va on u.VaccineBatch = va.VID
                        WHERE u.RegistrationNO = $p");

$data = $sql->fetch_assoc();

?>


<!DOCTYPE html>
<html>
<head>
  <title>Vaccine Registration and Management System </title>
</head>

<style>
    .ox{
        background-color: whitesmoke;
        position: absolute;
        left: 240px;
        top: 60px;
        height: 80%;
        width: 50%;
        background-size: cover;
        position: fixed;
    }
</style>
<body style="background:  url(https://www.everbridge.com/wp-content/uploads/covid-vaccine-registration.jpg); height: 100%; width:100%;background-size: cover;
    position: fixed;">

    
<div class="ox">
<h1 style="text-align: center;">Vaccine Certificate</h1>
<br><br>
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
    

<tr>
<th> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <b>REGISTRATION NO:</b> </th>
<td><?php echo $data["RegistrationNO"]; ?></td>
</tr>
<br><br>
<tr>
<th> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <b> NID NO:</b> </th>
<td><?php echo $data["NIDNO"]; ?></td>
</tr>
<br><br>
<tr>
<th>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <b>Name:</b> </th>
<td><?php echo $data["First_Name"]." ".$data["Last_Name"]; ?></td>
</tr>
<br><br>
<tr>
<th>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <b>Date of Birth:</b> </th>
<td><?php echo $data["Date of Birth"]; ?></td>
</tr>
<br><br>
<tr>
<th>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <b>Center ID:</b> </th>
<td><?php echo $data["CenterID"]; ?></td>
</tr>
<br><br>
<tr>
<th>&nbsp; &nbsp; &nbsp; &nbsp; <b>Hopital Name:</b> </th>
<td><?php echo $data["HospitalName"]; ?></td>
</tr>
<br><br><br><br>

<table style="width:40%; margin-left: 10%">
<tr>
<th>Vaccine Batch:</th>
<td><?php echo $data["VaccineBatch"]; ?></td>
</tr>
<tr>
<th>Vaccine Name:</th>
<td><?php echo $data["Name"]; ?></td>
</tr>
<tr>
<th>Dose 1 - Date:</th>
<td><?php echo $data["Does1 Date"]; ?></td>
</tr>
<tr>
<th>Dose 1:</th>
<td><?php echo $data["Dose1"]; ?></td>
</tr>
<tr>
<th>Dose 2 - Date:</th>
<td><?php echo $data["Does2 Date"]; ?></td>
</tr>
<tr>
<th>Dose 2:</th>
<td><?php echo $data["Dose2"]; ?></td>
</tr>

</table>

</div>

<style>
    @media print{
        body * {
            visibility: hidden;
        }
        .ox , .ox * {
            visibility: visible;
        }
    }
</style>

<style>
    .button{
        position: absolute;
        left: 560px;
        top: 680px;
        background-size: cover;
        position: fixed;
    }
</style>
<div class="button">
    <button onclick="window.print();">
        Print
    </button>
</div>

   
</body>
</html>