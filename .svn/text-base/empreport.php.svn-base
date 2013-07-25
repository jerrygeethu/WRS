<?php
require_once('include/include.php');
require_once('include/schedule_functions.php');
require_once('include/parameters.php');
$emp_power=emp_authority($_SESSION['USERID']);


//echo "p=".$_POST['analyticreport'];
//if(isset($_POST['btngo']))
if(isset($_POST['emp']))
{

	$report_from_date=$_POST['from_date'];
	$report_to_date=$_POST['to_date'];
	$sch_id=$_POST['sch_hidden'];
	$get_emp_id=$_POST['emp'];
	$query="select empname from employee where employeeid='".$get_emp_id."'";
	$result = $GLOBALS['db']->query($query);
	$row = $result->fetch_assoc();	
	$emp_name_report_details=ucwords($row['empname']);
	
}

if(isset($_POST['emp_id_report_details']))
{
	$get_emp_id=$_POST['emp_id_report_details'];
	$emp_name_report_details=$_POST['emp_name_report_details'];
	// $report_from_date=$_POST[$get_emp_id.'-report_from_date'];
	//$report_to_date=$_POST[$get_emp_id.'-report_to_date'];	
	$search=$_POST['search'];
	$sch_id=$_POST['schlist'];
	//echo "sch=".$sch_id."<br/>";
	
	if(isset($_POST[$get_emp_id.'-report_from_date']))
	{
		$report_from_date=$_POST[$get_emp_id.'-report_from_date'];
		$_SESSION['FROM_SHOW']=$_POST[$get_emp_id.'-report_from_date'];
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
	if(isset($_POST[$get_emp_id.'-report_to_date']))
	{
		$report_to_date=$_POST[$get_emp_id.'-report_to_date'];
		$_SESSION['TO_SHOW']=$_POST[$get_emp_id.'-report_to_date'];
	}
	else if(!(isset($_SESSION['TO_SHOW'])))
	{	
		//make starting date of month
		$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
		$_SESSION['TO_SHOW']=date("d/m/Y", $yest);
	}
	
}



if((isset($_POST['analyticreport'])) || ($_POST['flag_hidden']==1))
{
	//set a flag 
	$flag=1; 
												/*/////////////////////////////////////////////////////////////////////////////////////////////*/
												/*////////////////////              Analytics Report               //////////////////*/
												/*///////////////////////////////////////////////////////////////////////////////////////////*/
												
																								
											$view_report_query="SELECT s.scheduleid,s.description, e.employeeid, e.empno,
																												e.fullname, sum(a.timespent /60 ) AS hours,
																												t.activityname 
																												FROM schedule s, schactivity AS sa, employee AS e, activitylog a,activitytype t
																												WHERE
																												sa.employeeid='".$get_emp_id."'
																												AND sa.activitytypeid = t.activitytypeid 
																												AND sa.employeeid = e.employeeid
																												AND a.schactivityid = sa.schactivityid
																												AND s.scheduleid = sa.scheduleid
																												";
								
										if(($sch_id!='all') and ($sch_id!='nosch'))
										{
										$view_report_query.=" and s.scheduleid='".$sch_id."' ";
										}
																			
											
										if((isset($report_to_date))&&($report_to_date!="")&&(isset($report_from_date))&&($report_from_date!=""))
										{
											$view_report_query.=" and (a.logdate between '".dmyToymd($report_from_date)."' "
																					." and '".dmyToymd($report_to_date)."') ";
										}
										else
										{
											$a = localtime();
											$a[4] += 1;
											$a[5] += 1900;
											$report_to_date=$a[3]."/".$a[4]."/".$a[5];
											$report_from_date="01/".$a[4]."/".$a[5];
											$view_report_query.=" and (a.logdate between '".dmyToymd($report_from_date)."' "
																				." and '".dmyToymd($report_to_date)."') ";
										}
										$view_report_query.="GROUP BY s.description,  e.employeeid, t.activitytypeid
																												ORDER BY s.scheduleid ";
										$result_report_query = $GLOBALS['db']->query($view_report_query);
										$employees="";
										$i=0;
										$sid=0;
										$tot_hrs=0;
										//echo "<br/><br/>". $view_report_query."<br/><br/>";
										if(isset($result_report_query) and $result_report_query->num_rows>0)	
										{
														$analytics.="<tr  >";  
														$analytics.="<td colspan='4'>";
														$analytics.="Work Reports ";
														$analytics.="</td>";
														$analytics.="</tr>";         
														$pr= 0; 
														while($row = $result_report_query->fetch_assoc())
														{
														$i++;							
													$hours=round($row['hours'],2);			
														##############################################################
														if($pr != $row['scheduleid'])  { //$sid=$row['scheduleid'];	 
														if(	 	$tot_hrs > 0	)
																							$analytics.="	 <tr> <td colspan='4'  align='right'> Total Hours:".$tot_hrs."</td> </tr>";  
																	 	$tot_hrs=0;																		  
														} 
													  		$tot_hrs += $hours;			 
																			$pr=$row['scheduleid'];		
														################################################################ 
														$analytics.="<tr class='even'>";
														$analytics.="<td>";
														$analytics.=$i;
														$analytics.="</td>";		
														$analytics.="<td>";
														$analytics.=ucwords($row['description']);
														$analytics.="</td>";
														$analytics.="<td>";
														$analytics.=ucwords($row['activityname']);
														$analytics.="</td>";
														$analytics.="<td align='left'>";
														$analytics.=$hours;	
														$analytics.="</td>";				
														$analytics.="</tr>";				 
														}
																$analytics.="	 <tr> <td colspan='4'  align='right'> Total Hours:".$tot_hrs."</td> </tr>";  
															
														
														
														
														
														
														
														
										}
										else
										{
											$analytics.="<tr><td colspan=\"9\">No  Reports Found !! </td></tr>";
										}
												//print $view_report_query;
												$analytics.="<tr ><th colspan=\"9\">*** </th></tr>";
										
												
												
												
}
else 	if((isset($_POST['getreport'])) || ($_POST['flag_hidden']==0))
{
	//set a flag 
	$flag=0; 
												/*/////////////////////////////////////////////////////////////////////////////////////////////*/
												/*////////////////////              View Report               ////////////////////////*/
												/*///////////////////////////////////////////////////////////////////////////////////////////*/
											
											
											
																							/////////////    Schedule    ///////////////////////
										// get the normal work report the employee had entered towards the scheduled works.. saxan..
										$view_report_query=" select "
																			." acttype.activityname as actname, "
																			." DATE_FORMAT(act.logdate,'%Y-%m-%d') as logdate, "
																			." act.timespent, "
																			." act.empactivitylog, "
																			." emp.fullname as super, "
																			." sch.description as descri, "
																			." act.supremarks1 as sup1, "
																			." act.supremarks2 as sup2"
																			." from "
																			." activitylog as act , "
																			." schactivity as sact, "
																			." employee as emp, "
																			." activitytype as acttype, "
																			." schedule as sch "
																			." where "
																			." sact.schactivityid=act.schactivityid "
																			." and sch.scheduleid=sact.scheduleid " ;
																			if(($sch_id!='all') and ($sch_id!='nosch'))
																			{
																			$view_report_query.=" and sch.scheduleid='".$sch_id."' ";
																			}
																			$view_report_query.=" and emp.employeeid=sch.supervisorid  
																				and act.empactivitylog LIKE '%".$search."%'									
																			and (acttype.activitytypeid=act.activitytypeid "
																			." or acttype.activitytypeid='0') "
																			." and sact.employeeid='".$get_emp_id."' ";
											
										if((isset($report_to_date))&&($report_to_date!="")&&(isset($report_from_date))&&($report_from_date!=""))
										{
											$view_report_query.=" and (act.logdate between '".dmyToymd($report_from_date)."' "
																					." and '".dmyToymd($report_to_date)."') ";
										}
										else
										{
											$a = localtime();
											$a[4] += 1;
											$a[5] += 1900;
											$report_to_date=$a[3]."/".$a[4]."/".$a[5];
											$report_from_date="01/".$a[4]."/".$a[5];
											$view_report_query.=" and (act.logdate between '".dmyToymd($report_from_date)."' "
																				." and '".dmyToymd($report_to_date)."') ";
										}


										if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
										{
											if($sch_id!='all')
											{
												$view_report_query.=" order by act.logdate asc ";
											}
										}
										else if($emp_power['is_super'] =='1')
										{
											$view_report_query.=" and sch.supervisorid='".$_SESSION['USERID']."' ";
											if($sch_id!='all')
											{
												$view_report_query.="order by act.logdate asc ";
											}
										}


											
																	/////////////    Unschedule   ////////////////////
										// for getting the reports he had entered while he has not worked for scheduled works
										$view_report_query_2=" select "
																							." acttype.activityname as actname, "
																							." DATE_FORMAT(act.logdate,'%Y-%m-%d') as logdate, "
																							." act.timespent, "
																							." act.empactivitylog, "
																							." '', "
																							." '', "
																							." act.supremarks1  as sup1, "
																							." act.supremarks2  as sup2"													 													
																				." from "
																							." activitylog as act , "
																							." activitytype as acttype, "
																							." schactivity as sact "
																				." where "
																							." sact.schactivityid=act.schactivityid "
																							." and sact.scheduleid is NULL "
																							." and (acttype.activitytypeid=act.activitytypeid "
																							." or acttype.activitytypeid='0') "
																							."and act.empactivitylog LIKE '%".$search."%'"
																							." and sact.employeeid='".$get_emp_id."' ";
													
										if((isset($report_to_date))&&($report_to_date!="")&&(isset($report_from_date))&&($report_from_date!=""))
										{
											$view_report_query_2.=" and act.logdate between '".dmyToymd($report_from_date)."' and '".dmyToymd($report_to_date)."' ";
										}
										else
										{
											$a = localtime();
											$a[4] += 1;
											$a[5] += 1900;
											$report_to_date2=$a[3]."/".$a[4]."/".$a[5];
											$report_from_date2="01/".$a[4]."/".$a[5];
											$view_report_query_2.=" and (act.logdate between '".dmyToymd($report_from_date2)."' "
																				." and '".dmyToymd($report_to_date2)."') ";
										}			
										$view_report_query_2.=" order by logdate asc ";



										if($sch_id=='all')       
										{
											$report_query=$view_report_query." UNION ALL ".$view_report_query_2;
											//echo "Report_query for ALL========= ".$report_query;
										}
										else if($sch_id=='nosch')
										{
											$report_query=$view_report_query_2;
											//echo "Report_query for Unschedule====== ".$report_query;
										}
										else
										{
											$report_query=$view_report_query;
											//echo "Report_query for schedule======= ".$report_query;
										}

												/*///////////////////////////////////////////////////////////////////////////////////*/
												/*//////////////////////////////////////////////////////////////////////////////////*/
												/*////////////////////////// work report////////////////////////////////////*/
												/*/////////////////////////////////////////////////////////////////////////////////*/
												/*/////////////////////////////////////////////////////////////////////////////////*/
														
																					

										$result_report_query = $GLOBALS['db']->query($report_query);//$result_report_query = $GLOBALS['db']->query($view_report_query);
										$employees="";
										$i=0;
										//echo "<br/><br/>". $view_report_query."<br/><br/>";
											if(isset($result_report_query) and $result_report_query->num_rows>0)	
											{
														$details.="<tr  >";  
														$details.="<td colspan='9'>";
														$details.="Work Reports ";
														$details.="</td>";
														$details.="</tr>";
														while($row = $result_report_query->fetch_assoc())
														{
														$i++;
														if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
														$details.="<tr ".$class.">";
														$details.="<td>";
														$details.=$i;
														$details.="</td>";
														$details.="<td nowrap >";
														if($row['super']) { $details.=ucwords($row['super']); } else { $details.="-"; }
														$details.="</td>";
														$details.="<td>";
														if($row['descri']!='') { $details.=ucwords($row['descri']); } else { $details.="-"; }
														$details.="</td>";
														$details.="<td>";
														$details.=ymdtodmy($row['logdate']);
														$details.="</td>";
														$details.="<td>";
														$details.=ucwords($row['actname']);
														$details.="</td>";
														$details.="<td>";
														$total_time0=$row['timespent']/60;
															$final0 = round($total_time0, 2);
														$details.=$final0." Hrs";
														$total_time=$total_time+$row['timespent'];
														$details.="</td>";
														$details.="<td align='left'>";
														$details.=ucwords($row['empactivitylog']);
														$details.="</td>";
														$details.="<td align='left'>";
														$details.=ucwords($row['sup1']);
														$details.="</td>";
														$details.="<td align='left'>";
														$details.=ucwords($row['sup2']);
														$details.="</td>";
														$details.="</tr>";
													}
												}
										else
										{
											$details.="<tr ><td colspan=\"9\">No  Reports Found !! </td></tr>";
										}
												//print $view_report_query;
												$details.="<tr ><th colspan=\"9\">*** </th></tr>";
}

		/*///////////////////////////////////////////////////////////////////////////////////*/
		/*///////////////////////////////////////////////////////////////////////////////////*/
		/*///////////////////////////////////////////////////////////////////////////////////*/
		/*///////////////////////////////////////////////////////////////////////////////////*/
		/*///////////////////////////////////////////////////////////////////////////////////*/
		/*///////////////////////////////////////////////////////////////////////////////////*/
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prime Move Technologies (P) Ltd.</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/saxan.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>
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


function checkall()
{
	//var datefrom = document.getElementById('from_date').value;
	//var dateto = document.getElementById('to_date').value;
	if(document.getElementById('emp').value==0)
	{
		alert("Please Select Employee");
		document.getElementById('emp').focus();
		return true;
	}
	
	/*if(compareDates(datefrom,'dd/mm/yyyy',dateto,'dd/mm/yyyy')!=true) 
	{		
		alert("Please enter From Date less than To Date !!");
		displayDatePicker('to_date');
		return true;
	}
	else
	{
		document.getElementById('empform').submit();
	}*/
	
	//date validation
	if(dateValidate('from_date','to_date')==true )
	{
		return true;
	}
	document.getElementById('empform').submit();
}
//function for date validation
function dateValidate(dateField1,dateField2)
{
  var retVal = false;
  dateValue1 = document.getElementById(dateField1).value;
  dateValue2 = document.getElementById(dateField2).value;
     
  //var dateObj = getFieldDate(dateValue);
  var today = new Date();
  today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

  if(dateValue1=='' || dateValue2=='')  {// Add one day schedule work if no date ranges selected
    
    
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
     
      if(dateObj1 > dateObj2 || dateObj1 == dateObj2 ){
         alert("To Date should be greater than From Date ");
         displayDatePicker(dateField2);
         retVal=true;
     
    }
  }
     //alert(retVal);
     return retVal;
}
//-->
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<form name="empform" id="empform" action="empreport.php" method="post">
<div id="main_div">
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" ">
<tr>
	<td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
</tr>

<tr>
	<td width="159" rowspan="2" align="left" valign="top"  class="menu_back">      
	<?php 
	$menu=show_menu();
	print $menu;
	?>      
	</td>
	<td width="100%" height="30" align="right" valign="top"  class="head_with_back_button">
	<?php
	 	if((isset($_POST['analyticreport'])) || ($_POST['flag_hidden']==1))	
	 {
		 print get_table_link("Analytics Report","veiwicon.jpg");
	 }else if((isset($_POST['getreport'])) || ($_POST['flag_hidden']==0)){
	print get_table_link("View Reports","veiwicon.jpg");
	}
	?>
	</td>
</tr>
<tr>
	<td  align="left" valign="top" bgcolor="#FFFFFF" height="585px">

	<table border="0" cellspacing="1" cellpadding="1" class="mainhead_content_table" width="100%">
		
		<tr>						
						<td width="28%">	
						<?php 
		if($sch_id=='all') { $ReportOf="All Reports of "; } else if($sch_id=='nosch') { $ReportOf="Unscheduled Reports of "; } else { $ReportOf="Scheduled Reports of ";}
						?>		
						
						<?php
						echo   $ReportOf.$emp_name_report_details." Between ".$report_from_date." To ".$report_to_date; 		
						?>			
						</td>
						<td width="21%">Select Employee:
						<?php
						$nemps="";											
						foreach(emp_list_after_reporting_to($_SESSION['USERID'],$emp_power) as $em){
							$nemps .=($nemps=="")? $em : ",".$em;
							}
							//$nemps=$emp_power['from_rep'];
							$emp_power['is_hod']=(intval($emp_power['from_rep'])>0)? 1 : 0;
							if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
							{													
									$view_emp_query="select "
																		." emp.employeeid as empid, "																		
																		." emp.fullname as fn "
																		
																." from "
																		." employee as emp 
																where 
																	emp.departmentid ='".$_SESSION['VDPRT']."' and	  emp.employeeid!='".$_SESSION['USERID']."' and  emp.employeeid >1 and  emp.employeeid in (".$nemps.")
																order by emp.fullname asc";
							}
							else if($emp_power['is_super'] =='1')
							{							
								$view_emp_query="select "
																		." emp.employeeid as empid, "																		
																		." emp.fullname as fn "
																	
																." from "
																		." schedule as sch, "
																		." schactivity as sact, "
																		." employee as emp "
																." where "
																		." sch.supervisorid ='".$_SESSION['USERID']."' "
																		." and sch.scheduleid=sact.scheduleid "
																		." and emp.employeeid!='".$_SESSION['USERID']."' "
																		." and emp.employeeid=sact.employeeid  and emp.employeeid >1 and emp.employeeid in (".$nemps.") "
																		." group by sact.employeeid "
																		." order by emp.fullname asc";
							}
							//echo $view_emp_query;
							$result = $GLOBALS['db']->query($view_emp_query);
			
							?>
							<select name="emp" id="emp" style="width:180px" title="select employee">
							<option value="0">select</option>
							<?php if($result->num_rows>0)
							{
								while($row = $result->fetch_assoc())
								{
									?>
									<option value="<?php echo $row['empid']; ?>"><?php echo $row['fn']; ?></option>
									<?php
								}
							} ?>
							</select>
							</td>
							<td width="15%">From:
							<input type="text"  id="from_date"  name="from_date" size="30px" maxlength="12" readonly="true" value="<?php echo $report_from_date; ?>" style="width: 85px;" /><img onclick="displayDatePicker('from_date');" value="select" src="images/cal.gif"/>
							</td>
							<td width="15%">To:
							<input type="text"  id="to_date"  name="to_date" size="30px" maxlength="12" readonly="true" value="<?php echo $report_to_date; ?>" style="width: 85px;" /><img onclick="displayDatePicker('to_date');" value="select" src="images/cal.gif"/>
							</td>
							<td colspan="4"  width="21%">
							<input type="button" name="btngo" id="btngo" value="GO" onclick="javascript:checkall();" />
							<!--Hidden value for schedule  -->
							<input type="hidden" name="sch_hidden" id="sch_hidden" value="<?php echo $sch_id;?>"/>
							<input type="hidden" name="flag_hidden" id="flag_hidden" value="<?php echo $flag;?>"/>
							</td>
						</tr>
						
				<?php
				//if((isset($_POST['getreport'])) || ($_POST['flag_hidden']==0))
				if(!((isset($_POST['analyticreport'])) || ($_POST['flag_hidden']==1)))
				{
			 ?>
						<tr>
							<td colspan="9" class="table_heading">
							Total Hours 
							<?php 
							$total_time=$total_time/60;
							$final = round($total_time, 2);
							print $emp_name_report_details." Worked Is ".$final." Hrs ".$from." ".$to;							
							?>
							</td>						
							</tr>
					<?php
				} ?>		
			</table>
			<?php
			if((isset($_POST['analyticreport'])) || ($_POST['flag_hidden']==1))
			{ 
				 ?>
								<table  border="2" cellspacing="1" cellpadding="1" class="main_content_table">							
									<tr>
										<th>
										Sl No:
										</th>
										<th>
										Schedule
										</th>										
										<th>
										Activity Type
										</th>
										<th>
										Hours
										</th>
									</tr>
								<?php  print ucwords($analytics);?>
								</td></tr>
								</table>
				 <?php 
				}
				else if((isset($_POST['getreport'])) || ($_POST['flag_hidden']==0))
				{
								 ?>
								<table  border="0" cellspacing="1" cellpadding="1" class="main_content_table">
									<tr>
										<th>
										Sl No:
										</th>
										<th>
										Assigned By
										</th>
										<th>
										Schedule
										</th>
										<th>
										Report Date 
										</th>
										<th>
										Activity Type
										</th>
										<th>
										Time Spent
										</th>
										<th>
										Report Details
										</th>
										<th>
										Comment To <?php print $emp_name_report_details;?>
										</th>
										<th>
										Comment To Admin
										</th>
									</tr>
								<?php  print ucwords($details);?>
								</td></tr>
								</table>
									<?php
				}
				 ?>
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
</form>
</body>
</center>
</html>
