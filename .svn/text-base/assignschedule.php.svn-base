<?php
require_once('include/include.php');
require_once('include/schedule_functions.php');
if(isset($_GET['empid'])){
 $emp_id=$_GET['empid'];
}
$supervisorid = $_SESSION['USERID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..:: Prime Move ::..</title>
<link rel="shortcut icon" href="./images/earth.gif" >
<style type="text/css">
<!--
body {
	margin-left: auto;
	margin-top: auto;
	margin-right: auto;
	margin-bottom: auto;
}
-->
</style>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/viewreport.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>


<script language="JavaScript">
// To validate inputs 
		function checkall() {
		
		}

</script>



</head>
<center>
<body>

<div id="main_div">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" " style="border-left:solid 1px #09146c;border-right:solid 1px #09146c;border-top:solid 1px #09146c;">
    <tr>
      <td width="219" height="102" align="center" valign="middle" style="border-bottom:solid 1px #0092dd;"><img src="images/logo.jpg" alt="" width="194" height="88" /></td>
      <td width="764" align="right" valign="top" class="link_txt"  style="border-bottom:solid 1px #0092dd;">Home | Sign Out </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #09146c;border-right:solid 1px #09146c;border-bottom:solid 1px #09146c;">
  <tr>
    <td width="152" rowspan="3" align="left" valign="top" background="images/tbl_bg1.jpg">
   
   <table width="152" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td height="60" align="center" valign="middle" background="images/tbl_bg1.jpg"  style="border-bottom:solid 1px #000000;">
       <span class="head_txt1">Welcome</span><br />
<span class="s_txt">
<?php 
print $_SESSION['NAME']; 
?></span></td>
</tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php 
      $menu=menu();
      print $menu;
      ?>
      </table>
    </td>
    <td width="659" height="500" align="center" valign="top">
    
    <table border="1" width="100%" cellspacing="1" cellpadding="3" id="list_employees">
        <tr>
            <td>
            Select The Schedule :
            </td>
             <td>
           <?php
           $sch=get_schedule('');
           print $sch;
           ?>
            </td>
     	</tr>
        <tr>
            <td>
            Select The Category :
            </td>
             <td>
           <?php
           $act=get_activity('activity');
           print $act;
           ?>
            </td>
     	</tr>
     	<tr>
            <td>
            Enter Details of the work :
            </td>
             <td>
           <textarea style='width:250px;height:150px;'></textarea>
            </td>
     	</tr>
     		<tr><td>
     <label for="validfrom" >Valid from : </label></td>
				<td >
				<input type="text"  id="schfromdate"  name="schfromdate" size="30px" maxlength="12" readonly="true"
				 value="Enter date" style="width: 80px;" /> 
				 <img onclick="displayDatePicker('schfromdate');" value="select" src="images/cal.gif"/>
				 </td>
			</tr>
			<tr>
				<td ><label for="validto" >Valid to : </label></td>
				<td >
				<input type="text"  id="schtodate"  name="schtodate" size="30px" maxlength="10"  readonly="true"
				 value="Enter date" style="width: 80px;" /> 
				 <img onclick="displayDatePicker('schtodate');" value="select" src="images/cal.gif"/>
     
     </td></tr>
      <tr>
            <td>
            Status :
            </td>
             <td>
             <select id="schstatus" name="schstatus" title='Schedule Status'  style='width:150px;' >
           <?php
           listschstatus('');
           ?>
           </select>
            </td>
     	</tr>
     	<tr>
            <td>
            Enter Schedule Comment :
            </td>
             <td>
           <textarea style='width:250px;height:100px;'></textarea>
            </td>
     	</tr>
     </table>
    
    
    </td>
    <td width="159" align="right" valign="top"  style="border-left:solid 1px #0092dd;"><table width="158" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="7" height="206" align="left" valign="middle" background="images/news_tbl1.jpg">
        </td>
        <td width="151" align="center" valign="top" background="images/news_tblbg.jpg" class="link_txt"><u>News / Offers</u> </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>
</body>
</center>
</html>
