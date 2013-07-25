<?php 
require_once('include/include.php');
$userid = $_SESSION['USERID']; 
require_once('include/workflow_functions.php');  
	
	$data=Workflow('19');	
	$arrFiles=explode(",",$data['file1']);	
	//$arrFiles1=isset($arrFiles)?$arrFiles:array();
	//$arrFiles1=array("blue","green");
	printarray($arrFiles);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
</head>

<body>

<?php
 $fileQuery="select file1,file2,file3 from fileshare where uploadby='".$userid."' and status='active'";
$fileResult=$GLOBALS['db']->query($fileQuery);
while($fileRow=$fileResult->fetch_assoc())
{
	echo $fileRow['file1']."<br/>";
	printarray($arrFiles);
	echo "<br/>";
	if(in_array($fileRow['file1'],$arrFiles)) { echo "hii"; } else { echo "no"; }						
}			  														
?>
</body>
</html>
