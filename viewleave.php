<?php
require_once('include/include.php');
$_SESSION['SEL_LINK'] = "VLVE";
require_once('include/parameters.php');
require_once('include/leave_functions.php');
require_once('include/class.employee.php');
$objemployee=new employee();
$user_id =  $_SESSION['USERID'];
$emp_power = emp_authority($user_id);
if(isset($_GET['msg']))
{
$message=$_GET['msg'];
}

if(isset($_POST['departmentid']) && $_POST['departmentid']!='')
{
    $departSelected = $_POST['departmentid'];   
}
if(isset($_GET['d']))
{
$departSelected=$_GET['d'];
}
(int)$departSelected = ($departSelected!='')?$departSelected:$emp_power['emp_deptid'] ;

//Get From date
if(isset($_POST['fromdate']))
{
	$date_ar=explode('/',$_POST['fromdate']);
	$_SESSION['from']=$date_ar[2]."-".$date_ar[1]."-".$date_ar[0];
	$_SESSION['FROM_SHOW']=$_POST['fromdate'];

}
else if(!(isset($_SESSION['from'])))
{	
	//make starting date of month
	$a = localtime();
	$a[4] += 1;
	$a[5] += 1900;
	$yest="01/".$a[4]."/".$a[5]; //dmy
	$from=$yest;
	$_SESSION['from']=dmyToymd($yest);
	$_SESSION['FROM_SHOW']=$yest;
}

