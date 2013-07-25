<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="VWR";
require_once('include/parameters.php');
$emp_power = emp_authority($_SESSION['USERID']);
require_once('include/schedule_functions.php');
require_once('include/view_report_functions.php');



if(!(isset($_SESSION['FROM_SHOW'])))
{
	//make starting date of month
	$a = localtime();
	$a[4] += 1;
	$a[5] += 1900;
	$yest="01/".$a[4]."/".$a[5]; //dmy
	$from=$yest;
	$_SESSION['FROM_SHOW']=$yest;
}
if(!(isset($_SESSION['TO_SHOW'])))
{	
	//make yesterday of current month
	$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));	
	$_SESSION['TO_SHOW']=date("d/m/Y", $yest);
	$to=date("d/m/Y", $yest);
	//echo "f=".$from."<br/>t=".$to;
	if(strtotime($from)>strtotime($to))
	{		
		$arr=explode("/",$from);
		$day=$arr[0];
		$month=$arr[1]-1;
		$year=$arr[2];
		$arr_date=$day."/".$month."/".$year;
		$_SESSION['FROM_SHOW']=$arr_date;			
	}
	
}
$nemps="";											
			foreach(emp_list_after_reporting_to($_SESSION['USERID'],$emp_power) as $em){
				$nemps .=($nemps=="")? $em : ",".$em;
				}
$emp_power['is_hod']=(intval($emp_power['from_rep'])>0)? 1 : 0;
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
{
	$dept_view_list=get_dept_list($_SESSION['VDPRT']);
}


if(isset($_POST['content_type']))
{
	$_SESSION['VIEW_REPORT']=$_POST['content_type'];
}
else if(!(isset($_SESSION['VIEW_REPORT'])))
{
	$_SESSION['VIEW_REPORT']="emp";
}
$view_content=$_SESSION['VIEW_REPORT'];
$emp_selected="";
$sch_selected="";

/*
		$nemps="";											
			foreach(emp_list_after_reporting_to($_SESSION['USERID'],$emp_power) as $em){
				$nemps .=($nemps=="")? $em : ",".$em;
				}
*/
		//	$nemps=$emp_power['from_rep'];

				
				
			  
