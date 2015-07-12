<?php
include "sql.php";
//include_once "session.php";
session_start();
include_once "session.php";

//$prevTag = $_SESSION['tag'];
//find first tag for initial view item
//if last tag is reached will redisplay last tag data
//$getOneSql = "SELECT MIN(Tag_No) AS T_No from TAG where Last_Rev = 1 and Tag_No >=".$_SESSION['Ctag'];
//$result = mysqli_query($dbConn, $getOneSql);
//$row = mysqli_fetch_assoc($result);
//$tag = $row['T_No'];
//$_SESSION['Ctag']=$tag;
if (isset($_POST['insert']))
{
  //do error checking/recovery/redisplay form with POST values?
  if (!(isset($_POST['prod'])))
  {
    echo "No product type selected";
  }
  //or update database
  else
  {
  $costQ = "SELECT * from COSTS";
  $costRes = $dbConn->Query($costQ);
  $CostRow = $costRes->fetch_assoc();
  while($CostRow)
  {
  if ($CostRow['Cost_Type'] == "Engineering") $EngCost = $CostRow['Cost'];
  if ($CostRow['Cost_Type'] == "Labor") $LabCost = $CostRow['Cost'];
  $CostRow = $costRes->fetch_assoc();
  }
  $EngCost = (float)$_POST['Ehrs'] * $EngCost;
  $LabCost = (float)$_POST['Lhrs'] * $LabCost;
  $InstCost = (float)$_POST['Mcost'] + $EngCost + $LabCost;
  $myTime = time();
  $myTime = $myTime + 30 * 24 * 60 * 60 * $_POST['Pexp'];
  echo date('Y-m-d', $myTime);
  $pdate = date('Y-m-d', $myTime);
  $newMax = $_SESSION['MaxTag']+1;
  $insertQ = "INSERT INTO TAG (Tag_No, Sub_Category, Complexity, Lead_Time, Tag_Description, Tag_Notes, Price_Notes,".
              "Tag_Member, Labor_Hours, Engineering_Hours, Material_Cost, Labor_Cost, Engineering_Cost, Install_Cost, PriceExp) ".
              "VALUES ('".$newMax."', '".$_POST['SubCat']."', '".$_POST['Complex']."', '".$_POST['Lead']."', '".$_POST['TagD']."', '".$_POST['TagN'].
              "', '".$_POST['PriceN']."', '".$_SESSION['empID']."', '".$_POST['Lhrs']."', '".$_POST['Ehrs']."', ".(float)$_POST['Mcost'].", "
              .$LabCost.", ".$EngCost.", ".$InstCost.", '".$pdate."')";
  if ($dbConn->Query($insertQ))
  {
  //update the Product_type table name=prod
  $_SESSION['Ctag'] = $newMax;
  include "session.php";//reset min/max tag no
  $prods = $_POST['prod'];
  $N = count($prods);
  for($i=0; $i < $N; $i++)
    {
      $prodQ = "INSERT INTO product_option (P_Type, Tag_Num, Rev_Num) VALUES ('".$prods[$i]."', ".$_SESSION['Ctag'].", 0)";
      $dbConn->Query($prodQ);
    }
  //echo "New Tag #".$_SESSION['Ctag']." inserted into DB";
  header('Location: viewOne.php');
  }
  echo "Tag insert failed";
  }
}

?>

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<form action="" method="post" onsubmit="return confirm('This will update the database, continue?');">
  <div>
  <div id="first">
    Tag Number
    <input type="text" value="Auto" maxlength="4" size="10" readonly>    
  </div>
  
  <div id="second">
    Revision<br>
    <input type="text" value="0" maxlength="2" size="10" readonly>
  </div>
  
  <div id="third">
    Date<br>
    <input type="text"  name="date" value="Auto" size="10">
  </div>

  
  <div id="fourth">
    Sub-Category
    <select name="SubCat">
      <?php
        $SubQ = "SELECT Cat_Name as Cat FROM SubCat";
        $SubRes = $dbConn->Query($SubQ);
        $SubRow = $SubRes->fetch_row();
        while($SubRow)
        {
          echo "<option>".$SubRow[0]."</option>";
          $SubRow = $SubRes->fetch_row();
        }
        
      ?>
    </select>    
  </div>
   
  <div id="fifth">
    Complexity<br>
    <select name="Complex">
      <?php
        $CompQ = "SELECT Complexity as Comp FROM Complex";
        $CompRes = $dbConn->Query($CompQ);
        $CompRow = $CompRes->fetch_row();
        while($CompRow)
        {
          echo "<option>".$CompRow[0]."</option>";
          $CompRow = $CompRes->fetch_row();
        }
        
      ?>    </select>
  </div>
  
  <div id="sixth">
    Lead Time
    <input type="text" name="Lead" value="0" maxlength="3" size="10">    
  </div>

<div>
  <div id="firstlarge">
    Tag Description<br>
    <textarea name="TagD" rows="3" cols="50"></textarea>    
  </div>
</div>

<div>
  <div id="firstlarge">
    Tag Notes<br>
    <textarea name="TagN" rows="3" cols="50"></textarea>    
  </div>
</div>
<div>
  <div id="firstlarge">
    Price Notes<br>
    <textarea name="PriceN" rows="3" cols="50"></textarea>    
  </div>
</div>
<div>
  <div id="firstlarge">
  <table>
<tr><td>Material Cost</td><td> <input name="Mcost" value=""></td></tr>
<tr><td>Labor Hours</td><td> <input name="Lhrs" value="1"></td></tr>
<tr><td>Engineering Hours</td><td> <input name="Ehrs" value="1"></td></tr>
<tr><td>Price Expires</td><td> <input name="Pexp" value="3"></td></tr>

  </table>
</div>
<div>
  <div id="firstlarge">
    Product Types (select at least one)<br>
      <?php
        $ProdQ = "SELECT Prod_Type as Prod FROM PRODUCTS";
        $ProdRes = $dbConn->Query($ProdQ);
        $ProdRow = $ProdRes->fetch_row();
        while($ProdRow)
        {
          echo "<input type=\"checkbox\" name=\"prod[]\" value=\"".$ProdRow[0]."\">".$ProdRow[0]."<br>";
          $ProdRow = $ProdRes->fetch_row();
        }
        
      ?>  
  </div>
</div>
<div>
  <p><input type="submit" name="insert" value="Insert Tag"></p>
</div>

<div id="Tabs">
  <ul>
  <li id="li_tab1" onclick="tab('tab1')"><a>Quote</a></li>
  <li id="li_tab2" onclick="tab('tab2')"><a>FO</a></li>
  </ul>
  <div id="Content_Area">
    <div id="tab1">
      <p>Open Quotes</p>
    </div>

    <div id="tab2" style="display: none;">
      <p>Open FOs</p>
    </div>
  </div> 
</div> 
</form>



</html>

<script type="text/javascript">
function tab(tab) {
document.getElementById('tab1').style.display = 'none';
document.getElementById('tab2').style.display = 'none';
document.getElementById('li_tab1').setAttribute("class", "");
document.getElementById('li_tab2').setAttribute("class", "");
document.getElementById(tab).style.display = 'block';
document.getElementById('li_'+tab).setAttribute("class", "active");
}
</script>
<?php
//EOA;


//add code here to release query results and close connection

$dbConn->close();

?>

