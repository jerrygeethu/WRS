<?php


//require_once('include/include.php');
$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
print $today;
/*
require_once('include/include.php');
$_SESSION['SEL_LINK']="VEMP";
require_once('include/parameters.php');
$var_test="2009-10-05 02:45:58";
	$entry=explode(" ",$var_test);
			$date_format=ymdToDmy($entry[0]);
					 print "<br/>";
			$time_format=from24to12($entry[1]);
	print 	$time_entered=" Entered at: ".$date_format." ".$time_format." Hrs ";
*/


?>
