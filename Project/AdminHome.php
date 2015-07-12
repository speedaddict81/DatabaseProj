<?php
//$sid = htmlspecialchars(SID);
$adminHome = <<< EOA
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
 <form action="">
  <div>
    <h2>Admin Home</h2>
    <table>
    <tr><td><a href="viewOne.php">View TAGS</a><br><br></td>
    <td><a href="adminUpdate.php">Admin Update Tasks</a><br><br></td></tr>
    <tr><td><a href="insert.php">Insert New Tag</a><br><br></td> 
    <td><a href="log.php">View Log</a><br><br></td></tr>    
    <tr><td><a href="search.php">Search Tags</a><br><br></td>
    <td><a href="index.php">Log Out</a><br><br></td></tr>
    
  </div>
 </form>


</html>
EOA;
echo $adminHome;



?>
