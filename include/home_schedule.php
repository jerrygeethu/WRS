<?php 
if(isset($_POST['get_sch_date'])){
	$date=$_POST['get_sch_date'];
	
	
$from_date_show_sch=dmytoymd($date);
$to_date_show_sch=dmytoymd($date);
}else{
$from_date_show_sch=date('Y-m-d');
$to_date_show_sch=date('Y-m-d');
}

// if today
 $sch_query = " select "
													." sca.schactivityid as actid, "
													." sca.activitytypeid as type, "
													." sca.scheduleid as schid, "
													." sch.supervisorid as supid, "
													." sca.activitydesc as descr , "
													." sca.activitycomment as coment , "
													." sca.activitystatus as status, "
													." emp.fullname as sup, "
													." sch.description as schdescr "
							        ." from "
							            ." schactivity as sca, "
							            ." employee as emp, "
							            ." schedule as sch  "
							        ." where "
							        	."  ( sca.activitystatus = 'running' OR sca.activitystatus = 'pending') "
						  	        ." and sca.employeeid='".$_SESSION['USERID']."' "
						  	        ." and sca.activityfromdate<='".$from_date_show_sch."'  "
	          						." and sca.activitytodate>='".$to_date_show_sch."' "
	          						." and  sca.scheduleid=sch.scheduleid 
	          						and  emp.employeeid=sch.supervisorid ";
	          						
	          						
	          						
	          						
