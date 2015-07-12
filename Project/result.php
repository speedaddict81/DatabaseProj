<?php
include "sql.php";
//include_once "session.php";
session_start();

if (isset($_POST['old']))
{
  $Srev = 0;
}
else $Srev = 1;
$getQ = "SELECT * from TAG where Last_Rev = '".$Srev."'";
if($_POST['TagNo'] !="")
{
  $getQ .= "and Tag_No='".$_POST['TagNo']."'";
}

if($_POST['RevNo'] !="")
{
  $getQ .= "and Rev_No='".$_POST['RevNo']."'";  
}
if($_POST['date'] !="")
{
}
if($_POST['SubCat'] !="")
{
  $getQ .= "and Sub_Category='".$_POST['SubCat']."'";
}
if($_POST['Complex'] !="")
{
  $getQ .= "and Complexity='".$_POST['Complex']."'";
}
if($_POST['Lead'] !="")
{
  $getQ .= "and Lead_Time='".$_POST['Lead']."'";
}/*
if($_POST['TagD'] !="")
{
  $getQ .= "and Tag_Description='".$_POST['TagD']."'";
}
if($_POST['TagN'] !="")
{
  $getQ .= "and Tag_Notes='".$_POST['TagN']."'";
}
if($_POST['PriceN'] !="")
{
  $getQ .= "and Price_Notes='".$_POST['PriceN']."'";
}*/
if($_POST['TagMem'] !="")
{
  //pull tag member id from emp table
  $empQ = "SELECT Emp_Id from EMP where name='".$_POST['TagMem']."'";
  $empR = $dbConn->Query($empQ);
  $Erow = $empR->fetch_row();
  
  $getQ .= "and Tag_Member='".$Erow[0]."'";
}

$result = $dbConn->Query($getQ);

$row = $result->fetch_assoc();

?>

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

  <div id="outerDiv">
  <table>
    <tr>
      <th>Tag No</th>
      <th>Rev No</th>
      <th>Tag Desc</th>
      <th>Tag Notes</th>
      <th>Price Notes</th>
      <th>Tag Member</th>
   </tr>
  <?php
  while ($row)
  {
  echo  "<tr>";
  echo  "<td><a href=\"ViewOne.php?Tagno=".$row['Tag_No']."&revision=".$row['Rev_No']."&lastFlag=".$Srev."\">".$row['Tag_No']."</a></td>";
  echo  "<td>".$row['Rev_No']."</td>";
  echo  "<td>".$row['Tag_Description']."</td>";
  echo  "<td>".$row['Tag_Notes']."</td>";
  echo  "<td>".$row['Price_Notes']."</td>";
  $empQ = "SELECT name from EMP where Emp_Id ='".$row['Tag_Member']."'";
  $empR = $dbConn->Query($empQ);
  $Erow = $empR->fetch_row();
  echo  "<td>";
  echo $Erow[0];
  echo "</td></tr>";
  $row = mysqli_fetch_assoc($result);

  }
  ?>
  </table>
  </div> 




</html>

