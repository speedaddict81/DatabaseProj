<?php
include "sql.php";
//include_once "session.php";
session_start();

?>

<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="http://localhost:8080/4560project/style.css">
</head>
<form action="result.php" method="post">
  <div>
  <div id="first">
    Tag Number
    <input type="text" name="TagNo" value="" maxlength="4" size="10">    
  </div>
  
  <div id="second">
    Revision<br>
    <input type="text" name="RevNo" value="" maxlength="2" size="10">
  </div>
  
  <div id="third">
    Date<br>
    <input type="text"  name="date" value="" size="10">
  </div>

  
  <div id="fourth">
    Sub-Category
    <select name="SubCat">
      <option></option>
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
      <option></option>
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
    <input type="text" name="Lead" value="" maxlength="3" size="10">    
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
Tag Member<br>
<select name="TagMem">
<option></option>
  <?php
  $empQ = "SELECT name from EMP";
  $empR = $dbConn->Query($empQ);
  $Erow = $empR->fetch_row();
  while($Erow)
  {
  echo "<option>".$Erow[0]."</option>";
  $Erow = $empR->fetch_row();  
  }
  ?>

</select>
</div>
  <div id="firstlarge">
    <br>Product Types<br>
      <?php
        $ProdQ = "SELECT Prod_Type as Prod FROM PRODUCTS";
        $ProdRes = $dbConn->Query($ProdQ);
        $ProdRow = $ProdRes->fetch_row();
        while($ProdRow)
        {
          echo "<input type=\"checkbox\" name=\"prod\" value=\"".$ProdRow[0]."\">".$ProdRow[0]."<br>";
          $ProdRow = $ProdRes->fetch_row();
        }
        
      ?>  
  </div>
</div>
<div>
  <p><input type="submit" name="search" value="Search Tags">
  <input type="checkbox" name="old">Serch obsolete tags</p>
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

