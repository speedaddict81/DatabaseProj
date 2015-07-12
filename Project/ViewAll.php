<?php
include "sql.php";
//include_once "session.php";
session_start();

$prevTag = $_SESSION['tag'];
//find first tag for initial view item
$getAllSql = "SELECT * from TAG where Last_Rev = 1";
$result = mysqli_query($dbConn, $getAllSql);
$row = mysqli_fetch_assoc($result);

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
  </tr>
  <tr>
  <?php echo "<td>".$row['Tag_No']."</td>";?>
  <td>to ViewOne.php where $_SESSION['tag']</td>
  <td> is set to tag no</td>
  </tr>
  </table>
  </div> 




</html>

