<?php

$MaxQ = "SELECT MAX(Tag_No) as Tno from TAG where last_rev = 1";
$maxRow = $dbConn->Query($MaxQ)->fetch_assoc();
$_SESSION['MaxTag'] = $maxRow['Tno'];

$MinQ = "SELECT MIN(Tag_No) as Tnum from TAG where last_rev = 1";
$minRow = $dbConn->Query($MinQ)->fetch_assoc();
$_SESSION['MinTag'] = $minRow['Tnum'];

unset($maxRow);
unset($minRow);
?>
