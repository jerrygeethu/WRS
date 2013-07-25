<?php 



$report_query =  " select "
																." sca.schactivityid as one, "
																." sca.activitytypeid as two, "
																." sch.supervisorid as three, "
																." sca.scheduleid as four, "
																." sca.activitydesc as five , "
																." sca.activitycomment as six , "
																." sca.activitystatus as seven, "
																." sch.description as eight "
														." from "
																." schactivity as sca, "
																." schedule as sch  "
														." where "
															."  ( sca.activitystatus = 'running' OR sca.activitystatus = 'pending') "
															." and sca.employeeid='".$_SESSION['USERID']."' "
															//." and sca.activityfromdate<='".$date_format."'  "
															//." and sca.activitytodate>='".$date_format."' "
															//." and sca.scheduleid=sch.scheduleid "
															." ";
															
															
$misc_report_query = " select "
																." act.activitylogid as logid, "
																." act.activitytypeid as type, "
																." act.timespent as time, "
																." act.empactivitylog as emplog, "
																." act.loglock as loglock, "
																." act.supremarks1 as sup1 "
															." from  "
																." activitylog as act, "
																." schactivity as sact "
															." where "
																." sact.schactivityid=act.schactivityid "
																." and "
																." sact.employeeid='".$_SESSION['USERID']."' "
																." and "
																." act.logdate like '".$date_format."%' "
																." and "
																." sact.scheduleid is NULL ";
															
															
															
															
															
															
															
															
															
															
															
															
															
															
															
															
															
															
?>