if($view_content=="emp")
{
	$emp_selected=" selected=selected";
	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
	{
	 	$view_report_query="select "
											." emp.employeeid as empid, "
											." emp.title as title, "
											." emp.empstatus as empstatus, "
											." emp.fullname as fn "
											
									." from "
											." employee as emp 
									where 
											emp.departmentid ='".$_SESSION['VDPRT']."' and  emp.employeeid!='".$_SESSION['USERID']."' and emp.employeeid >1 and emp.employeeid in (".$nemps.")
									order by emp.empstatus asc";
	}
	else if($emp_power['is_super'] =='1')
	{
		//print " hallo ";
		$view_report_query="select "
											." emp.employeeid as empid, "
											." emp.title as title, "
											." emp.empstatus as empstatus, "
											." emp.fullname as fn "										
									." from "
											." schedule as sch, "
											." schactivity as sact, "
											." employee as emp "
									." where "
											." sch.supervisorid ='".$_SESSION['USERID']."' "
											." and sch.scheduleid=sact.scheduleid "
											." and emp.employeeid!='".$_SESSION['USERID']."' "
											." and emp.employeeid=sact.employeeid  and emp.employeeid >1  and emp.employeeid in (".$nemps.")"
											." group by sact.employeeid "
											." order by emp.empstatus asc";
	}	
//	echo $view_report_query;
	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['is_super'] =='1'))
	{					
			$result_report_query = $GLOBALS['db']->query($view_report_query);
	}
	$table_employee="<tr><td colspan=\"7\">";
	$i=0;
	if(isset($result_report_query) and $result_report_query->num_rows>0)
	{
		while($row = $result_report_query->fetch_assoc())
		{
			$i++;
			if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
			
			
			$table_employee.="<form method='POST' action='empreport.php' name=".$row['empid']." id=".$row['empid'].">";
			$table_employee.="<table width='100%' border=\"0\"  class=\"main_content_table_inner\">
									<tr ".$class.">";
			$table_employee.="<td width='3%' >";
			$table_employee.=$i;
			$table_employee.="</td>";
			$table_employee.="<td width='12%'";if($row['empstatus']=='inactive')  { $table_employee.="style=\"color:#FF0000\""; } $table_employee.=">";
			$table_employee.=ucwords($row['title']).". ".ucwords($row['fn']);
			$table_employee.="</td>";
			///
			//get schedules for a employee[tables: schedule,schactivity]    
			$getSch="SELECT distinct
							s.`scheduleid`,s.`description`
						  FROM 
						   `schedule` as s,schactivity as schact
						  WHERE 
						   schact.employeeid='".$row['empid']."'
						   and 
						   s.`scheduleid`=schact.`scheduleid`
						   and
						   s.schstatus='assigned'
						   ";						   
			$resultSch=$GLOBALS['db']->query($getSch);
			
			$table_employee.="<td width='23%'>";
			$table_employee.="<select name=\"schlist\" id=\"schlist\" style=\"width:200px;height:30px\">";
			$table_employee.="<option selected=\"selected\" value=\"all\">All Reports</option>";
			if($resultSch->num_rows>0)
			{
				while($rowSch=$resultSch->fetch_assoc())
				{							
					$table_employee.="<option value=\"".$rowSch['scheduleid']."\">".$rowSch['description']."</option>";			
				}	
			}
			$table_employee.="<option value=\"nosch\">Unscheduled Reports</option>";
			$table_employee.="</select>";
			$table_employee.="</td>";
			///
			$table_employee.="<td width='13%' > ";
			$table_employee.="<input type=\"text\"  id=\"".$row['empid']."-report_from_date\"  name=\"".$row['empid']."-report_from_date\" size=\"30px\" maxlength=\"12\" readonly=\"true\" value=\"".$_SESSION['FROM_SHOW']."\" style=\"width: 80px;\" /> <img onclick=\"displayDatePicker('".$row['empid']."-report_from_date');\" value=\"select\" src=\"images/cal.gif\"/>";
			$table_employee.="</td>";
			$table_employee.="<td width='13%' >";
			$table_employee.="<input type=\"text\"  id=\"".$row['empid']."-report_to_date\"  name=\"".$row['empid']."-report_to_date\" size=\"30px\" maxlength=\"12\" readonly=\"true\" value=\"".$_SESSION[ 'TO_SHOW']."\" style=\"width: 80px;\" /> <img onclick=\"displayDatePicker('".$row['empid']."-report_to_date');\" value=\"select\" src=\"images/cal.gif\"/>";
			$table_employee.="</td>";
			/////////
			$table_employee.="<td width='20%' >";
			$table_employee.="<input type=\"text\"  id=\"search\"  name=\"search\" size=\"30px\" maxlength=\"12\"  style=\"width: 200px;\" /> ";
			$table_employee.="</td>";
			//<img src=\"images/veiwicon.jpg\"/>
			/////////
			$table_employee.="<td width='16%' nowrap='nowrap'>";
			$table_employee.="<input type='hidden' name='emp_id_report_details' id='emp_id_report_details' value=".$row['empid']." />";$table_employee.="<input type='hidden' name='emp_name_report_details' id='emp_name_report_details' value=".ucwords($row['fn'])." />";
			$table_employee.="<input type='submit'  class=\"s_bt\" name=\"getreport\" id=\"getreport\" value='Get Report' onclick=\"dateValidate('".$row['empid']."-report_from_date' , '".$row['empid']."-report_to_date','".$row['empid']."')\"/>";
			//	$table_employee.="</td>";
				//$table_employee.="<td width='2%'>";
			$table_employee.="<input type='submit'  class=\"s_bt\" name=\"analyticreport\" id=\"analyticreport\" value='Analytics Report' onclick=\"dateValidate('".$row['empid']."-report_from_date' , '".$row['empid']."-report_to_date','".$row['empid']."')\"/>";
			$table_employee.="</td>";
			$table_employee.="</tr></table></form>";
		}
	}
	else
	{
		$table_employee.="<tr><th colspan='8'>You Haven't Assigned Any Works So Far !!</td></tr>";
	}
	$table_employee.="</td></tr>";
	$table_employee.="<tr><th colspan='8'>***</td></tr>";
}
else if($view_content=="sch")
{
	// case when schedule is selected.
	$sch_selected=" selected= selected ";
	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1'))
	{
		$schedule_content_query=" 		 select "
																			." sch.scheduleid, "
																			." sch.description, "
																			." sch.schfromdate, "
																			." sch.schtodate, "
																			." sch.schstatus "
																." from "
																			." schedule as sch "
																." where "
																			." sch.departmentid ='".$_SESSION['VDPRT']."' "
																." order by "
																			." sch.schfromdate desc ";
	}
	else if($emp_power['is_hod'] =='1')
	{
		$schedule_content_query=" 		 select "
																			." sch.scheduleid, "
																			." sch.description, "
																			." sch.schfromdate, "
																			." sch.schtodate, "
																			." sch.schstatus "
																." from "
															 				." schedule as sch , schemployee as se "
																." where "
																			." sch.departmentid ='".$_SESSION['VDPRT']."' 
																			and se.scheduleid = sch.scheduleid
																			and se.employeeid in (".$nemps.") 
																			
																			"
																." order by "
																			." sch.schfromdate desc ";
	}
	else if($emp_power['is_super'] =='1')
	{
		 $schedule_content_query=" 		 select "
																			." sch.scheduleid, "
																			." sch.description, "
																			." sch.schfromdate, "
																			." sch.schtodate, "
																			." sch.schstatus "
																." from "
																			." schedule as sch "
																." where "
																			." sch.scheduleid in (".$emp_power['issup_schid'].")"
																." order by "
																			." sch.schfromdate desc ";
	}
	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['is_super'] =='1'))
	{					
	$result_content_query = $GLOBALS['db']->query($schedule_content_query);
	}
	$table_schedule="";
	$i=0;
	$table_schedule.="<tr  align=\"center\" > "
								."<th style='width:10%;'>Sl No:</th>"
								."<th style='width:50%;'>Description</th>"
								."<th style='width:10%;'>From</th>"
								."<th style='width:10%;'>To</th>"
								."<th style='width:10%;'>Status</th> "
								."<th style='width:10%;'></th> "
								."</tr><tr><td colspan=\"6\">";
	if(isset($result_content_query) and $result_content_query->num_rows>0)
	{
		while($row_content = $result_content_query->fetch_assoc())
		{
			$i++;
			if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
			$table_schedule.= "<form method=\"POST\" action=\"schreport.php\" name='".$row_content['scheduleid']."' id='".$row_content['scheduleid']."' ><table width='100%' border=\"0\" class=\"main_content_table_inner\">";
			$table_schedule.= "<tr ".$class.">";
			$table_schedule.= "<td style='width:10%;'>";
			$table_schedule.= $i;
			$table_schedule.= "</td>";
			$table_schedule.= "<td style='width:50%;' align='left'>";
			$table_schedule.= $row_content['description'];
			$table_schedule.= "</td>";
			$table_schedule.= "<td style='width:10%;'>";
			//$table_schedule.= ymdtodmy($row_content['schfromdate']);
			$table_schedule.="<input type=\"text\"  id=\"".$row_content['scheduleid']."-report_from_date\"  name=\"".$row_content['scheduleid']."-report_from_date\" size=\"30px\" maxlength=\"12\" readonly=\"true\" value=\"".$_SESSION['FROM_SHOW']."\" style=\"width: 80px;\" /> <img onclick=\"displayDatePicker('".$row_content['scheduleid']."-report_from_date');\" value=\"select\" src=\"images/cal.gif\"/>";
			$table_schedule.= "</td>";
			$table_schedule.= " <td style='width:10%;'>";
			//$table_schedule.= ymdtodmy($row_content['schtodate']);
			$table_schedule.="<input type=\"text\"  id=\"".$row_content['scheduleid']."-report_to_date\"  name=\"".$row_content['scheduleid']."-report_to_date\" size=\"30px\" maxlength=\"12\" readonly=\"true\" value=\"".$_SESSION[ 'TO_SHOW']."\" style=\"width: 80px;\" /> <img onclick=\"displayDatePicker('".$row_content['scheduleid']."-report_to_date');\" value=\"select\" src=\"images/cal.gif\"/>";
			$table_employee.="</td>";
			$table_schedule.= "</td>";
			$table_schedule.= "<td style='width:10%;'>";
			$table_schedule.= $row_content['schstatus'];
			$table_schedule.= "</td>";
			$table_schedule.= "<td style='width:10%;'>";
			$table_schedule.=  "<input type='hidden' id=\"sch_id\" name=\"sch_id\" value='".$row_content['scheduleid']."' />
			<input type='hidden' id=\"sch_descr\" name=\"sch_descr\" value='". substr($row_content['description'],0,50)."' /><input type='button' id=\"sch_submit\" name=\"sch_submit\"  class=\"s_bt\" value='Details' onclick=\"dateValidate('".$row_content['scheduleid']."-report_from_date' , '".$row_content['scheduleid']."-report_to_date','".$row_content['scheduleid']."')\"/>";
			$table_schedule.= "</td>";
			$table_schedule.= "</tr></table></form>";
		}
	}
	else
	{
		$table_schedule.="</td></tr><tr><th colspan='6'>No Scheduled Works So Far !!</th></tr>";
	}
	$table_schedule.="<tr><th colspan='6'>***</th></tr>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-View Reports</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet">
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<script language="JavaScript" src="js/calendar.js"></script>
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

