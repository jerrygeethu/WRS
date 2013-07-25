<?php
function get_report_view($data){
	$target_path=$data['target_path'];
	$fileSize=$data['fileSize'];
	$date_sql=dmytoymd($_SESSION['REP_DATE']);
	//$fileSize=100000;
	$data="";
  				$reportViewQuery = " 
																								SELECT 
																																						l.activitylogid,
																																						 l.logdate,
																																						 l.timespent,
																																						 l.fromtime,
																																						 l.empactivitylog,
																																						 l.supremarks1, 
																																						 l.loglock,
																																						 l.entrydatetime,
																																						 l.filename,
																																					 	 sa.schactivityid,
																																						 sa.activitytypeid,
																																						 sa.activitydesc,
																																						 sa.emplcomment,
																																						 sa.scheduleid,
																																						 sa.activitystatus,
																																						 sa.activitycomment,
																																						s.description, 
																																						e.fullname as supervisor,
																																						e.title,
																																						act.activityname
																													FROM 
																																						activitytype as act,
																																						schactivity as sa
																													JOIN 
																																						activitylog as l 
																																						ON
																																						sa.schactivityid = l.schactivityid
																													LEFT  JOIN 
																																						schedule as s 
																																						ON 
																																						sa.scheduleid = s.scheduleid
																													LEFT JOIN 
																																						employee as e 
																																						ON 
																																						s.supervisorid = e.employeeid
																													where 
																																							sa.employeeid = ".$_SESSION['USERID']." and
																																							l.logdate='".$date_sql." 00:00:00'  and
																																							sa.activitytypeid=act.activitytypeid
																													order by
																																						l.fromtime
 ";
$view_result = $GLOBALS['db']->query($reportViewQuery);
$data['view'].="<div  class=\"schedule_table_div\" id=\"viewReport\" name=\"viewReport\" >";
$data['timeWorked']=0;
 if(isset($view_result) and $view_result->num_rows>0) {
					$line="<br/><hr></hr>";
					while($view = $view_result->fetch_assoc()){			
						$data['timeWorked']+=$view['timespent'];
						$times=calculateTime($view['fromtime'],$view['timespent']);
						$timeView=get_time_fields($times['from'],$times['to'],$times['duration'],$view['activitylogid']);
						
						
$data['view'].="<div id=\"".$view['activitylogid']."_ReportDiv\">
  <form method=\"post\" action=\"report.php\" onSubmit=\"return new_report_form('".$view['activitylogid']."');\"  enctype=\"multipart/form-data\" >
<table width=\"98%\" border=\"0\"   class=\"schedule_table\">
 <tr>
          <td colspan=\"4\"> ";


          
          
          if(($_SESSION['EDIT']==0)||($view['loglock']==1)){
          	$data['view'].="<label class=\"error\" >Report Locked</label>";
					}
						
						
						
    // $data['view'].="";
    	
$data['view'].= "<div class=\"error\" id=\"".$view['activitylogid']."_error\" name=\"".$view['activitylogid']."_error\" ></div></td>
          </tr>
<tr>
<td class=\"firstTD\"  nowrap=\"nowrap\" valign=\"center\"  align=\"center\" >";


$data['view'].=$timeView['table'];
$timeView['table'] = get_duration($view['timespent']);
$data['view'].="<select  id=\"".$view['activitylogid']."_durationNEW\" name=\"".$view['activitylogid']."_durationNEW\" class=\"time_drop\"  >".$timeView['table']."</select>";
$data['view'].="<br/>


</td>";
$data['view'].="
<td class=\"secondTD\"  nowrap valign=\"center\"  align=\"center\" >
<div class=\"scroll\" name=\"".$view['activitylogid']."_div\"  id=\"".$view['activitylogid']."_div\" style=\"display:'';\">
	<input type=\"hidden\" value=\"".$view['scheduleid']."\"  /> ";

if($view['scheduleid']!=""){
	$scheduleId=1;
	$reporttype=$view['schactivityid'];
$data['view'].="
Description:  ".ucfirst($view['activitydesc'])."".$line."Schedule:  ".ucfirst($view['description'])."".$line."Actvity type:  ".ucfirst($view['activityname'])."".$line."Status: ".ucfirst($view['activitystatus'])."".$line."Assigned By: ".ucfirst($view['title']).".".ucfirst($view['supervisor'])."";
}
else{
	$scheduleId=0;
	$reporttype=$view['schactivityid'];
$data['view'].="<br/><br/>Unscheduled Work Report<br/><hr></hr><br/>Actvity type: <select id=\"".$view['activitylogid']."_activityType\"  name=\"".$view['activitylogid']."_activityType\" >";
$data['view'].=	activity_type($view['activitytypeid']);
$data['divs'].=	"</select>";
}
$data['view'].="</div>
</td>";
$data['view'].="
<td class=\"thirdTD\"  nowrap valign=\"center\"  align=\"center\" >";

if($view['supremarks1']!=""){
$data['view'].="<label>Validation Comment</label><br/><div class=\"admin_remark\" >".$view['supremarks1']."</div>";
}

$data['view'].="
<textarea class=\"schedule_textarea\" id=\"".$view['activitylogid']."_report\" name=\"".$view['activitylogid']."_report\" >".$view['empactivitylog']."</textarea>
</td>";
$data['view'].="
<td  class=\"fourthTD\" valign=\"center\"  align=\"center\" >";
if($view['scheduleid']!=""){
$data['view'].="	<input type=\"hidden\" name=\"".$view['activitylogid']."_activityType\"   id=\"".$view['activitylogid']."_activityType\"  value=\"".$view['activitytypeid']."\" /> ";
}
$data['view'].="	<input type=\"hidden\" name=\"".$view['activitylogid']."_reporttype\"   id=\"".$view['activitylogid']."_reporttype\"  value=\"".$reporttype."\" />
<input type=\"hidden\" name=\"fieldID\" id=\"fieldID\" value=\"".$view['activitylogid']."\" />
<input type=\"hidden\" name=\"".$view['activitylogid']."_scheduleId\"   id=\"".$view['activitylogid']."_scheduleId\"  value=\"".$scheduleId."\" />
<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$fileSize."\" /> 
<input type=\"hidden\" name=\"".$view['activitylogid']."_target_path\" id=\"".$view['activitylogid']."_target_path\" value=\"".$target_path."\" /> 

";
if(($_SESSION['EDIT']==0)||($view['loglock']==1)){
	$edit=" disabled=\"true\"  onClick=\"javascript:showAlert('Not Allowed to Edit');\" ";
}
else{$edit="";}
	$data['view'].="   
	<div class=\"fileUpload\">";
	if($view['filename']!=""){
		$data['view'].="<div>File: <a href=\"".$target_path."".$view['filename']."\" target=\"_blank\">".$view['filename']."</a></div>";
}
		$data['view'].="Upload file(max1Mb)
<input name=\"".$view['activitylogid']."_uploadedfile\"  id=\"".$view['activitylogid']."_uploadedfile\" type=\"file\" />	
	</div>
	<div class=\"date\">Report of ".$_SESSION['REP_DATE']."</div>
	<input type=\"submit\" value=\"";
	if(($_SESSION['EDIT']==0)||($view['loglock']==1)){$data['view'].="Locked";}else{$data['view'].="Update";}
	$data['view'].="\" ".$edit." />
	<input type=\"submit\" value=\"Delete\" ".$edit." id=\"delete\" name=\"delete\" />
	<input type=\"reset\" value=\"Reset\" />
<br/>"; 
$data['view'].="<br/>
<div class=\"date\">
<hr></hr>Entered on ";  
$data['view'].=ymdtodmy($view['entrydatetime'],'-',1); 
$data['view'].="<hr></hr></div>
  </td>
</tr>
</table>
</form>
</div>
																										";
					} // while loop
					
				}// if loop
				else{
					$data['timeWorked']=0;
					if(($_SESSION['EDIT']==0)||($view['loglock']==1)){
				 $data['view'].="<div class=\"error\"   >No Reports Found for ".$_SESSION['REP_DATE']."</div>";
				}
				}
 $data['view'].="</div>";
return $data;
}
function get_schedules($new_field_id){
	$date_sql=dmytoymd($_SESSION['REP_DATE']);
	  $sch_query = " select 
													sca.schactivityid as actid, 
													sca.activitytypeid as type, 
													sca.scheduleid as schid, 
													sch.supervisorid as supid, 
													sca.activitydesc as descr , 
													e.	title,
													e.fullname,
													sca.activitycomment as comment1 , 
													sca.activitystatus as status, 
													sch.description as schdescr ,
												 	aty.activityname ,
												 	aty.activitydesc
							        from 
							            schactivity as sca,
							            activitytype as aty,
							            employee as e,
							            schedule as sch  
							        where 
							        	( sca.activitystatus = 'running' OR sca.activitystatus = 'pending') 
						  	        and sca.employeeid='".$_SESSION['USERID']."' 
						  	        and sca.activityfromdate<='".$date_sql."'  
	          						and sca.activitytodate>='".$date_sql."' 
	          						and  sca.scheduleid=sch.scheduleid
	          						and e.employeeid=sch.supervisorid
	          						and aty.activitytypeid=sca.activitytypeid
     							 ";
	          						
	          						$sch_result = $GLOBALS['db']->query($sch_query);
	          						
	          						$data['options'].="	<option value=\"0\" >Unscheduled Works</option>		";		
	          						$data['divs'].="<div name=\"0_div\"  id=\"0_div\" style=\"display:block;\">Activity Type:<select id=\"".$new_field_id."_activityType\"  name=\"".$new_field_id."_activityType\" >";
	          						$data['divs'].=	activity_type(0);
	          						$data['divs'].=	"</select></div>";
	          						$data['ids'].="0,";
	          						
				if(isset($sch_result) and $sch_result->num_rows>0) {
					$line="<br/><hr></hr>";
					while($sch = $sch_result->fetch_assoc()){						
						$data['options'].="	<option value=\"".$sch['actid']."\" title=\"Scheduled work : ".ucfirst($sch['descr'])."\">".ucfirst($sch['schdescr'])."</option>		";			
						$data['divs'].="<div class=\"scroll\" name=\"".$sch['actid']."_div\"  id=\"".$sch['actid']."_div\" style=\"display:none;\">
						<input type=\"hidden\" name=\"".$sch['actid']."_activityType\"   id=\"".$sch['actid']."_activityType\"  value=\"".$sch['type']."\" />
						<input type=\"hidden\" name=\"".$sch['actid']."_scheduleId\"   id=\"".$sch['actid']."_scheduleId\"  value=\"1\" />
						
	          Description:  ".ucfirst($sch['descr'])."".$line."Schedule:  ".ucfirst($sch['schdescr'])."".$line."Actvity type:  ".ucfirst($sch['activityname'])."".$line."Status: ".ucfirst($sch['status'])."".$line."Assigned By: ".ucfirst($sch['title']).".".ucfirst($sch['fullname'])."</div>";
	          $data['ids'].=$sch['actid'].",";

											}// while loop 
										} // if loop
						
										return $data;
}

