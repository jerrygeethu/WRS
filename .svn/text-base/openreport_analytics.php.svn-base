<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="OSR";
$_SESSION['VSTIME']=0;
$_SESSION['VMTIME']=0;
require_once('include/parameters.php');
require_once('include/openreport_functions.php');
$err="";
$emp_power=emp_authority($_SESSION['USERID']);	
$empid=$_SESSION['USERID'];

if(isset($_POST['go']))
{
$depid=	$_POST['departmentid'];
$emp=$_POST['employeeid'];
$year=$_POST['year'];
$month=$_POST['month'];
//echo  "   d=".$depid."  e=".$emp."    m=".$month;
}

















	if((isset($_POST['departmentid']) and $_POST['departmentid']!=''))
	{
    	$departSelected = $_POST['departmentid'];
	}
	else
	{
		$departSelected=$emp_power['emp_deptid'];
	}


if(isset($_POST['employeeid']) && $_POST['employeeid']!='')
	{
		$emp_id=intval($_POST['employeeid']);
	}
	else
	{
		$emp_id=$_SESSION['USERID'];
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Open Reports Analytics </title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/saxan.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet">
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/callAjax.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>
<script type="text/JavaScript">
<!--
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


//-->

</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
    </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">      
        <?php 
      $menu=show_menu();
      print $menu;
      ?>      
      </td>
      <td width="100%" height="30" align="right" valign="top" class="head_with_back_button"><?php 
			print get_table_link("Open Report Analytics","valiicon.jpg");?></td>
    </tr>
    <tr>
      <td height="580px" align="center" valign="top"  class="main_content_p">
											<table class="main_content_table" border="0">
												<!--<tr align="center">
													<td colspan="4"  >
													<div class="table_head">&nbsp;&nbsp;&nbsp;Analytics</div>
													</td>
												</tr>-->
          
												<tr>
													<td   class="table_head" >
         
        
																	<form method="POST" id="rptForm" name="rptForm" action="openreport_analytics.php" >
																	<table border="0">
																	<tr>
																	<td width="18.5%" nowrap ><label style="width:150px;">Department&nbsp;&nbsp;&nbsp;</label>:		        
																	<select id="departmentid" name="departmentid" style="width:184px" onchange="document.rptForm.submit()">
																	<?php print department($emp_power,$departSelected);?>
																	</select>
																	</td>
																			
																	<td width="18.5%" nowrap><label style="width:150px;">Employee&nbsp;&nbsp;&nbsp;</label>:		        
																	<select id="employeeid" name="employeeid" style="width:184px" onchange="document.rptForm.submit()">
																	<?php
																	 print	employeelist($emp_power,$departSelected,$emp_id);
																	?>
																	</select>
																	</td>
																			
																	<td width="18%" nowrap><label style="width:150px;">Year&nbsp;&nbsp;&nbsp;</label>:		        
																	<select id="year" name="year" style="width:184px" >
																	<?php
																	 for($i=2008;$i<=2020;$i++)
																	 {
																		?>
																		<option value="<?php echo $i; ?>" <?php 
																		if($_POST['year']==$i) {
																		?>selected="selected" <?php } ?>><?php echo $i;?></option>
																		<?php 
																		}
																	?>
																	</select>
																	</td>		
			 
																	<td width="55%" nowrap>																	
																	<?php 
																	//Months array
																	$arrMonths = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
 
																	?>
																	<label style="width:150px;">Month &nbsp;&nbsp;&nbsp;</label>:	
																	<select name="month" id="month" style="width:180px">
																	<?php 
																	foreach($arrMonths as $key=>$value)
																	{
																		?>
																		<option value="<?php echo $key;?>" <?php 
																		if($_POST['month']==$key) {
																		?>selected="selected" <?php } ?>><?php echo $value;?></option>
																		<?php 
																	}
																	?>
																	</select>
															
																	<input type="submit" value="GO" NAME="go" ID="go" name="get_pre_report" class="s_bt" id="get_pre_report"/>	
																	</td>
																</tr>
																</table>
																</form>
																
																
		
											</td>				
										</tr>
										</table> 
										
										
										
										
      	 <div id="show_report" name="show_report">
				 <?php				
				if(isset($_POST['go']))
				{		
							?>
								<table width="100%" border="0" id="show_date" name="show_date" class="main_content_table">
								<tr>									
							<?php
						//	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_hod'] ==1)||($emp_power['is_hr']==1)||($emp_power['is_admin']==1))
							{			
								$report=openreport_analytics($depid,$emp,$year,$month);
								print $report;
							}
								
							?>
							</tr>
							</table>
							<?php 
				}
				?>
				</div>      
              </td>
          </tr>
      </table> 
	    </td>
    </tr>
	 <tr>
	<td height="30" colspan="4" align="center" valign="middle"  class="Footer_txt">
	<?php footer();?>
	</td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
