<?php
if(!(isset($_POST['sch_id']))){header('location:viewreport.php');}
require_once('include/include.php');
require_once('include/parameters.php');
require_once('include/schedule_functions.php');
$date_list_selected="";
$emp_list_selected="";
if(isset($_POST['view_list_type'])){
	$_SESSION['VIEW_DETAILED_REPORT']=$_POST['view_list_type'];
}
else if(!(isset($_SESSION['VIEW_DETAILED_REPORT']))){
	$_SESSION['VIEW_DETAILED_REPORT']="date";
	$date_list_selected=" selected=selected";
}
$view_list_content=$_SESSION['VIEW_DETAILED_REPORT'];
if($view_list_content=="emp"){
	$colsp=6;
	$emp_list_selected=" selected=selected";
}
else{
	$colsp=7;
}
if(isset($_POST['sch_id'])){	
$schedule_actvity_id=$_POST['sch_id'];
$schedule_description=$_POST['sch_descr'];
						if(isset($_POST[$schedule_actvity_id.'-report_from_date']))
						{
							$report_from_date=$_POST[$schedule_actvity_id.'-report_from_date'];
							$_SESSION['FROM_SHOW']=$_POST[$schedule_actvity_id.'-report_from_date'];
						}
						else if(!(isset($_SESSION['FROM_SHOW'])))
						{	
							//make starting date of month
							$a = localtime();
							$a[4] += 1;
							$a[5] += 1900;
							$yest="01/".$a[4]."/".$a[5]; //dmy
							$report_from_date=$yest;
							$_SESSION['FROM_SHOW']=$yest;
						}
						if(isset($_POST[$schedule_actvity_id.'-report_to_date']))
						{
							$report_to_date=$_POST[$schedule_actvity_id.'-report_to_date'];
							$_SESSION['TO_SHOW']=$_POST[$schedule_actvity_id.'-report_to_date'];
						}
						else if(!(isset($_SESSION['TO_SHOW'])))
						{	
							//make starting date of month
							$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
							$_SESSION['TO_SHOW']=date("d/m/Y", $yest);
						}




														 $get_schedule_details=" 	select 
																													DATE_FORMAT(act.logdate,'%d-%m-%Y') as logdate, 
																													act.timespent, 
																													act.empactivitylog, 
																													act.supremarks1, 
																													act.supremarks2,
																													emp.title, 
																													emp.fullname, 
																													schact.employeeid,
																													t.activityname
																											from 
																													activitylog as act ,
																													schactivity as schact, 
																													employee as emp,
																													activitytype as t 
																											where 
																														schact.employeeid=emp.employeeid	
																													and
																														schact.schactivityid=act.schactivityid
																													and 
																														schact.activitytypeid=t.activitytypeid  
																													and 
																													  schact.scheduleid='".$schedule_actvity_id."' 
																													and
																														(act.logdate between '".dmyToymd($report_from_date)."' "
																															." and '".dmyToymd($report_to_date)."') 
																													";
														if($view_list_content=="emp"){
															$get_schedule_details.=" order by emp.fullname,act.logdate asc ";
														}
														else{
																$get_schedule_details.=" order by act.logdate asc ";
														}
//echo $get_schedule_details;
$result_schedule_details = $GLOBALS['db']->query($get_schedule_details);
if(isset($result_schedule_details) and $result_schedule_details->num_rows>0) {
$i=0;			
$details="";
$current_emp_id="";
while($row_schedule = $result_schedule_details->fetch_assoc()) {
$i++;
if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
				if(($current_emp_id!=$row_schedule['employeeid'])&& $view_list_content=="emp"){				
					$i=1;
				$details.="<tr ".$class.">";  
				$sp=$colsp-1;
				$details.="<th colspan='".$sp."'  >";
				$details.=" Report of ".$row_schedule['title'].". ".$row_schedule['fullname'];
				$details.="</th>";
				$details.="<th colspan='2'>";
				// this query is to get the sum of the time of an employee..
				 $get_sum_time_spent=" select "
													." sum(act.timespent) "
										." from "
													." activitylog as act, "
													." schactivity as schact "
										." where "
													." schact.employeeid=".$row_schedule['employeeid']."	"
													." and schact.schactivityid=act.schactivityid "
													." and schact.scheduleid='".$schedule_actvity_id."' ";

$result_time_spent = $GLOBALS['db']->query($get_sum_time_spent);
$row_time_spent = $result_time_spent->fetch_assoc();
$time_spent=$row_time_spent['sum(act.timespent)'] / 60;
$total_time_spent=round($time_spent, 2)." Hrs " ;		

				$details.=" Spent   ".$total_time_spent."   On This Schedule ";
				$details.="</th></tr>";
				}
						$current_emp_id=$row_schedule['employeeid'];
				$details.="<tr ".$class.">";  
				$details.="<td>";
				$details.=$i;
				$details.="</td>";
				if($view_list_content=="emp"){
				}
				else{
				$details.="<td nowrap align=\"left\" >";
				$details.=$row_schedule['title'].". ".$row_schedule['fullname'];
				$details.="</td>";
				}
				$details.="<td align='left'>";
				$details.=$row_schedule['empactivitylog'];
				$details.="</td>";
				$details.="<td>";
				$details.=$row_schedule['logdate'];
				$details.="</td>";
				$details.="<td>";
				$details.=$row_schedule['activityname'];
				$details.="</td>";				
				$details.="<td>";
				$total_time0=$row_schedule['timespent']/60;
    		$final0 = round($total_time0, 2);
				$details.=$final0." Hrs";
				$details.="</td>";
				$details.="<td>";
				
				
				if($row_schedule['supremarks1']=="")$details.="No comments";else
				$details.=$row_schedule['supremarks1'];
				$details.="</td>";
				$details.="<td>";
				if($row_schedule['supremarks2']=="")$details.="No comments";else
				$details.=$row_schedule['supremarks2'];
				$details.="</td>";
				$details.="</tr>";
}
}
else{
	$sp=$colsp+1;
	$details.="<tr><th  colspan='".$sp."'  >No Reports Found For This Schedule !! </th></tr>";
}
$sp=$colsp+1;
$details.="<tr><th  colspan='".$sp."'  >***</th></tr>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?> -Schedule Reports</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/saxan.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

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
      <td width="100%" height="30" align="right" valign="top" class="head_with_back_button">
     <?php 
      print get_table_link("View Reports","veiwicon.jpg");
      ?>
      </td>
    </tr>
    <tr>
      <td  align="left" valign="top" bgcolor="#FFFFFF"  class="main_content_p" >
<table  class="main_content_table">
    <tr align="center"  bgcolor="#E5E5E5">
    <td colspan="<?php
    print $colsp;
    ?>" class="table_heading">
        
        Schedule: <?php
        print ucwords($schedule_description)."";
        ?></td>
        <td >
<form method="post" id="form_view_type" action="schreport.php" >
<input type='hidden' value='<?php print $schedule_actvity_id;?>' name='sch_id' id='sch_id'/>
<input type='hidden' value='<?php print $schedule_description;?>' name='sch_descr' id='sch_descr'/>
<input type='hidden' value='<?php print $report_from_date;?>' name='<?php print $schedule_actvity_id;?>-report_from_date' id='-report_from_date'/>
<input type='hidden' value='<?php print $report_to_date;?>' name='<?php print $schedule_actvity_id;?>-report_to_date' id='-report_to_date'/>

<label style="font-size:small;">Change View : 
    </label>&nbsp;<select name="view_list_type" id="view_list_type" onchange="document.getElementById('form_view_type').submit();">
    <option value="date" <?php print $date_list_selected; ?>  >Date Wise</option>
    <option value="emp" <?php print $emp_list_selected; ?> >Emp Wise</option>
    </select>
    </form>
</td>
    </tr>
    <tr bgcolor="#E5E5E5">
    <th>
    Sl No:
    </th>
    <?php
    if($view_list_content=="emp"){
				}
				else{
				print "<th>Name</th>";
				}
    ?>
    <th>
    Report
    </th>
    <th>
    Date
    </th>
    <th>
    Activity Type
    </th>
    <th>
    Time Spent
    </th>
    <th>
    Comment To Employee
    </th>
    <th>
    Comment To Admin
    </th>
    </tr>
    <?php  
    print ucfirst($details);
    ?>
    </td></tr>
</table>
</td>
</tr>
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