function activity_type($id){
$activity="";
$query = " select activitytypeid,activityname,activitydesc from activitytype where ( isschedule='0' OR departmentid='".$_SESSION['DEPART']."' ) order by departmentid desc, activityname asc";
	$result = $GLOBALS['db']->query($query);
	
 $activity.=" <option value=\"0\" >Select</option> ";
 
if(isset($result) and $result->num_rows>0) {
while($row = $result->fetch_assoc()) {
$activity.=" <option value=\"".$row['activitytypeid']."\"";
if($id==$row['activitytypeid'])$activity.=" selected=\"selected\" ";
$activity.=" title=\"".$row['activitydesc']."\">".$row['activityname']."</option> ";

}
}

return $activity;
}
function get_time_fields($start="",$to="",$time="",$id=""){
	
											$time_table.="
											<table width=\"99%\" class=\"time_table\" style=\"display:none;\" >
											
											    <tr>
											        <td colspan=\"2\" align=\"center\">
											        <div class=\"error\" id=\"".$id."_errorTime\" name=\"".$id."_errorTime\">&nbsp;</div>
											        </td>
											    </tr>
											    <tr>
											        <td align=\"right\">From Time:
											        </td>
											        <td>
<INPUT type=\"text\" maxlength=\"8\" class=\"date_field\" style=\"width:65px;\" value=\"".$start."\"  title=\"hh:mm:ss\" onBlur=\"Time_Validate(this,this.value);\"   onKeyup=\"Time_Format(this,this.value);date_calculator('".$id."_fromfiled','".$id."_tofiled','".$id."_duration','".$id."_errorTime');\" id=\"".$id."_fromfiled\" name=\"".$id."_fromfiled\">
											        </td>
											    </tr>
											    <tr>
											        <td align=\"right\">To Time:
											        </td>
											        <td>
<INPUT type=\"text\" maxlength=\"8\" class=\"date_field\" style=\"width:65px;\" value=\"".$to."\"  title=\"hh:mm:ss\" onBlur=\"Time_Validate(this,this.value);\"   onKeyup=\"Time_Format(this,this.value);date_calculator('".$id."_fromfiled','".$id."_tofiled','".$id."_duration','".$id."_errorTime');\" id=\"".$id."_tofiled\" name=\"".$id."_tofiled\">
											        </td>
											    </tr>
											    <tr>
											        <td align=\"right\">Duration Time:
											        </td>
											        <td>
<INPUT type=\"text\" maxlength=\"8\" class=\"date_field\" style=\"width:65px;\" value=\"".$time."\"  title=\"hh:mm:ss\" onBlur=\"Time_Validate(this,this.value);\" readonly=\"true\"   onKeyup=\"Time_Format(this,this.value);date_calculator('".$id."_fromfiled','".$id."_tofiled','".$id."_duration','".$id."_errorTime');\" onFocus=\"date_calculator('".$id."_fromfiled','".$id."_tofiled','".$id."_duration','".$id."_errorTime');\" id=\"".$id."_duration\" name=\"".$id."_duration\" />
											        </td>
											    </tr>";
/*
											    <tr>
											        <td colspan=\"2\" align=\"center\">
<INPUT type=\"button\" value=\"check\" onClick=\"javascript:date_calculator('".$id."_fromfiled','".$id."_tofiled','".$id."_duration','error');\" />
											        </td>
											    </tr>
*/
						$time_table.="						</table>
											 				";
	$timetable['table']=$time_table;
	return 	$timetable;
}

