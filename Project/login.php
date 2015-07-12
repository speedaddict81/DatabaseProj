<?php
include "sql.php";
session_start();
//$dbConn;
$_SESSION['Ctag'] = 6000;
//echo "it must have worked \n";
$username = $_POST['username'];
$password = $_POST['password'];
//echo "{$username}:{$password}\n";
$_SESSION['username'] = $username;
if(isset($_COOKIE['username']) and $_COOKIE['username'] == $username)
{
  $userExistsSQL = "SELECT * from EMP where username = '".$username."'"; 
}
else
{
$userExistsSQL = <<< EOQ
SELECT * from EMP where username = '$username' and password = '$password';
EOQ;
}
$result = mysqli_query($dbConn, $userExistsSQL);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$row)
    {
     echo "Incorrect name/password entered use your browser's back button and reenter info"; 
    }
    /*else if ($row["Emp_Group"] == 'TagMember')
    {
    include $_SESSION['group']."Home.php";//go to tag page
    }
    else if ($row["Emp_Group"] == 'OE')
    {
    //include $_SESSION['group']."Home.php";
    }
    else if ($row["Emp_Group"] == 'User')
    {
    //include $_SESSION['group']."Home.php";
    }*/
    else
    {
      //log login and set some Session variables
      
      $_SESSION['empID']=$row['Emp_Id'];
      $_SESSION['group']=$row["Emp_Group"];
      $logQ = "INSERT INTO SECURITY (Emp_Username, Ip_Address) VALUES ('".$_SESSION['username']."', '".$_SERVER['REMOTE_ADDR']."')";
      $dbConn->Query($logQ);
      
      //set login cookie to expire in 90 days
      
      setcookie("username", $username, time() + (86400 * 90), "/");    
      include $_SESSION['group']."Home.php";    
    }

mysqli_free_result($result);
$dbConn->close();
?>