var aceDate=new Date()
var aceYear=aceDate.getYear()
if (aceYear < 1000)
aceYear+=1900
var aceDay=aceDate.getDay()
var aceMonth=aceDate.getMonth()+1
if (aceMonth<10)
aceMonth="0"+aceMonth
var aceDayMonth=aceDate.getDate()
if (aceDayMonth<10)
aceDayMonth="0"+aceDayMonth
//document.write("<font color='000000' face='Arial' size='2'><b>"+aceDayMonth+"/"+aceMonth+"/"+aceYear+"</b></font></small>")


function dateValidate(dateField1,dateField2,formid)
{
  var retVal = true;
  dateValue1 = document.getElementById(dateField1).value;
  dateValue2 = document.getElementById(dateField2).value;
  //var dateObj = getFieldDate(dateValue);
  var today = new Date();
  today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

  if((dateValue1=='') ||( dateValue2==''))
  {// Add one day schedule work if no date ranges selected
    
    
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
    // alert(retVal);
     //return retVal;
     
     if(retVal==true){
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
      <td height="101" colspan="2" align="left" valign="middle" class="Head">
      <img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top"  class="menu_back">
      
        <?php 
      $menu=show_menu();
      print $menu;
      ?>
      
      </td>
     <td width="100%" height="30px" align="right" valign="top"    class="head_with_back_button">
      <?php 
     		print get_table_link("View Reports","veiwicon.jpg");
      ?>
      </td>
    </tr>
    <tr>
      <td  height="580px" align="left" valign="top" class="main_content_p">
             <table width="100%" border="0">
                 <tr  class="table_heading">
                     <td align="center" >
                     <?php print $dept_view_list;?>
                     </td>
                     <td align="right" width="15%" nowrap>
                      <form method="post" id="form_con_type" action="viewreport.php" >
    <label style="font-size:small;">Change View : 
    </label>&nbsp;
    <select name="content_type" id="content_type" onchange="document.getElementById('form_con_type').submit();" >
    <option value="emp" <?php print $emp_selected; ?> >Employee</option>
    <option value="sch" <?php print $sch_selected; ?> >Schedule</option>
    </select>
    </form>
                     </td>
                 </tr>
             </table>
              
   
      <table width="100%" class="data_align">
	        <tr>
	            <td valign="top">
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
             
               <div id="view_content" name="view_content" >
<table width="100%" border="0" class="main_content_table">
<?php 
if($view_content=="emp")
{
	if($_SESSION['VDPRT']!=0)		
	{
		?>		
		<tr align="center" >
		<td colspan="8">
		<div class="table_heading">View Employee Reports</div>
		</td>
		</tr> 
		<tr align="center" >
		<th style='width:3%;'>    
		Sl No:
		</th>
		<th style='width:12%;'>
		Employee Name
		</th>
		<th style='width:23%;'>
		Schedule
		</th>
		<th style='width:13%;'>
		From :
		</th>
		<th style='width:13%;'>
		To :
		</th>
		<th style='width:20%;'>
		Search:
		</th>
		<th style='width:16%;'>
		
		</th>
		
		</tr>		
		<?php 
	}
	if($_SESSION['VDPRT']!=0)
	print  ucwords($table_employee);
}
else
{
	if($_SESSION['VDPRT']!=0)
	print ucwords($table_schedule);
}
?>
</table>
    </div>
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              </td>
          </tr>
      </table>
      
      
      
      
              </td>
          </tr>
      </table>
      
	    
	    
	    
	    </td>
    </tr>
     <tr>
      <td height="30" colspan="4" align="center" valign="middle" class="Footer_txt">
      <?php footer();?>
      </td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
