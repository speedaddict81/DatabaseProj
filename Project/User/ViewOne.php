<?php
include "sql.php";
session_start();
include_once "session.php";
if (isset($_POST['next']))
{
  if ($_SESSION['Ctag']<$_SESSION['MaxTag'])
  {
  $_SESION['Ptag'] = $_SESSION['Ctag'];
  $_SESSION['Ctag'] ++;
  }
  else
  $_SESSION['Ctag'] = 6000;
}
if (isset($_GET['Tagno']))
{
  //we came here from a search so we need to return a specific tag/rev
  $_SESSION['Ctag'] = $_GET['Tagno'];
  $tagQ = "SELECT * from TAG where Rev_No = '".$_GET['revision']."' and Tag_No =".$_SESSION['Ctag'];
}
else
{
  //we came here from the homepage or by clicking next tag
  $getOneSql = "SELECT MIN(Tag_No) AS T_No from TAG where Last_Rev = 1 and Tag_No >=".$_SESSION['Ctag'];
  $result = mysqli_query($dbConn, $getOneSql);
  $row = mysqli_fetch_assoc($result);
  $tag = $row['T_No'];
  $_SESSION['Ctag']=$tag;
  $tagQ = "SELECT * from TAG WHERE Tag_No = $tag and Last_Rev = 1";
}
//find first tag for initial view item
//if last tag is reached will redisplay last tag data

$tagRes = $dbConn->Query($tagQ);
$tagRow = $tagRes->fetch_assoc();


?>

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="http://localhost:8080/4560project/style.css">
</head>
<form action="ViewOne.php" method="post" enctype="multipart/form-data" >
  <div>
  <div id="first">
    Tag Number
    <input type="text" name="TagNo" value="<?php echo $tagRow['Tag_No'];?>" maxlength="4" size="10" readonly>    
  </div>
  
  <div id="second">
    Revision<br>
    <input type="text" name="revision" value="<?php echo $tagRow['Rev_No'];?>" maxlength="2" size="10" readonly>
  </div>
  
  <div id="third">
    Date<br>
    <input type="text"  name="date" value="<?php echo date('Y-m-d', strtotime($tagRow['Revised_Date']));?>" size="9">
  </div>

  
  <div id="fourth">
    Sub-Cat<br>
    <input type="text"  name="SubCat" value="<?php echo $tagRow['Sub_Category'];?>" size="15" readonly>
  </div>
   
  <div id="fifth">
    Complexity<br>
    <input type="text"  name="Complex" value="<?php echo $tagRow['Complexity'];?>" size="8" readlonly>
  </div>
  
  <div id="sixth">
    Lead Time
    <input type="text" name="Lead" value="<?php echo $tagRow['Lead_Time'];?>" maxlength="3" size="10" readonly>    
  </div>

<div>
  <div id="firstlarge">
    Tag Description<br>
    <textarea name="Tag Description" rows="3" cols="50" readonly><?php echo $tagRow['Tag_Description'];?></textarea>    
  </div>
</div>

<div>
  <div id="firstlarge">
    Tag Notes<br>
    <textarea name="Tag Notes" rows="3" cols="50" readonly><?php echo $tagRow['Tag_Notes'];?></textarea>    
  </div>
</div>
<div>
  <div id="firstlarge">
    Price Notes<br>
    <textarea name="Price Notes" rows="3" cols="50" readonly><?php echo $tagRow['Price_Notes'];?></textarea>    
  </div>
</div>

<div>
  <div id="firstlarge">
  <table>
<tr><td>Tag Member</td><td> <input name="Tmem" value="<?php
      $empQ = "SELECT name from EMP where Emp_Id ='".$tagRow['Tag_Member']."'";
      $empR = $dbConn->Query($empQ);
      $Erow = $empR->fetch_row();
      echo $Erow[0];?>"></td></tr>

  </table>
</div>


</div>
  <div id="firstlarge">
    Pricing<br>
    <table>
      <tr>
              <th>Product Type</th>
              <th>USA</th>
              <th>Mexico</th>
              <th>Canada</th>
      </tr>
      <?php
        $ProdQ = "SELECT P_Type from PRODUCT_OPTION where Tag_Num = '".$tagRow['Tag_No']."' and Rev_Num = '".$tagRow['Rev_No']."'";
        $ProdRes = $dbConn->Query($ProdQ);
        $ProdRow = $ProdRes->fetch_row();
        while ($ProdRow)
        {
          echo "<tr>";
          echo "<td>";
          echo $ProdRow[0];
          echo "</td>";
          echo "<td>See Dealer</td>";
          echo "<td>See Dealer</td>";
          echo "<td>See Dealer</td>";
          echo "</tr>";
          $ProdRow = $ProdRes->fetch_row();
        }
      
      
      ?>


    </table>    
  </div>
</div>
<div>
  <p><input type="submit" value="Home" formaction="http://localhost:8080/4560project/<?php echo $_SESSION['group'];?>Home.php">
  <button type="button" onclick="javascript:window.print()">Print</button>
  <input type="submit" name="next" value="Next Tag"></p>
</div>

</form>



</html>






<?php

?>

