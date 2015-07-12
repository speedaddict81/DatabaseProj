<?php
include "sql.php";
session_start();
if (isset($_POST['Uupdate']))
{
  //Update a user
  $UupdateQ = "UPDATE EMP SET Name ='".$_POST['nameAdd']."', Emp_Group ='".$_POST['GroupA']."' WHERE Username ='".$_POST['unAdd']."'";
  $dbConn->Query($UupdateQ);
  echo "User ".$_POST['unAdd']." updated";

}

if (isset($_POST['Uadd']))
{
  //Add new user
$insertQ = "INSERT INTO EMP (Username, Name, Emp_Group) VALUES ('".$_POST['unAdd']."','".$_POST['nameAdd']."','".$_POST['GroupA']."')";
$dbConn->Query($insertQ);
echo "User Added";
}

if (isset($_POST['Cupdate']))
{
  $CupQ = "UPDATE `countries` SET `C_Mult` = '".(float)$_POST['USA']."' WHERE `Country` = 'USA';";
  $dbConn->Query($CupQ);
  $CupQ = "UPDATE `countries` SET `C_Mult` = '".(float)$_POST['Mexico']."' WHERE `Country` = 'Mexico';";
  $dbConn->Query($CupQ);
  $CupQ = "UPDATE `countries` SET `C_Mult` = '".(float)$_POST['Canada']."' WHERE `Country` = 'Canada';";

  if($dbConn->Query($CupQ)) echo "Country info updated";

}

if (isset($_POST['compB']))
{
  //Add new user
  $CompUpQ = "INSERT INTO complex (complexity) VALUES('".$_POST['comp']."')";
  $dbConn->Query($CompUpQ);
  echo "Complexity ".$_POST['comp']." added";
}


$userQ = "SELECT Username, Name, Emp_Group from EMP";
$Uresult = $dbConn->Query($userQ);

?>
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

    <h2>Admin Updates</h2>
    <a href="AdminHome.php">Home</a> <br>
  <div>User Updates:<br>
    <form id="form2" action="" method="post">
      <table>
        <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Group</th>
        </tr>
        <?php
          $groupO = <<< EOL
          <td><select name="GroupU">
          <option>User</option>
          <option>OE</option>
          <option>TagMember</option>
          <option>Admin</option>
          <option selected>
EOL;
          
          while ($row = $Uresult->fetch_assoc()) 
          {
            echo "<tr>";
            echo "<td><input type=\"text\" value=\"".$row['Username']."\" readonly></td>";
            echo "<td><input type=\"text\" value=\"".$row['Name']."\" readonly></td>";
            echo "<td><input type=\"text\" value=\"".$row['Emp_Group']."\" readonly></td>";
            echo "</tr>";
          }
          $Uresult->free();        
        ?>
        <tr>
        <td><input type="text" name="unAdd"></td>
        <td><input type="text" name="nameAdd"></td>
        <td><select name="GroupA">
          <option>User</option>
          <option>OE</option>
          <option>TagMember</option>
          <option>Admin</option>
        </select></td>
        </tr>
      </table>
    <input type="submit" name="Uupdate" value="Update Users" onclick="return confirm('This will update the database, continue?');">
    <input type="submit" name="Uadd" value="Add User" onclick="return confirm('This will update the database, continue?');">
    </form>
  </div>

  <div>Pricing Updates:<br>
    <form id="form2" action="" method="post">    
    <table>
      <tr>
      <th>Country</th>
      <th>Multiplier</th>
      </tr>
      <?php
      $CountryQ = "SELECT * from COUNTRIES";
      $Cresult = $dbConn->Query($CountryQ);
      while($row = $Cresult->fetch_assoc())
      {
            echo "<tr>";
            echo "<td>".$row['Country']."</td>";
            if ($row['Country'] == 'USA')
            {
            echo "<td><input type=\"text\" name=\"USA\" value=\"".$row['C_Mult']."\"></td>";
            }
            if ($row['Country'] == 'Mexico')
            {
            echo "<td><input type=\"text\" name=\"Mexico\" value=\"".$row['C_Mult']."\"></td>";
            }
            if ($row['Country'] == 'Canada')
            {
            echo "<td><input type=\"text\" name=\"Canada\" value=\"".$row['C_Mult']."\"></td>";
            }
            echo "</tr>";     
      }
      $Cresult->free();
      ?>
      
    </table>
    <input type="submit" name="Cupdate" value="Update Country Info" onclick="return confirm('This will update the database, continue?');">
    </form>
  </div>
  <div>Complexity:<br>
  <form action="" method="post">
  <?php
    $CompQ = "SELECT Complexity from COMPLEX";
    $compResult = $dbConn->Query($CompQ);
    $compRow = $compResult->fetch_row();
    while($compRow)
    {
      echo $compRow[0]."<br>";
      $compRow = $compResult->fetch_row();
    }
  ?>
  <input type="text" maxlength="1" name="comp">
  <input type="submit" value="Add Complexity" name="compB" onclick="return confirm('This will update the database, continue?');">
  </form>
  
  </div>



</html>
<?php
 $dbConn->close();
?>