function calculateTime($fromTime,$duration){
	$durTime=min2hms($duration);
	$ddd=explode(":",$durTime);
	$from=explode(":",$fromTime);
	$toH=intval($from[0]+$ddd[0]);
	$toM=intval($from[1]+$ddd[1]);
	$toS=intval($from[2]+$ddd[2]);
	if($toS>59){$toM++;$toS=$toS-60;}
	if($toM>59){$toH++;$toM=$toM-60;}
	if($toH>23){$toH=$toH-24;}
	$times['from']=$fromTime;
		$toH=($toH<10)?"0".$toH:$toH;
    $toM=($toM<10)?"0".$toM:$toM;
    $toS=($toS<10)?"0".$toS:$toS;
	$times['to']=$toH.":".$toM.":".$toS;
	$times['duration']=$durTime;
	return $times;
}

      function hms2min ($hms){
      list($h, $m, $s) = explode (":", $hms);
      $minutes = 0;
      $minutes = (intval($h) * 60)+ intval($m);
      return $minutes;
      }
      function min2hms($mins){
      	//print $mins."<br/>";
      	$hrs=intval($mins/60);
      	$mns=intval($mins%60);
      	$hrs=($hrs<10)?"0".$hrs:$hrs;
      	$mns=($mns<10)?"0".$mns:$mns;
      $timeFor=$hrs.":".$mns.":00";
      	return $timeFor;
			}
