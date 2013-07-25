<?php
require_once('include/include.php');
require_once('include/parameters.php');
//require_once('include/schedule_functions.php');
require_once('include/class.employee.php');
$objemployee = new employee();
$user_id =  $_SESSION['USERID'];
$emp_power = emp_authority($user_id);
?>
<html>
 <head><title><?php print $company_name;?></title>
<!--media="print"-->
<!--Verdana, Verdana, Geneva, sans-serif-->
<style type="text/css" media="print">
	td,th {
	color: #000000;
	background-color: #FFFFFF;
	font-family: Verdana,"Verdana", Geneva, sans-serif;
	font-size: 17px;
 	color: black; 
 	border-width: 0; 
 	border: 1px solid #9E9E9E; 
	} 
	input[type="button"] { 
 	display: none; 
	}
</style>
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

</head>

<div align="center" border="0">
    <table border="1" width="100px" align="center" class="main_content_table_test" >
      <tr align="center"><th colspan="6"> <?php print $company_name;?> Employee List</th></tr>
	<tr align="center"><th colspan="6"><?php  echo $_GET['deptname']; ?></th></tr>
      <tr align="center" valign="middle" style="background-color:#CDCDCD;" >
        <th  nowrap class="link_txt">Sl No</th>
        <th class="link_txt">Name</th>
	<?php if($_GET['department']<=0 || $_GET['department'] =='') echo "<th class=\"link_txt\">Department</th>"; ?>
        <th class="link_txt">Contactno</th>
	<th class="link_txt">Email</th>
	<th class="link_txt">Address</th>
      </tr>
	<?php $depname = $objemployee->employeenormallist($_GET['department']);?>
	<tr><td colspan="6" align="center"><input type="button" title="Print" class="fillout" value="Print this page" onclick="window.print(); return false" /></td></tr>
    </table>
</div>
</html>