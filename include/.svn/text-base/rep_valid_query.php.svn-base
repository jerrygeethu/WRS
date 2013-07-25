<?php 
// DATE_FORMAT(entrydatetime, '%d/%m/%Y - %r') as entry, 
function get_schedule_report()
{
	$target_path=getsettings('target_path_to_logFile')."/";	
	$emp_power = emp_authority($_SESSION['USERID']);
	$emp=$_SESSION['EMPRV1'];		
	$dpt=$_SESSION['DPTRV1'];	
	$schid=$_SESSION['SCH1'];
	
	
	$date=$_SESSION['RVDATE'];
	$to_date=$_SESSION['TODATE']; 
	//echo "emp=".$emp."</br>dep=".$dpt."</br>sch=".$schid."</br>f=".$date."</br>t=".$to_date."</br>";
	
	$e_query=" select fullname from employee where employeeid='".$_SESSION['EMPRV1']."' ";	
	$result_e = $GLOBALS['db']->query($e_query);
	$row_e = $result_e->fetch_assoc();
	
	if($schid>0)
	{
		$sch_report1="<div class=\"odd\">&nbsp;</div><div id=\"sch_report\"  name=\"sch_report\" >
		
										<table border=\"0\"cellspacing=\"2px\" width=\"100%\" class=\"main_content_table\">
										 <tr><td colspan=\"6\" class=\"table_heading\"> Scheduled Work Report </td></tr>
										    <tr>
										        <th>
										        Sl No:
										        </th>
										        <th>
										        Schedule Details
										        </th>
										        <th>
										        Schedule Description
										        </th>
										        <th>
										        Work Report
										        </th>
										        <th>
										        Comment To ".ucwords($row_e['fullname'])."
										        </th>
										        <th>
										        Comment To Admin
										        </th>
										    </tr>
										";
										
						$enter_report_query="select 
													sa.schactivityid as actid,
													sa.activitydesc as actdesc,
													sa.activitystatus as actstatus,
													sa.activitytypeid as acttypeid,
													s.description as sc_desc,
													s.supervisorid as sc_super,
													e.fullname as fullname
												from 
													schedule as s,
													schactivity as sa,
													employee as e		
												where
													s.scheduleid=sa.scheduleid
													and
													sa.employeeid=e.employeeid
													and													
													sa.employeeid='".$emp."'
													and
													s.scheduleid='".$schid."'
													and
													s.departmentid='".$dpt."'	
						
						 ";
						$sch_report1.=get_table($enter_report_query);
						print $sch_report1;
						
						
						/*$enter_report_query =  " 	select 
															sa.schactivityid as actid,
															sa.activitydesc as actdesc,
															sa.activitystatus as actstatus,
															sa.activitytypeid as acttypeid,
															s.description as sc_desc,
															s.supervisorid as sc_super,
														    e.fullname as fullname
														from 
															schedule as s,
															schactivity as sa,
															employee as e															
														 ";														
														
							$enter_report_query .=  " where  sa.scheduleid=s.scheduleid 															
														and sa.employeeid!=".$_SESSION['USERID']." and sa.employeeid=e.employeeid 
														and 
														sa.employeeid='".$emp."'		
														and 														
														s.departmentid = '".$dpt."' ";														
						if(($emp_power['is_superadmin']!=1)&&($emp_power['is_admin']!=1)&&($emp_power['is_hod']!=1)&&($emp_power['is_super']==1))
												{
													$enter_report_query.="  and  sa.scheduleid in  (".$emp_power['issup_schid'].") ";
												}
												$enter_report_query.="  and sa.employeeid = e.employeeid";
*/		
// echo   "<br/><br/>hh==".$enter_report_query."<br/><br/>";   
		
		
														
			#############################################################################								
			//$sch_report.=get_table($enter_report_query);
			#############################################################################														
			//$sch_report.="<tr><th colspan=\"6\"> ww*** </th></tr> ";
	}
	else if($schid=='unsch')
	{	
		$sch_report="";
		if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
		{
			//show miscellineous work report
			$sch_report.="<table border=\"0\"cellspacing=\"2px\" width=\"100%\" class=\"main_content_table\">
			<tr><td colspan=\"6\" class=\"table_heading\">Unscheduled Work Report</td></tr>
			<tr>
			<th>
			Sl No:
			</th>
			<th>
			Schedule Details
			</th>
			<th>
			Schedule Description
			</th>
			<th>
			Work Report
			</th>
			<th>
			Comment To ".ucwords($row_e['fullname'])."
			</th>
			<th>
			Comment To Admin
			</th>
			</tr>";
			
			$select_misc_report_query = " select 
													 act.activitylogid as logid,
													 act.activitytypeid as type,
													DATE_FORMAT( act.entrydatetime, '%d/%m/%Y - %r') as entry ,												
													 act.timespent as time,
													 act.empactivitylog as emplog,
													 act.loglock as loglock,
													 t.activityname as actname,
													 act.supremarks1 as sup1,
													 act.supremarks2 as sup2,
													 e.fullname,
													 act.filename,
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
													sact.employeeid='".$emp."' 
													and
													act.logdate>='".$date."'
													and 
													act.logdate<='".$to_date."'
													and 
													sact.scheduleid is NULL 
													and 
													act.activitytypeid=t.activitytypeid";
		
			//echo "<br/><br/> ".$select_misc_report_query." +++++++++++";
			$result_misc_report = $GLOBALS['db']->query($select_misc_report_query);	
			$act_log="";
			if(isset($result_misc_report) and $result_misc_report->num_rows>0)
			{	
				$i=0;			
				while($row_misc = $result_misc_report->fetch_assoc())
				{
					//$i=$_SESSION['NO'];
					$i++;						
					$report=$row_misc['emplog'];
					$time=round(($row_misc['time']/60) ,2);
					$_SESSION['VMTIME']=$_SESSION['VMTIME']+$row_misc['time'];
					$act_name=$row_misc['actname'];
					$com_to_emp=$row_misc['sup1'];
					$com_to_adm=$row_misc['sup2'];
					$activitylogid=$row_misc['logid'];
					$lock=$row_misc['loglock'];
					$empName=$row_misc['fullname'];
					$log_date=ymdToDmy($row_misc['logdate']);				
					$time_entered=" Entered at: ".$row_misc['entry']." ";
					if(($lock==0)||($lock ==""))$btn_show="Lock";else $btn_show="Unlock";
					if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
					$sch_report.="
					<tr ".$class.">
					<td width=\"2%\">".$i."</td>
					<td>		        
					Activity type:".ucwords($act_name)."<br/>
					[Eneterd for:".$log_date."]		        
					</td>
					<td>
					Miscellaneous Work
					</td>
					<td>
					<div>
					Report of :".ucwords($empName)."<br/>
					".ucwords($report)."<br/>";
					if($row_misc['filename']!="")	
					{	
						$sch_report.="<div>File: <a href=\"".$target_path."".$row_misc['filename']."\" target=\"_blank\">".$row_misc['filename']."</a></div>";
					}
					$sch_report.="</div>";
					
					$sch_report.="
					<div class=\"save_btn\">
					<br/><br/>
					Time Spent:".$time."Hrs <br/>
					".$time_entered."<br/>
				   
					<form method=\"post\" id=\"lock_report\" name=\"lock_report\" action=\"rep_valid.php\" >
					<input type=\"hidden\" value=\"".$activitylogid."\" id=\"act_log_id\" name=\"act_log_id\" />
					
					
					
				<input type=\"hidden\" value=\"". $_SESSION['DPTRV1']."\" name=\"dept_drop_down\"  id=\"dept_drop_down\"/>	
				<input type=\"hidden\" value=\"". $_SESSION['SCH1']."\"  name=\"sch_drop_down\" id=\"sch_drop_down\"/>	
				<input type=\"hidden\" value=\"". $_SESSION['EMPRV1']."\" name=\"emp_drop_down\"  id=\"emp_drop_down\"/>		
					
					
					
					
					<input type=\"submit\"  class=\"s_bt\" title=\"Click To ".$btn_show." Report \"  value=\"".$btn_show."\" name=\"lock_btn\" id=\"lock_btn\"/>
					</form>
					</div>";
						
					$sch_report.="
					</td>
					<td>";
					$sch_report.="
				   <textarea name=\"".$activitylogid."-com2emp\" id=\"".$activitylogid."-com2emp\" >".ucwords($com_to_emp)."</textarea>
				   <div class=\"save_btn\">
				   <div id=\"".$activitylogid."-2emp\" name=\"".$activitylogid."-2emp\"></div>
				   <input type=\"button\" class=\"s_bt\"  title=\"Click To Save Comment\"  class=\"s_bt\"  value=\"Save\"  name=\"com_to_emp\" id=\"com_to_emp\" onclick=\"javascript:insert_emp_comment('".$activitylogid."','emp');\"  />
				   </div>";
				   
				   $sch_report.="
					</td>
					<td>";
					$sch_report.="
				   <textarea name=\"".$activitylogid."-com2adm\" id=\"".$activitylogid."-com2adm\">".ucwords($com_to_adm)."</textarea>
				   <div class=\"save_btn\">
					<div id=\"".$activitylogid."-2adm\" name=\"".$activitylogid."-2adm\"></div>
				   <input type=\"button\" class=\"s_bt\"  title=\"Click To Save Comment\"  value=\"Save\"  name=\"com_to_adm\" id=\"com_to_adm\"  onclick=\"javascript:insert_emp_comment('".$activitylogid."','adm');\"  />
				   </div>";
					 
					$sch_report.="
					</td>
					</tr>
					";		
					$_SESSION['NO']=$i;	
				}// while loop
			}//if loop
			else
			{	
				$sch_report.="<tr><td colspan=\"6\" class=\"warn\"> No Reports Found </th></tr>";
			}	
			$sch_report.=" <tr>
			<td  colspan=\"6\" align=\"right\"  id=\"time_message\">Spent :";
			$tt=round($_SESSION['VMTIME']/60,2);
			$sch_report.= $tt." Hrs For Scheduled Work
			</td></tr>";				
		}
		$sch_report.="
		<tr>
		<td  colspan=\"6\" align=\"right\" id=\"time_message\">Total Time Worked :";			  
		$_SESSION['VTTIME']=$_SESSION['VMTIME']+$_SESSION['VSTIME'];
		$tt=round($_SESSION['VTTIME']/60,2);
		$sch_report.= $tt." Hrs 
		</td>
		</tr>
		<tr><th colspan=\"6\">***</th></tr></table></div>";
		return $sch_report;
	}
}