function edit_check(){	
$days_to_edit_report=getsettings('days_to_edit_report');
$get_date=$_SESSION['REP_DATE'];//d/m/Y
$date=explode('/',$get_date);
$date_format=$date[2]."-".$date[1]."-".$date[0];//Y-m-d
$a = localtime( );
$a[4] += 1;
$a[5] += 1900;
$epoch_2 = mktime(00,00,01,$date[1],$date[0],$date[2]);//m-d-Y

// 4:29:11 am on November 20, 1962
$epoch_1 =  mktime(00,00,01,$a[4],$a[3],$a[5]);
$diff_seconds  = $epoch_1 - $epoch_2;
$diff_days     = floor($diff_seconds/86400);
if(($diff_days<=$days_to_edit_report)&&($diff_days>=0)){
	$_SESSION['EDIT']=1;
	// allows edit
}
else{
	$_SESSION['EDIT']=0;
}

			
				
				/////////////////////////////////  temporary opening of report  ///////////////////////////////////////////////////////////////////////////
					$days_to_open_report=getsettings('days_to_open_report');					
					$query="select * from openreport where openedto='".$_SESSION['USERID']."' and datetoenter='".$date_format."'";
					$result= $GLOBALS['db']->query($query);	
						if($result->num_rows>0)	
						{
							$row = $result->fetch_assoc();
							$entrydate=$row['entrydate'];//Y-m-d							
							$edate=explode('-',$entrydate);
							$edate_epoch2=mktime(00,00,01,$edate[1],$edate[2],$edate[0]);
							
							
								$diff_in_seconds  = $epoch_1  - $edate_epoch2;
								$diff_in_days= floor($diff_in_seconds/86400);
									if(($diff_in_days<=$days_to_open_report)&&($diff_in_days>=0))
									{
										$_SESSION['EDIT']=1;// allows edit
									}
									else{
										$_SESSION['EDIT']=0;
									}
						}						
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			return intval($_SESSION['EDIT']);
}

function get_duration($sel=0,$intervel=30){	
$working_hours=getsettings('working_hours');
$working_mins=$working_hours*60;
 $data="";
for($x=$intervel; $x <= $working_mins; $x += $intervel){
	if($x==30){ $show=" 30 mins ";}
	else if($x==60){ $show=" 1 hour ";}
	else if(($x%60)>0){
		$h=floor($x/60);
		$show=$h." hours  30 mins";
		}else{
			$h=floor($x/60);
				$show=$h." hours ";
		}
							$data .="<option value=\"".$x."\" " ;
							if($x==$sel) { $data.="	selected=\"selected\" ";	}
							$data.="	>".$show."</option>";
							}
							return $data;
}





?>
