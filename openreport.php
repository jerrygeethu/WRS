<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="OPN";
require_once('include/parameters.php');
require_once('include/openreport_functions.php');
$err="";
$emp_power=emp_authority($_SESSION['USERID']);	
$empid=$_SESSION['USERID'];
	


/////////////////////////////////   save click  //////////////////////////
if(isset($_POST['btnsave']))
{

	$openedby=$_SESSION['USERID'];
	$openedto=$_POST['employeeid'];
	$deptid=$_POST['departmentid'];
	$entrydate=date('Y-m-d');
	$date=isset($_POST['fromdate'])?dmyToymd($_POST['fromdate']):"";
	
	
	$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
	$today=strftime("%Y-%m-%d", strtotime($timestamp));
	$date1=strtotime($date);
	$today1=strtotime($today);
	if($date1>$today1)
	{
		$err=1;
		$errDate1="Reportdate must be lesser than today. ";
	}	
		
						
						
	if($date=="2009-01-01")
	{
		$err=1;
		$errDate="Enter date.";
	}
	if(($openedto=="")||($openedto==0))
	{
		$err=1;
		$errEmp="Enter employee.";
	}
	$query="select * from openreport where openedto='".$openedto."' and datetoenter='".$date."' ";
	$result = $GLOBALS['db']->query($query);
	if($result->num_rows>0 )
	{
			$err=1;
			$errDate="Report opened for the same date. ";
	}
	
	if($err!=1)
	{	
		$sub=check_submission($title,$objective,$date);
		if($sub==true)
		{
				$query="INSERT INTO openreport(openedby,openedto,deptid,datetoenter,entrydate) VALUES('".$openedby."','".$openedto."','".$deptid."','".$date."','".$entrydate."')";
				$result = $GLOBALS['db']->query($query);
			/*========mail to employee(openedto)=========*/
			require_once('include/class.mail.php');
			$obj=new mail();
			
			$query_id="select email from employee where employeeid = '".$openedto."'";											
			$result_id = $GLOBALS['db']->query($query_id);
			$row_id = $result_id->fetch_assoc();
			$toemp=$row_id ['email'];
			
			$query_id1="select fullname,email from employee where employeeid = '".$openedby."'";											
			$result_id1 = $GLOBALS['db']->query($query_id1);
			$row_id1 = $result_id1->fetch_assoc();
			$fromemp=$row_id1 ['email'];
			
			
			$data['from']=$fromemp;	
			$data['to']=$toemp;
			$data['bcc']=array('raghu.n@primemoveindia.com');
			$data['subject']="WRS::Report date opened";
			$data['message']="Hi, \n The Report date for ".$date." is opened by ".$row_id1 ['fullname'];	
			//printarray($data);
			$value1=$obj->mailsend($data);
				header("Location:viewopenreports.php?msg=2");
			}
			else
			{
					//$msgmeeting="Already added";
					header("Location:viewopenreports.php?msg=0");
			}
	}
	
	
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
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Home </title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="StyleSheet">
<link href="css/calendar.css" rel="StyleSheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/calendar.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>

				
		 <script>
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
      <td width="100%" height="30px" valign="top"  class="head_with_back_button"><?php print get_table_link("Open report","homeicon.jpg");?>
      </td>
    </tr>
    <tr>
      <td height="580" valign="top" class="home_main_td" >   

<!-- ============================================================================================= -->





<div class="leave_table"  valign="top" height="100%">
<table width="50%" height="100%" class="leave_table"  border="0" cellspacing="1" cellpadding="1">
    <tr>
        <td width="100px"  valign="top" align="center">
				<form name="frmreport" id="frmreport" method="POST" action="openreport.php"  >
				<table width="100%">
						<tr><td colspan="2" style="color:#FF0000"><?php echo $msgmeeting.$message.$meetingexists;?></td></tr>
						<tr>
								<td>
								Department
								</td>
							 <td>							 
										<label>
												<select id="departmentid" name="departmentid" style="width:184px" onchange="document.frmreport.submit()">
												<?php print department($emp_power,$departSelected);?>
												</select>
											</label>
								</td>								
						</tr>
						
						
							<tr>
								<td>
						 Employee
								</td>
								<td>
								<label>
												<select id="employeeid" name="employeeid" style="width:184px" onchange="document.frmreport.submit()">
												<?php
										     print	employeelist($emp_power,$departSelected,$emp_id);
												?>
												</select>
											</label>
								</td>
						</tr>
						<tr>
								<td colspan="2" align="center"><?php  if($errEmp!="") { echo $errEmp; }?></td>
						</tr>
						
						
						
						<tr>
								<td>
						 Date
								</td>
								<td>
								<input type="text"   id="fromdate" name="fromdate" maxlength="12"   readonly="true" class="date_text"  />
	<img onclick="displayDatePicker('fromdate');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/>								
								</td>
						</tr>
						<tr>
								<td colspan="2" align="center"><?php  if(($errDate!="")||($errDate1!="")) { echo $errDate.$errDate1; }?></td>
						</tr>
						
											
						
						<tr>
							<td colspan="2" align="justify">
							<input type="submit"  name="btnsave" id="btnsave" value="Save"  /> 
							</td>						
						</tr>
						
						
				</table>
				</form>


        </td>
    </tr>
</table>



</div>






























<!-- ============================================================================================= -->

 

     </td>	
    </tr>	
     <tr>
      <td height="30px" colspan="4" align="center" valign="middle"  class="Footer_txt"><?php footer();?></td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
