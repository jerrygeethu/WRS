<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="HOME";
require_once('include/parameters.php');
require_once('include/home_schedule.php');
$result_sch=array();

if($_SESSION['USERID']>1)
{
	//require_once('include/home_schedule.php');
	$result_sch= get_schedules($sch_query,$from_date_show_sch);
}
if($result_sch[1]<1)
{
	$no_of_sch=" no ";
}
else
{
	$no_of_sch=$result_sch[1];
}
//for checking employee access to validate report link     
$emp_power=emp_authority($_SESSION['USERID']);
echo printarray($emp_power);
$dep_id=$emp_power['ishod_deptid'];
$period=7;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Home </title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script language="javascript" type="text/javascript">
function newWindow()
{
	window.open('approveRequest.php','welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes');
}
function showHideDiv(divo)
{
	divstyle = document.getElementById(divo).style.display;
	if(divstyle=="none" || divstyle == "")
	{
	   document.getElementById(divo).style.display = "block";	
	}
	else
	{
		document.getElementById(divo).style.display = "none";
	}
}
</script> 
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
<td width="100%" height="30px" valign="top"  class="head_with_back_button"><?php print get_table_link("Home","homeicon.jpg");?>
</td>
</tr>
<tr>
<td height="580" valign="top" class="home_main_td" >   



<?php if($_SESSION['USERID']>1)
{	    
	?>    
	<div id="date_picker" class="scheduled_work" align="right">
	
	<form id="getreportdate" name="getreportdate" method="post" action="home.php" >
	Select date to view your Scheduled works
	<input type="text"  id="get_sch_date" name="get_sch_date" size="30px" maxlength="12" readonly="true" 
	value="<?php print ymdtodmy($from_date_show_sch);?>" style="width:75px;" />
	<img onclick="displayDatePicker('get_sch_date');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
	<input type="submit"  value=" GO " class="s_bt"  name="get_pre_report" id="get_pre_report"/>
	</form>
	</div>
	<br/>
	<div class="table_heading">
	<label>
	Welcome <?php print $_SESSION['NAME'];?><br/>	
	You have <?php print $no_of_sch;?> Scheduled works for <?php print ymdtodmy($from_date_show_sch);?>
	</label>
	</div><br/>
	<?php 
	if($result_sch[1]>0)
	{
	   ?>
	  <div class="scheduled_work">
	  <?php
	  print $result_sch[0];
	  ?>
	  </div>
	  <br/>
	  <?php 
	}
	// if($result_sch[1]>0)
	//{
	print "<div class=\"table_heading\"> <label>Go to:<a href=\"report.php\" >Daily Report Page</a></label></div>";
	//}
	?>
	<?php //}
	//For checking missed daily reports
	if(missed_daily_report()) 	  
	{
	  ?>
	  <br/>
	  <div class="scheduled_work">	  		
			<label><?php echo  $show_missed_report=missed_daily_report(); ?></label>
	  </div>
	  <br/>
	  <?php
	}
}
//For approval of employee for schedule
if($emp_power['is_hod'] =='1')
{
	$query="select
 				req.jobrequestid,	
				sch.description,
				req.employeeid,
				req.request,
				req.requestdate,
				req.status,
				e.fullname
			from 
				emprequest  req,
				schedule sch,
				employee e
			where 
				 req.deptid='".$dep_id."'
			and
				 req.status='open'
			and
				 req.scheduleid=sch.scheduleid
			and
				e.employeeid=req.employeeid
				 
			";		
	$result=$GLOBALS['db']->query($query);
	if($result->num_rows>0)
	{
		$showApprove="<div class=\"scheduled_work\"><label><a href=\"javascript:newWindow();\">Approve employee request</a></label></div><br/>";
		echo $showApprove;
	}
}
//For checking employee access to validate report link
//if(($emp_power['is_super'] =='1') and ($emp_power['is_superadmin']!='1'))
if(($emp_power['is_superadmin']=='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['is_super'] =='1'))
{
echo $show_validate_report=missed_validate_report($emp_power); 
}
//For finding Upcoming Birthdays 
$data=getBdayLimit($period);		
$count=count($data);	
$dates="";	
for($x=0;$x<$count;$x++)
{
	if($dates!="") $dates.=" or ";
	$dates.=" dob LIKE '%".$data[$x]."%'  ";	
}	

$selectDOB="select
							 employeeid,
							 fullname,
							 dob
							
						from 
							employee
						where  ";								
						$selectDOB.="(".$dates.")" ;
						if($dates!="") $selectDOB.=" and ";
						$selectDOB.=" empstatus='active' and employeeid!=".$_SESSION['USERID']." order by right(convert(dob, char(10)),5), fullname
						 ";
					//echo  $selectDOB; 
$result= $GLOBALS['db']->query($selectDOB);
$num=$result->num_rows;
?>

<?php
if($result->num_rows>0)
{	
	echo "<div class='scheduled_work'><label>Upcoming Birthdays(".$num.")</label><br/>";
	echo "<table><tr>";
	$i=0;		
	while($row=$result->fetch_assoc())
	{
		$employee=$row['fullname'];
		$dob=$row['dob'];				
		
		//echo "<td>".$employee." : ".ymdtodmy($dob)."</td>";
		echo "<td><b>".$employee."</b> : ".date("d", strtotime($dob))."<sup>th</sup> ".date("F", strtotime($dob))."</td>";
		$i++;
	}	
	echo "</tr></table>";	
	echo "</div>";
}	
?>
<br/>

<?php
//Show todays absentees
//$Absentees=getAbsentees();
print getAbsentees();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//================Show  applied leaves on pending====================
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*SELECT e.fullname,l.`employeeid`,l.`sanctioned`,l.`employeeremarks` FROM `leaveapplication`l,employee e WHERE e.departmentid=2 and l.`sanctioned`=0 and l.employeeid=e.employeeid and e.employeeid!=29
*/

$leavequery="SELECT e.fullname, 
						l.employeeid,
						DATE_FORMAT(l.fromdate,'%d-%m-%Y') as fromdate,
						DATE_FORMAT(l.todate,'%d-%m-%Y') as todate,
						l.sanctioned
			FROM 
						leaveapplication l,employee e 
			WHERE  "; 
						if($emp_power['is_hod'] ==1)
						{
								$leavequery.="
								e.departmentid='".$emp_power['ishod_deptid']."' 
								AND ";
						}
						else
						{
								$leavequery.="e.employeeid='".$emp_power['emp_id']."' 
								AND
								";
						}
						$leavequery.="e.employeeid=l.employeeid
						AND						
						l.sanctioned=0 
						ORDER BY 
						e.fullname											
						 ";

//echo $leavequery;
$leaveresult= $GLOBALS['db']->query($leavequery);
$count=$leaveresult->num_rows;	
if($count>0)										
{
	$view_leave="<div class=\"scheduled_work\">
			<label>Approve leaves(".$count.")</label>
			<a href=\"#\" onclick=\"showHideDiv('div5')\">Details</a>
			</div><br/>
			<div id=\"div5\" class=\"divStyle3\">";
			//Show Hide Div visibility using Javascript DOM.
			while($row_leave = $leaveresult->fetch_assoc())	
			{												
				$view_leave.=$row_leave['fullname'].":(".$row_leave['fromdate'];
				if($row_leave['todate']!="00-00-0000") { $view_leave.="--".$row_leave['todate']; }				
				$view_leave.=")<br/>";
			}									
		$view_leave.="</div>";										
	//echo $view_leave;
}
?>
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