// ******************************************************************************
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************


						//function for scheduled reports
						
function get_table($enter_report_query)
{
	$target_path=getsettings('target_path_to_logFile')."/";	
	$emp_power = emp_authority($_SESSION['USERID']);
	$emp=$_SESSION['EMPRV1'];
	$dpt=$_SESSION['DPTRV1'];
	$date=$_SESSION['RVDATE'];
	$to_date=$_SESSION['TODATE'];
	$_SESSION['NO']=0;	
	//echo $enter_report_query;														
	$result_report_query = $GLOBALS['db']->query($enter_report_query);
		
		if(isset($result_report_query) and $result_report_query->num_rows>0) {
		//$i=0;
		
		while($row_report_query = $result_report_query->fetch_assoc()) {

		
		
		$act_log_query=" select 
													l.activitylogid,	
													l.activitytypeid,
													l.schactivityid,
												 	DATE_FORMAT(entrydatetime, '%d/%m/%Y - %r') as entry, ";
													//l.entrydatetime as entry,
													$act_log_query.="DATE_FORMAT(l.logdate,'%Y-%m-%d') as logdate,
													l.timespent,
													l.empactivitylog,
													l.supremarks1,
													l.supremarks2,
													e.title,
													e.fullname,
													l.loglock,
													t.activityname,
													l.filename
										from 
													activitylog as l,
													activitytype as t,
													employee as e
										where 
												l.schactivityid='".$row_report_query['actid']."'
										and
												l.logdate>='".$date."'
										and 
												e.employeeid='".$row_report_query['sc_super']."' 
										and
												l.logdate<='".$to_date."'
												
										and t.activitytypeid=l.activitytypeid ";
		
		
		
		//l.logdate like '".$date."%'
		//echo  "==========<br/><br/>".$act_log_query."<br/><br/>==========";
		//echo  "==========<br/><br/>".$act_log_query."<br/><br/>==========";
		$result_act_log_query = $GLOBALS['db']->query($act_log_query);
		
			
		if(isset($result_act_log_query) and $result_act_log_query->num_rows>0)
		{		
					
			while($row_act_log = $result_act_log_query->fetch_assoc())
			{
				$i++;
				$report=$row_act_log['empactivitylog'];
				$time=round(($row_act_log['timespent']/60) ,2);
				$_SESSION['VSTIME']=$_SESSION['VSTIME']+$row_act_log['timespent'];
				$act_name=$row_act_log['activityname'];
				$com_to_emp=$row_act_log['supremarks1'];
				$com_to_adm=$row_act_log['supremarks2'];
				$activitylogid=$row_act_log['activitylogid'];
				$lock=$row_act_log['loglock'];	
				$log_date=ymdToDmy($row_act_log['logdate']);
			 $time_entered=" Entered at: ".$row_act_log['entry']."  "; 
			if(($lock==0)||($lock ==""))
			$btn_show="Lock";else $btn_show="Unlock";
			
			if(($i%2)>0) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
			
			$sch_report.="
		     <tr ".$class.">
		        <td width=\"2%\">".$i."</td>
		        <td>
		        Status:
		        ".ucwords($row_report_query['actstatus'])."<br/><br/>
		        Assigned By:
		        ".ucwords($row_act_log['fullname'])."
		       <br/><br/>
		        Activity type:".ucwords($act_name)."<br/>
				[Entered for:".$log_date."]
		        
		        </td>
		        <td>
		        Schedule:
		        ".ucwords($row_report_query['sc_desc'])."<br/><br/>
		        
		        Schedule Activity:
		        ".ucwords($row_report_query['actdesc'])."
		        </td>
		        <td>
		        <div>
		        Report of:
		        ".ucwords($row_report_query['fullname'])."<br/>
		        ".ucwords($report)."<br/>";
				if($row_act_log['filename']!="")
				{
				$sch_report.="<div>File: <a href=\"".$target_path."".$row_act_log['filename']."\" target=\"_blank\">".$row_act_log['filename']."</a></div>";
				}
		        $sch_report.="</div>";
		      
		        if(isset($result_act_log_query) and $result_act_log_query->num_rows>0) {
		        $sch_report.="
		        <div class=\"save_btn\">
		         <br/><br/>
		       Time Spent:".$time."Hrs <br/>
		       ".$time_entered."<br/>
		         <form method=\"post\" id=\"lock_report\" name=\"lock_report\" action=\"rep_valid.php\" >
		        <input type=\"hidden\" value=\"".$activitylogid."\" id=\"act_log_id\" name=\"act_log_id\" />
						
						<input type=\"hidden\" value=\"". $_SESSION['DPTRV1']."\" name=\"dept_drop_down\"  id=\"dept_drop_down\"/>	
				<input type=\"hidden\" value=\"". $_SESSION['SCH1']."\"  name=\"sch_drop_down\" id=\"sch_drop_down\"/>	
				<input type=\"hidden\" value=\"". $_SESSION['EMPRV1']."\" name=\"emp_drop_down\"  id=\"emp_drop_down\"/>	
						
						
						
		        <input type=\"submit\"  class=\"s_bt\"  title=\"Click To ".$btn_show." Report\" value=\"".$btn_show."\" name=\"lock_btn\" id=\"lock_btn\"/>
		        </form>
		        </div>";
					}
					
					
		        $sch_report.="
		        </td>
		        <td>Comment To : ".$row_report_query['fullname']."</br>";
				
// The above lines edited by hmrsqt at gmail dot com - for showing user name who enter each reports Tuesday, October 20 2009
		         if(isset($result_act_log_query) and $result_act_log_query->num_rows>0)
				 {
						  
							 /* 
							 
							  <textarea name=\"".$activitylogid."-com2emp\" id=\"".$activitylogid."-com2emp\" >".ucwords($com_to_emp)."</textarea>
				   <div class=\"save_btn\">
				   <div id=\"".$activitylogid."-2emp\" name=\"".$activitylogid."-2emp\"></div>
				   <input type=\"button\" class=\"s_bt\"  title=\"Click To Save Comment\"  class=\"s_bt\"  value=\"Save\"  name=\"com_to_emp\" id=\"com_to_emp\" onclick=\"javascript:insert_emp_comment('".$activitylogid."','emp');\"  />
				   </div>
						 
						 
						 
							 <textarea name=\"".$activitylogid."-com2adm\" id=\"".$activitylogid."-com2adm\">".ucwords($com_to_adm)."</textarea>
				   <div class=\"save_btn\">
					<div id=\"".$activitylogid."-2adm\" name=\"".$activitylogid."-2adm\"></div>
				   <input type=\"button\" class=\"s_bt\"  title=\"Click To Save Comment\"  value=\"Save\"  name=\"com_to_adm\" id=\"com_to_adm\"  onclick=\"javascript:insert_emp_comment('".$activitylogid."','adm');\"  />
				   </div>";
						 */
					$sch_report.="
				   <textarea name=\"".$activitylogid."-com2emp\" id=\"".$activitylogid."-com2emp\">".ucwords($com_to_emp)."</textarea>
				   <div class=\"save_btn\">
						 <div id=\"".$activitylogid."-2emp\" name=\"".$activitylogid."-2emp\"></div>
				   <input type=\"button\" class=\"s_bt\"  title=\"Click To Save\"  value=\"Save\"  name=\"com_to_emp\" id=\"com_to_emp\"  onclick=\"javascript:insert_emp_comment('".$activitylogid."','emp');\" />
				   </div>";
		       }
		       $sch_report.="
		        </td>
		        <td>";
		         if(isset($result_act_log_query) and $result_act_log_query->num_rows>0) {
						 
		        $sch_report.="
		       <textarea  name=\"".$activitylogid."-com2adm\" id=\"".$activitylogid."-com2adm\">".ucwords($com_to_adm)."</textarea>
		       <div class=\"save_btn\">
		        <div id=\"".$activitylogid."-2adm\" name=\"".$activitylogid."-2adm\"></div>
		       <input type=\"button\" class=\"s_bt\" title=\"Click To Save\" value=\"Save\"  name=\"com_to_adm\" id=\"com_to_adm\"  onclick=\"javascript:insert_emp_comment('".$activitylogid."','adm');\" />
		       </div>";
				 }
		       $sch_report.="
		        </td>
		    </tr>
		
		
		";
		
		}// while loop
		$_SESSION['NO']=$i;
		}
		else
		{
			/*
			sa.schactivityid as actid,
															sa.activitydesc as actdesc,
															sa.activitystatus as actstatus,
															sa.activitytypeid as acttypeid,
															s.description as sc_desc,
															s.supervisorid as sc_super
															* $row_report_query['actid'] */
			$act_name_query="select activityname from activitytype where activitytypeid='".$row_report_query['acttypeid']."'";
			$r = $GLOBALS['db']->query($act_name_query);
			$rg = $r->fetch_assoc();
			$report="No Data";
			$time="No Data";
			$act_name=$rg['activityname'];
			$com_to_emp="No Data";
			$com_to_adm="No Data";
			$activitylogid="No Data";
			$lock="";
			if(($lock==0)||($lock ==""))
				$btn_show="Lock";else $btn_show="Unlock";
		}
	// super visor name
		
	}// while loop
	$sch_report.=" <tr>
				 <td  colspan=\"6\" align=\"right\"  id=\"time_message\">Spent :";
       $tt=round($_SESSION['VSTIME']/60,2);
      $sch_report.= $tt." Hrs For Scheduled Work
      </th></tr>";
}// if loop
else{
	$sch_report.="<tr><td colspan=\"6\" class=\"warn\"> No Reports Found </th></tr>";
	$_SESSION['NO']=0;
}
$sch_report.="<tr><th colspan=\"6\"> *** </th></tr> ";
return $sch_report;
}
?>