function get_schedules($sch_query,$date){
$result = $GLOBALS['db']->query($sch_query);
	$i=0;
	if(isset($result) and $result->num_rows>0) {
		while($row = $result->fetch_assoc()) {
						//print_r($row);
						$i++;
						
						if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
						$sche.="<div>
						<table  width=\"100%\"  height=\"50px\" >
						    <tr".$class.">
						        <td width=\"50px\" align=\"center\">
						        <label>".$i."</label>
						        </td>
						        <td   width=\"250px\" valign=\"middle\">
						        <label>Assigned By: </label>".$row['sup']."
						        </td>
						        <td width=\"250px\" valign=\"middle\">
						        <label>Schedule: </label>".ucwords($row['schdescr'])."
						        </td>
						        <td>
						        <label>Description: </label>".ucwords($row['descr'])."
						        </td>
						    </tr>
						</table>
						</div><br/>";
						
						
					}// while loop
				}// if loop
				else{
					//$sche="<div class=\"warn\">No Scheduled Work for ".ymdtodmy($date)."</div>";
					$sche="";
				}
				
				
				
				return array($sche,$i);
			}// function closing
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
function three_days_before_today($fyear, $fmonth, $fday)
{
	//return date ("Y-m-d", mktime (0,0,0,$fmonth,$fday-1,$fyear));	
	for($i=1;$i<=3;$i++)
	{
		$arr_date[$i]=date ("Y-m-d", mktime (0,0,0,$fmonth,$fday-$i,$fyear));		
	} 
	return $arr_date;									
}		
//function to get missed daily report
function missed_daily_report()
{

	$current_date=date('Y/m/d');									
	$arr=explode("/",$current_date);
	$fyear=$arr[0];
	$fmonth=$arr[1];
	$fday=$arr[2];
	$get_three_dates1=three_days_before_today($fyear, $fmonth, $fday);
	$get_three_dates=array_reverse($get_three_dates1, true);
				$query="SELECT distinct DATE_FORMAT(act.logdate,'%Y-%m-%d') as logdate								
								from 
									activitylog as act,
									schactivity as sact									
								where 
									sact.schactivityid=act.schactivityid 	
									AND
									DATE_FORMAT(act.logdate,'%Y-%m-%d')  BETWEEN  DATE_SUB(CURDATE(), INTERVAL 4 DAY)								
									AND
									CURDATE()
									AND
									sact.employeeid=".$_SESSION['USERID']."									
									";							
									//echo $query."<br/><br/>";
									
									$result= $GLOBALS['db']->query($query);																											
									if($result->num_rows>0)
									{
										
										$i=0;
										while($row_misc = $result->fetch_assoc())
										{											
											$arr_logdates[$i]=$row_misc['logdate'];
											$i++;
										}

										if($arr_logdates)
										{
											$arr_missed_dates=array_diff($get_three_dates,$arr_logdates);
										}
										//print_r($arr_missed_dates);	
											
										if(count($arr_missed_dates)==0)
										{
											$missed_reports=" ";
										}
										else
										{							
											$missed_reports="You have missed reports on ";									
											$sh="";
											foreach($arr_missed_dates as $d)
											{
												if (date("l", strtotime($d)) != 'Sunday')
												{
																		$checkleaveday="select l.leaveapplicationid,l.employeeid from leaveapplication l where l.fromdate<='".$d."' 																		 and l.todate>='".$d."'  and l.sanctioned=1 and l.cancelled=0 and l.employeeid=".$_SESSION['USERID']."																										 																			";
																		//echo "<br/><br/>";
																		$resultleaveday= $GLOBALS['db']->query($checkleaveday);
																		if($resultleaveday->num_rows==0)//not  a leave day
																		{
																			if($sh!="") $sh.=", ";
																			$sh.=ymdtodmy($d);
																		}
												}
											}
											if ($sh!="")
											{																																								
												$missed_reports.="<a href=\"report.php?home=".$sh."\">".$sh."</a>";																								
											}
											else
											{
												$missed_reports="";
											}
										}
									}
									else
									{	
										//																	
										$show="";
										foreach($get_three_dates as $d)
										{
											if(date("l", strtotime($d)) != 'Sunday')
											{
												$checkleave="select l.leaveapplicationid,l.employeeid from leaveapplication l where l.fromdate<='".$d."' 																		 and l.todate>='".$d."'  and l.sanctioned=1 and l.cancelled=0 and l.employeeid=".$_SESSION['USERID']."	";	
												$resultcheckleave=$GLOBALS['db']->query($checkleave);
												if($resultcheckleave->num_rows==0)//not  a leave day
												{
													if($show!="") $show.=", ";
													$show.=ymdtodmy($d);
												}
											}
										}
										//$missed_reports="<a href=\"report.php\">You have missed 3 Daily Reports</a>";
										if ($show!="")
										{																																								
											$missed_reports="You have missed reports on <a href=\"report.php?home=".$show."\">".$show."</a>";																								
										}
										else
										{
											$missed_reports="";
										}
									}
									return $missed_reports;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function for finding missed validate reports
function missed_validate_report($emp_power)
{
	//old code
	//get reports for 7 days for which  report is not validated
	/*$query="SELECT 
			DATE_FORMAT(logdate,'%Y-%m-%d') as logdate,loglock
			FROM
			schedule,schactivity,activitylog
			WHERE
			schedule.scheduleid=schactivity.scheduleid
			AND
			activitylog.schactivityid=schactivity.schactivityid
			AND
			schedule.`supervisorid`=".$_SESSION['USERID']."
			AND 
			loglock=0
			AND 
			DATE_FORMAT(logdate,'%Y-%m-%d')  BETWEEN  DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
			AND
			CURDATE()
			";*/
			//echo $query;																				
			/*		$result= $GLOBALS['db']->query($query);
			if($result->num_rows>0)
			{
				
				$j=0;
				while($row_misc = $result->fetch_assoc())
				{											
					$arr_logdates[$j]=$row_misc['logdate'];
					$j++;
				}
			
			
				if($arr_logdates)
				{
					$arr_missed_dates1=array_unique($arr_logdates);
					$arr_missed_dates=array_reverse($arr_missed_dates1);
				}
			
				if(count($arr_missed_dates)==0)										
				{
					$missed_reports="";
				}
				else
				{
					$missed_reports="You have missed to validate reports on ";									
					$sh="";
					foreach($arr_missed_dates as $d)
					{
						if($sh!="") $sh.=", ";
						$sh.=ymdtodmy($d);													
					}										
					$missed_reports.="<a href=\"rep_valid.php\">".$sh."</a>";	
				}								
			}
			return $missed_reports;*/
	////////////////////////////////////////////////////////////////
	//Get Miscellaneous reports
			//Get dept id  miscellaneous work report            
			if($emp_power['is_admin'] =='1')
			{
				$dept=$emp_power['isadm_deptid'];
			}
			else if($emp_power['is_hod'] =='1')
			{
				$dept=$emp_power['ishod_deptid'];
			}
			$_SESSION['dept']=$dept;

			//miscellaneous work report
			$select_misc_report_query = " select distinct
																 e.fullname,														
																  DATE_FORMAT(act.logdate,'%Y-%m-%d') as logdate															 
															 from 
																 activitylog as act,
																 schactivity as sact,
																 activitytype as t,
																 employee as e
															 where
															 sact.schactivityid=act.schactivityid
															 and 
															  sact.employeeid=e.employeeid
															  and
															  sact.employeeid!='".$_SESSION['USERID']."'
															 and
															  e.departmentid in (".$dept.") 
															 and 
															  sact.scheduleid is NULL 
															 and 
															  act.loglock=0
															 and
															  act.activitytypeid=t.activitytypeid
															 and e.empstatus='active' order by act.logdate";	
										  if(($emp_power['is_admin'] =='1') ||($emp_power['is_hod'] =='1')) // misc reports only  for admin or hod 
										  {				  																		
											$result= $GLOBALS['db']->query($select_misc_report_query);
											$count=$result->num_rows;	
											if($count>0)										
											{
												$view_misc="<div class=\"scheduled_work\">
														<label>You have missed to validate ".$count." miscellaneous reports</label>
														<a href=\"#\" onclick=\"showHideDiv('div1')\">Details</a>
														</div><br/>
														<div id=\"div1\" class=\"divStyle\">";
														//Show Hide Div visibility using Javascript DOM.
														while($row_misc = $result->fetch_assoc())	
														{
															$logdate=$row_misc['logdate'];													
															$view_misc.=$row_misc['fullname']."  : ".ymdTodmy($logdate)."<br/>";
														}									
													$view_misc.="</div>";										
												echo $view_misc;
											}
										}
		//Get 	scheduled work report
		if($emp_power['issup_schid']) //login as supervisor of schedules
		{
			 $select_sch_report_query="select distinct
									s.scheduleid,
									s.departmentid,
									s.supervisorid,							
									act.schactivityid,
									 DATE_FORMAT(act.logdate,'%Y-%m-%d') as logdate,
									e.fullname							
								from
									schedule as s,
									schactivity as sa,
									activitylog as act,
									employee as e							
								where
									s.scheduleid in (".$emp_power['issup_schid'].") 
									and
									s.scheduleid=sa.scheduleid							
									and
									sa.schactivityid=act.schactivityid	
									and
									sa.employeeid=e.employeeid	
									and
									sa.employeeid!='".$_SESSION['USERID']."'
									and
									act.loglock=0
									and e.empstatus='active' order by logdate
									";								
						$result1= $GLOBALS['db']->query($select_sch_report_query);
						$count1=$result1->num_rows;
						if($count1>0)					
						{
							$view_sch="<div class=\"scheduled_work\">
										<label>You have missed to validate ".$count1." scheduled reports</label>
										<a href=\"#\" onclick=\"showHideDiv('div2')\">Details</a>
										</div><br/>										
												<div id=\"div2\" class=\"divStyle\">";
												//Show Hide Div visibility using Javascript DOM.
												while($row_sch = $result1->fetch_assoc())	
												{
													$logdate=$row_sch['logdate'];													
													$view_sch.=$row_sch['fullname']."  : ".ymdTodmy($logdate)."<br/>";
												}									
											$view_sch.="</div>";	
							echo $view_sch;		
						}	
		}								
		//Get supervisor's	 reports           
		if(($emp_power['is_hod'] =='1')|| ($emp_power['is_admin'] =='1'))//login as HOD or admin
		{
			 $select_superv_report_query="select distinct
									s.scheduleid,
									s.departmentid,
									s.supervisorid,							
									act.schactivityid,
									 DATE_FORMAT(act.logdate,'%Y-%m-%d') as logdate,
									e.fullname							
								from
									schedule as s,
									schactivity as sa,
									activitylog as act,
									employee as e							
								where
									e.departmentid in (".$dept.") 
									and
									s.scheduleid=sa.scheduleid							
									and
									s.supervisorid=sa.employeeid
									and
									sa.schactivityid=act.schactivityid	
									and
									sa.employeeid=e.employeeid	
									and
									sa.employeeid!='".$_SESSION['USERID']."'
									and
									act.loglock=0
									and e.empstatus='active' order by logdate
									";	
						$result_superv= $GLOBALS['db']->query($select_superv_report_query);
						$count_superv=$result_superv->num_rows;
						if($count_superv>0)					
						{
							$view_superv="<div class=\"scheduled_work\">
										<label>You have missed to validate supervisor's reports for ".$count_superv." days</label>
										<a href=\"#\" onclick=\"showHideDiv('div3')\">Details								
										</a>
										</div><br/>
											<div id=\"div3\" class=\"divStyle\">";
												//Show Hide Div visibility using Javascript DOM.
												while($row_superv = $result_superv->fetch_assoc())	
												{
													$logdate=$row_superv['logdate'];													
													$view_superv.=$row_superv['fullname']."  : ".ymdTodmy($logdate)."<br/>";
												}									
											$view_superv.="</div>";																	
										
							echo $view_superv;		
						}					
		}
								
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//function for upcoming birthday
function getBdayLimit($period=7)
{
	for($i=0;$i<=$period;$i++)
	{
		$data[$i]=date ("m-d", mktime (0,0,0,date('m'),date('d')+$i,date('Y')));		
	} 
	return $data;	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
//Function to get absentees
function getAbsentees()
{
	$permissionID=getsettings('permissionid');
	$today=date("Y-m-d");
 	$query="select  distinct
					l.leaveapplicationid,
					l.leavetypeid,
					e.fullname,
					DATE_FORMAT(l.fromdate,'%Y-%m-%d') as fromdate,
					DATE_FORMAT(l.todate,'%Y-%m-%d') as todate,
					l.fromoption,
					l.tooption,
					l.leavedays
				from
					leaveapplication l,
					employee e
				where
					l.employeeid=e.employeeid 
					and
					((DATE_FORMAT(l.fromdate,'%Y-%m-%d')<='".$today."' and DATE_FORMAT(l.todate,'%Y-%m-%d')>='".$today."') or (DATE_FORMAT(l.fromdate,'%Y-%m-%d')='".$today."'))
					and
					l.sanctioned=1		
					and
					l.cancelled=0	
					and 
					l.leavetypeid!='".$permissionID."'	
				";
		$result=$GLOBALS['db']->query($query);
		if($result->num_rows>0)
		{
	
			$view="<div class='scheduled_work'><label>Todays Absentees:</label>
			<a href=\"#\" onclick=\"showHideDiv('div4')\">Details								
			</a>
			</div><br/>
			<div id=\"div4\" class=\"divStyle1\">";
			while($row = $result->fetch_assoc())
			{
				$view.=$row['fullname']."  ";	
				$fromdate=$row['fromdate'];
				$todate=$row['todate'];
				$fromoption=$row['fromoption'];
				$tooption=$row['tooption'];
				
				if($fromdate==$today)
				{
						if($fromoption=="first"){$view.="(first half day)";} elseif($fromoption=="second") {$view.="(second half day)";}
				}
				else if($todate==$today)
				{
						if($tooption=="first"){$view.="(first half day)";} elseif($tooption=="second") {$view.="(second half day)";}
				}
				$view.="<br/>";
			}
			$view.="</div>";
		}
		return $view;				
}
?>
