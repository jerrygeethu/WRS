<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="VEMP";
require_once('include/parameters.php');
//require_once('include/schedule_functions.php');
$user_id =  $_SESSION['USERID'];
$emp_power = emp_authority($user_id);
//printarray($emp_power);

if(isset($_GET['d']) && $_GET['d']!='')
{
    $departSelected = $_GET['d'];
}

$departSelected = ($departSelected!='')?$departSelected:'';


require_once('include/class.employee.php');
$objemployee = new employee();


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-View Employee</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
// defult js functions start

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
// defult js functions end


function editEmployee(empid){

if(empid!="")
    document.location.href="employee.php?edit="+empid;
}

function assignwork(empid,depid){

if(empid!="")
    document.location.href="assignactivity.php?empid="+empid+"&d="+depid;
    //alert(depid);
}

function changeDepart(){
//alert(document.getElementById('departmentid').value);
if(document.getElementById('departmentid').value!=null)
document.location.href="viewemployee.php?d="+document.getElementById('departmentid').value;

}
function addNewEmployee()
{
    if(document.getElementById('departmentid').value=="0")
    {
       if(document.getElementById('departmentid').size>1)
           document.getElementById('departmentid').selectedIndex = 1;
       
    }
     document.location.href="employee.php?d="+document.getElementById('departmentid').value;
    
}
-->	
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">

<!--  Start top banner	 -->
<tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
<!-- end top banner  -->


<!-- side menu Left start edietd by  **** sukeshawh@gmail.com **** -->
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
<?php
print show_menu();?></td>
     <td width="100%" height="30"  class="head_with_back_button">
<?php print get_table_link("Employee","empicon.jpg");?>
</td>
	</tr>

<!--
<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="84%"  height="30" align="left" valign="middle" bgcolor="#D1D1D3" class="Head_txt">&nbsp;Add / Edit Departments </td>
          <td width="10%" height="30" align="center" valign="middle" bgcolor="#D1D1D3" class="Date_txt">27/04/2009 </td>
          <td width="3%" height="30" align="center" valign="middle" bgcolor="#D1D1D3"><img src="images/icon1.jpg" alt="" width="29" height="27" /></td>
          <td width="3%" height="30" align="center" valign="middle" bgcolor="#D1D1D3"><img src="images/icon2.jpg" alt="" width="29" height="27" /></td>
        </tr>
      </table>

-->
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->



<tr>
    <td width="791" height="500" align="center" valign="top" cellpadding="2"  class="main_content_p">
	
    <table width="100%" border="1" cellspacing="0" cellpadding="0" >



	<tr align="left">
		<td colspan="5" height="30px" class="table_head">
			<?php 
			//[Add new employee] permission added for admin,HOD,hr
			echo ($emp_power['is_admin']=='1') || ($emp_power['is_hod'] =='1') || ($emp_power['is_hr'] =='1')?"<a href=\"#\" onClick=\"addNewEmployee();\" ><img width=\"11\" border=\"0\" height=\"14\" src=\"".$_SESSION['FOLDER']."add_new.jpg\"/></a>&nbsp;<a href=\"#\" onClick=\"addNewEmployee();\" >Add New Employee</a>":"&nbsp;" ?>
		</td>
	</tr>



       <tr align="left">
       <td colspan="5" height="30px"><label class="menu_txt" for="departmentid">Select Department</label>&nbsp;
        <select id="departmentid" name="departmentid" style="width:184px"  onChange="javascript:changeDepart();">
        <?php $objemployee->getDepartmentList($emp_power,$departSelected) ?>
        </select>
        </td>
      </tr>
      
	  
	  <!-- <tr align="left">
       <td colspan="5" height="30px"><label class="menu_txt" for="schlist">Select schedule</label>&nbsp;
        <select id="schlist" name="schlist" style="width:184px">
		<option></option>
        <?php  ?>
        </select>
        </td>
      </tr>-->
	  
	  
	  
	  
      <?php 
	     $objemployee->listemployee($emp_power,$departSelected); 
    ?>
    </table>
</tr>
<!-- start footer coded by *** hmrsqt@gmail.com *** -->
   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
<!-- end footer coded by *** hmrsqt@gmail.com *** -->
</table>

</div>
</body>
</center>
</html>
