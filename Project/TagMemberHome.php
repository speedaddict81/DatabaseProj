<?php
//$sid = htmlspecialchars(SID);
$tagHome = <<< EOA
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
 <form action="">
  <div>
    <h2>Tag Member Home</h2>
    <a href="viewOne.php">View TAGS</a><br><br>
    <a href="insert.php">Insert New Tag</a><br><br>   
    <a href="search.php">Search Tags</a><br><br>   
    <a href="index.php">Log Out</a>
    
  </div>
 </form>


</html>
EOA;
echo $tagHome;



?>
