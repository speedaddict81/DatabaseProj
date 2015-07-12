<?php
//$sid = htmlspecialchars(SID);
include "sql.php";

?>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
 <form action="AdminHome.php">
  <div>
    <Table>
    <tr>
      <th>USERNAME</th>
      <th>IP ADDRESS</th>
      <th>TIME</th>
    </tr>
    <?phP
      $lQ = "SELECT * FROM SECURITY";
      $lRes=$dbConn->Query($lQ);
      $lRow=$lRes->fetch_assoc();
      while($lRow)
      {
        echo "<tr><td>";
        echo $lRow['Emp_Username'];
        echo "</td><td>";
        echo $lRow['Ip_Address'];
        echo "</td><td>";
        echo date('Y-m-d H:i:s', strtotime($lRow['Login_DateTime']));
        echo "</td></tr>"; 
        $lRow=$lRes->fetch_assoc();
      }
    
    ?>
    
    <input type="submit" value="Home">
  </div>
 </form>


</html>


<?php

?>