//Get To date
if(isset($_POST['todate']))
{
	$date_ar=explode('/',$_POST['todate']);
	$_SESSION['to']=$date_ar[2]."-".$date_ar[1]."-".$date_ar[0];
	$_SESSION['TO_SHOW']=$_POST['todate'];
}
else if(!(isset($_SESSION['to'])))
{
	$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
	$_SESSION['to']=date("Y-m-d", $yest);
	$_SESSION['TO_SHOW']=date("d/m/Y", $yest);;
	$fromdate=strtotime($from);
	$todate=$yest;
	if($fromdate>$todate)
	{		
		$arr=explode("/",$from);
		$day=$arr[0];
		if($arr[1]==1)
		{
			$month=12;
			$year=$arr[2]-1;
		}
		else
		{
			$month=$arr[1]-1;
			$year=$arr[2];
		}
		$arr_date=$day."/".$month."/".$year;
		$_SESSION['from']=$arr_date;
		$_SESSION['FROM_SHOW']=$arr_date;			
	}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>- Employee List</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="StyleSheet">
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"></script>
<script language="JavaScript" type="text/javascript">
<!--  // defult js functions
function MM_swapImgRestore()
{ //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages()
{ //v3.0
 	var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d)
{ //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage()
{ //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function changeDepart(fill)
{
if(document.getElementById('departmentid').value!=null)
document.location.href="viewleave.php?d="+document.getElementById('departmentid').value;
}
// To submitt value to create an employee Print
function gotoprint(dep) {
var w = document.getElementById('departmentid').selectedIndex;
   var choosed = document.getElementById('departmentid').options[w].text;
   var fileurl = "department="+dep+"&deptname="+choosed;
   document.location.href="printleave.php?"+fileurl;
}
-->
//Date validation
/*function checkall()
{	
	var datefrom = document.getElementById('fromdate').value;
	var dateto = document.getElementById('todate').value;
	alert(datefrom+"  "+dateto);		

	if(compareDates(datefrom,'dd/mm/yyyy',dateto,'dd/mm/yyyy')!=true) 
	{		
		alert("Please enter From Date less than To Date !!");
		displayDatePicker('todate');
		return true;
	}
	else
	{
		document.getElementById('getleave').submit();
	}
}*/
function checkall(dateField1,dateField2,formid)
{
	var retVal = true;
	dateValue1 = document.getElementById(dateField1).value;
	dateValue2 = document.getElementById(dateField2).value;	
	var today = new Date();
	today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
	if((dateValue1=='') ||( dateValue2==''))
	{
		var fromDateField = document.getElementsByName (dateField1).item(0);
     	fromDateField.value = getDateString(today);     
		var toDateField = document.getElementsByName (dateField2).item(0);
		today.setTime(today.getTime() + (1 * 24 * 60 * 60 * 1000));
		toDateField.value = getDateString(today);
		retVal= false;
	}
	else
	{
		var dateObj1 = getFieldDate(dateValue1);
		var dateObj2 = getFieldDate(dateValue2);     
		if(dateObj1 > dateObj2 || dateObj1 == dateObj2 )
		{
			 alert("To Date should be greater than From Date ");
			 displayDatePicker(dateField2);
			 retVal=false;		
		}    
	}
	if(retVal==true)
	{
		document.getElementById(formid).submit();
	}
}
function cancelLeave(leaveid,depid)
{ 
 var fileurl = "levid="+leaveid; 
   document.location.href="viewleave.php?d="+depid+"&"+fileurl;
}
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">

<div id="main_div">
	<form id="getleave" name="getleave" method="post" action="viewleave.php" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<!--  Start top banner edietd by  **** hmsqt@gmail.com ****	 -->
	<tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
<!-- end top banner  edietd by  **** hmsqt@gmail.com **** -->
<!-- side menu Left start edietd by  **** hmsqt@gmail.com **** -->
    <tr>
      <td width="159" rowspan="2" align="left" valign="top"  bgcolor="#9d9ea2">
        <?php 
      echo show_menu();
      ?>
      </td>
      <td width="100%" height="30" align="right" valign="top" bgcolor="#D1D1D3">
	 <?php print get_table_link("View Leave","vew_lvicon.jpg");?>
      </td>
	</tr>
	<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->

	<tr>
    <td width="791" height="500" align="center" valign="top" class="main_content_p">
    
    <table border="0" width="100%" class="main_content_table_test" >


      <tr align="left"><th colspan="9">	
	  <table border="0" width="100%" >
	  
	  
	  <tr>
	  <td id="validate" name="validate"><?php echo $message;?></td>
	  </tr>
	  
	  
		<tr>			
		<td align="left">
	  <!--	<form id="getleave" name="getleave" method="post" action="viewleave.php" >-->
	 	 <label class="menu_txt" for="departmentid">Select Department</label>&nbsp;
        <select id="departmentid" name="departmentid"   style="width:200px" onChange="javascript:changeDepart(this);"> 
		<!--<option value="0">select</option>-->
        <?php  	
		$dep=getDepartmentList($emp_power,$departSelected); //getDepartmentList($emp_power,$depmentid);
		print $dep['dept_option'];//print $dep;
		?>
        </select> 
		
		 &nbsp;&nbsp;&nbsp;&nbsp;
				From 
				<input type="text"  id="fromdate"  name="fromdate" size="30px" maxlength="12" value="<?php print $_SESSION['FROM_SHOW'];?>" style="width: 80px;"  readonly="true"/>
				<img onclick="displayDatePicker('fromdate');" value="select" src="images/cal.gif" title="Click Here To Select Date .."/>
				&nbsp;&nbsp;&nbsp;
				
				To 
				<input type="text" id="todate" name="todate" size="30px" maxlength="12" value="<?php print $_SESSION['TO_SHOW'];?>" style="width: 80px;" readonly="true"/>
				<img onclick="displayDatePicker('todate');" value="select" src="images/cal.gif" title="Click Here To Select Date .."/>
				&nbsp;&nbsp;&nbsp;
		
				<input type="button" value="GO" onclick="checkall('fromdate','todate','getleave');"  class="s_bt" name="get_leave_report" id="get_leave_report"/>
		<!--</form>-->
		 </td>
		 <td align="right">
	 <a  onclick="gotoprint(<?php echo $_POST['departmentid']; ?>)" ><img align="absmiddle" src="images/printericon.jpg" title="Print" alt="Print" /></a>
	 </td></tr>
	 </table>
        </th>
		</tr>
      <tr align="center" valign="middle" style="background-color:#CDCDCD;" >
        <th  nowrap class="link_txt">Sl No</th>
        <th class="link_txt">Name</th>
		<th class="link_txt">Leave type</th>      
        <th class="link_txt">From date</th>
		<th class="link_txt">To date</th>
		<th class="link_txt">No. of days</th>
		<th class="link_txt">Reason</th>
		<th class="link_txt">Status</th>		
	<?php	if(($emp_power['is_admin']==1) || ($emp_power['is_hod']==1) || ($emp_power['is_adminemp']==1)){ ?>
		<th class="link_txt">Options</th>
	<?php }	?>
      </tr>
	<?php
	if($departSelected!="")
	{
		$leave_list=viewleave($departSelected);
		print $leave_list;
	}
	?>
    </table>
    </td>
</tr>
 <tr>     
      <td height="30" colspan="4" align="center" valign="middle" bgcolor="#D1D1D3" class="Footer_txt">
		<?php footer();?>
      </td>
    </tr>
</table>
</form>
</div>
</body>
</center>
</html>
