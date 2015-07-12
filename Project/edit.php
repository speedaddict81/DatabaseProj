<?php
include "sql.php";
session_start();
include_once "session.php";
if (isset($_POST['save']))
{
  //do error checking/recovery/redisplay form with POST values?
  if (!(isset($_POST['prod'])))
  {
    echo "Edit Failed, no product type selected";
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
  $TD = $dbConn->real_escape_string($_POST['TagD']);
  $TN = $dbConn->real_escape_string($_POST['TagN']);
  $PN = $dbConn->real_escape_string($_POST['PriceN']);
  $insertQ = "INSERT INTO TAG (Tag_No, Rev_No, Sub_Category, Complexity, Lead_Time, Tag_Description, Tag_Notes, Price_Notes,".
              "Tag_Member, Labor_Hours, Engineering_Hours, Material_Cost, Labor_Cost, Engineering_Cost, Install_Cost, PriceExp) ".
              "VALUES ('".$_POST['TagNo']."', '".$_POST['revision']."', '".$_POST['SubCat']."', '".$_POST['Complex']."', '".$_POST['Lead']."', '".$TD."', '".$TN.
              "', '".$PN."', '".$_SESSION['empID']."', '".$_POST['Lhrs']."', '".$_POST['Ehrs']."', ".(float)$_POST['Mcost'].", "
              .$LabCost.", ".$EngCost.", ".$InstCost.", '".$pdate."')";
  if ($dbConn->Query($insertQ))
  {
  //update Last_Rev flags
  $RevQ = "UPDATE TAG SET Last_Rev = 0 where Tag_No = '".$_POST['TagNo']."' and Rev_No <'".$_POST['revision']."'";
  $dbConn->Query($RevQ);
  $_SESSION['Ctag'] = $_POST['TagNo'];
  include "session.php";//reset min/max tag no
  
  
  //update the Product_type table name=prod
  $prods = $_POST['prod'];
  $N = count($prods);
  for($i=0; $i < $N; $i++)
    {
      $prodQ = "INSERT INTO product_option (P_Type, Tag_Num, Rev_Num) VALUES ('".$prods[$i]."', ".$_SESSION['Ctag'].", '".$_POST['revision']."')";
      $dbConn->Query($prodQ);
    }
  //update Attachments table
  if ($_POST['keepatt'] =="No")
  {}
  else
  {
    //get old attachment ids
    $getA = "SELECT Att_Num, Tag_Num from ATTACHMENTS where Tag_Num ='".$_POST['TagNo']."' and Rev_Num ='".$_POST['keepatt']."'";
    $Ares = $dbConn->Query($getA);
    $Arow = $Ares->fetch_row();
    while($Arow)
    {
      $insA = "INSERT INTO ATTACHMENTS (Att_Num, Tag_Num, Rev_Num) VALUES ('".$Arow[0]."', '".$Arow[1]."', '".$_POST['revision']."')";
      $dbConn->Query($insA);
      $Arow = $Ares->fetch_row();
    }
  }
  
  //echo "New Tag #".$_SESSION['Ctag']." inserted into DB";
  header('Location: viewOne.php');
  }
  echo "Tag insert failed";
  }
}

$tagQ = "SELECT * from TAG WHERE Tag_No = ".$_POST['TagNo']." and Rev_No = ".$_POST['revision'];
$tagRes = $dbConn->Query($tagQ);
$tagRow = $tagRes->fetch_assoc();


?>

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<form action="" method="post">
  <div>
  <div id="first">
    Tag Number
    <input type="text" name="TagNo" value="<?php echo $tagRow['Tag_No'];?>" maxlength="4" size="10" readonly>    
  </div>
  
  <div id="second">
    Revision<br>
    <input type="text" name="revision" value="<?php   $MaxRevQ = "SELECT MAX(Rev_No) from TAG where Tag_No = '".$_POST['TagNo']."'";
                                                       $MRres = $dbConn->Query($MaxRevQ);
                                                       $MRrow = $MRres->fetch_row();
                                                       echo $MRrow[0]+1;?>" maxlength="2" size="10" readonly>
  </div>
  
  <div id="third">
    Date<br>
    <input type="text"  name="date" value="<?php echo date('Y-m-d');?>" size="8" readonly>
  </div>

  
  <div id="fourth">
    Sub-Category
    <select name="SubCat">
      <option><?php echo $tagRow['Sub_Category'];?></option>
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
      <option><?php echo $tagRow['Complexity'];?></option>
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
    <input type="text" name="Lead" value="<?php echo $tagRow['Lead_Time'];?>" maxlength="3" size="10">    
  </div>

<div>
  <div id="firstlarge">
    Tag Description<br>
    <textarea name="TagD" rows="3" cols="50"><?php echo $tagRow['Tag_Description'];?></textarea>    
  </div>
</div>

<div>
  <div id="firstlarge">
    Tag Notes<br>
    <textarea name="TagN" rows="3" cols="50"><?php echo $tagRow['Tag_Notes'];?></textarea>    
  </div>
</div>
<div>
  <div id="firstlarge">
    Price Notes<br>
    <textarea name="PriceN" rows="3" cols="50"><?php echo $tagRow['Price_Notes'];?></textarea>    
  </div>
</div>

<div>
  <div id="firstlarge">
  <table>
<tr><td>Material Cost</td><td> <input name="Mcost" value="<?php echo $tagRow['Material_Cost'];?>"></td></tr>
<tr><td>Labor (hrs)</td><td> <input name="Lhrs" value="<?php echo $tagRow['Labor_Hours'];?>"></td></tr>
<tr><td>Engineering (hrs)</td><td> <input name="Ehrs" value="<?php echo $tagRow['Engineering_Hours'];?>"></td></tr>
<tr><td>Price Expires (mo)</td><td> <input name="Pexp" value="3"></td></tr>

  </table>
</div>


</div>
  <div id="firstlarge">
    Product Types (select at least one)<br>
    <table>

      <?php
        $ProdQ = "SELECT Prod_Type from PRODUCTS";
        $ProdRes = $dbConn->Query($ProdQ);
        $ProdRow = $ProdRes->fetch_row();
        while ($ProdRow)
        {
          echo "<input type=\"checkbox\" name=\"prod[]\" value=\"";
          echo $ProdRow[0];
          echo "\">";
          echo $ProdRow[0];
          echo "<br>";
          $ProdRow = $ProdRes->fetch_row();
        }
      
      
      ?>


    </table>    
  </div>
</div>
<div>
  <p><input type="submit" value="Home" formaction="<?php echo $_SESSION['group'];?>Home.php">
  <input type="submit" name="save" value="Save"  onclick="return confirm('This will update the database, continue?');">
  <br>Keep Attachments?<br><input type="radio" name="keepatt" value="<?php echo $_POST['revision'];?>" checked>Yes<br>
  <input type="radio" name="keepatt" value="No">No</p>
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
$dbConn->close();

?>

