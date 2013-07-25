<?php
require_once('include/include.php');
$_SESSION['SEL_LINK'] = "EMPL";
require_once('include/parameters.php');
//require_once('include/schedule_functions.php');
require_once('include/class.employee.php');
$objemployee = new employee();

$user_id =  $_SESSION['USERID'];

$emp_power = emp_authority($user_id);

if(isset($_GET['d']) && $_GET['d']!='')
{
    $departSelected = $_GET['d'];
    $depmentid = $_GET['d'];
}
//echo "asdasd".$departSelected;
$dep_id =  $emp_power['ishod_deptid'];//$emp_power['emp_deptid'];

$departSelected = ($departSelected!='')?$departSelected:$dep_id;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>- Employee List</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" type="text/javascript">
<!--  // defult js functions

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


function changeDepart(fill){
//alert(fill);
//alert(document.getElementById('departmentid').value);
if(document.getElementById('departmentid').value!=null)
document.location.href="employeelist.php?d="+document.getElementById('departmentid').value;

}

// To submitt value to create an employee Print
function gotoprint(dep) {
	//asd = document.getElementById('departmentid').SelectedText;
		//asd = asd.text;
	//alert(asd);

var w = document.getElementById('departmentid').selectedIndex;
   var choosed = document.getElementById('departmentid').options[w].text;
   var fileurl = "department="+dep+"&deptname="+choosed;
   document.location.href="printemployeelist.php?"+fileurl;
}
-->
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">

<div id="main_div">
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
      
      
       <?php print get_table_link("Employee List","emplisticon.jpg");?>
      </td>
	</tr>
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->

<tr>
    <td width="791" height="500" align="center" valign="top" class="main_content_p">
    
    <table border="0" width="100%" class="main_content_table_test" >
      <tr align="left"><th colspan="6"><label class="menu_txt" for="departmentid">Select Department</label>&nbsp;
        <select id="departmentid" name="departmentid"   onChange="javascript:changeDepart(this);">
        <?php $objemployee->getDepartmentListforemployeelist($depmentid) ?>
        </select>  &nbsp;&nbsp;&nbsp;&nbsp;
	 <a valign="middle" onclick="gotoprint(<?php echo $_GET['d']; ?>)" ><img align="absmiddle" src="images/printericon.jpg" title="Print" alt="Print" />
        </th></tr>
      <tr align="center" valign="middle" style="background-color:#CDCDCD;" >
        <th  nowrap class="link_txt">Sl No</th>
        <th class="link_txt">Name</th>
        <?php if($depmentid<=0 || $depmentid =='') echo "<th class=\"link_txt\">Department</th>"; ?>
        <th class="link_txt">Contactno</th>
	<th class="link_txt">Email</th>
	<th class="link_txt">Address</th>
      </tr>
	<?php $objemployee->employeenormallist($depmentid); ?>
    </table>
    
    
    
    </td>
</tr>
 <tr>
     
      <td height="30" colspan="4" align="center" valign="middle" bgcolor="#D1D1D3" class="Footer_txt">
	<?php footer();?>
      </td>
    </tr>
</table>
</div>
</body>
</center>
</html>
