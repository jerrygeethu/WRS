<?php
session_start(); 
require_once('include.php');


function delete_work_report($id){
	
	$query_del="DELETE FROM activitylog WHERE activitylogid =\"".$id."\"";
	$result_action_entry = $GLOBALS['db']->query($query_del);
	if (!($result_action_entry)){
	$result=" Error Occured.. Please Try Again ";
}
	return $result;
}




function lock_report($act_id,$data){
 		
$action_query=" UPDATE activitylog "
								." SET "
											." loglock = '".$data."' "
									." WHERE "
											." activitylogid ='".$act_id."' ";
  $result_action_entry = $GLOBALS['db']->query($action_query);
 	if ($result_action_entry){
 		if($data==1){$result=" Locked";}elseif($data==0){$result=" Unlocked  ";}
 		}
 		else{
 		$result=" Error Occured.. Please Try Again ";	
		}
		return $result;
	
	
	
}






function enter_comment($comment,$act_id,$com_to){
	 		$report=htmlspecialchars($comment);
$action_query=" UPDATE activitylog "
								." SET "
											." ".$com_to." = '".$report."' "
									." WHERE "
											." activitylogid ='".$act_id."' ";
  $result_action_entry = $GLOBALS['db']->query($action_query);
 	if ($result_action_entry){
 		$result=" Data Updated ";
 		}
 		else{
 		$result=" Error Occured.. Please Try Again ";	
		}
		return $result;
	
	
	
}


function insert_comment_to_report($entryfn,$act_id,$report){


				$report=htmlspecialchars($report);
if($entryfn==1){
$action_query_qq=" UPDATE activitylog "
								." SET "
											." supremarks1 = '".$report."' "
									." WHERE "
											." activitylogid ='".$act_id."' ";
		
}
else if($entryfn==2){
$action_query_qq=" UPDATE activitylog "
								." SET "
											." supremarks2 = '".$report."' "
									." WHERE "
											." activitylogid ='".$act_id."' ";
		
}


$result_action_entry_qq = $GLOBALS['db']->query($action_query_qq);
	
 	if ($result_action_entry_qq && $result_action_entry_qq){
 		$result="Data Entered";
 		}
 		else{
 		$result="Error Occured.. Please Try Again";	
		}
return $result;
}


function entryfunction_1($entryfn,$report,$sch_id,$time_worked,$activity_detail,$logid,$current_date){
switch($entryfn){
case '1':
// entering new normal sch report
$result=insert_report($report,$sch_id,$time_worked,$activity_detail,$current_date);
break;
case '2':
// update 
$result=insert_report_1($report,$sch_id,$time_worked,$activity_detail,$logid,$current_date);
break;
case '3':
 	// entering new misc work
$result=insert_report_2($report,$sch_id,$time_worked,$activity_detail,$logid,$current_date);
break;
return $result;
}	
}
 function insert_report_2($report,$sch_id,$time_worked,$activity_detail,$logid,$current_date){
$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
 	// entering new misc work
 	 // updated on 27th june to remove the entry to schactivity  by saxan****************************************** start****
 	 $sel_sch_act_query=" select schactivityid from schactivity where  employeeid= '".$_SESSION['USERID']."'  and  activitytypeid=".$activity_detail." and  isnull(scheduleid) limit 1 ";
 	 
 	 $result_sch_act_query = $GLOBALS['db']->query($sel_sch_act_query);
		if(isset($result_sch_act_query) and ($result_sch_act_query->num_rows>0)){
 	 $row_sch_act_query = $result_sch_act_query->fetch_assoc();
 	 $inserted_id=$row_sch_act_query['schactivityid'];
 	 $result_action_entry_20=TRUE;
 }
 else{
 	$action_query_20=" INSERT INTO schactivity ( schactivityid ,activitytypeid ,scheduleid, employeeid ,activityfromdate ,activitytodate, activitydesc ,emplcomment ,  	activitystatus, activitycomment ) "
." VALUES (NULL , '".$activity_detail."', NULL, '".$_SESSION['USERID']."', '0000-00-00', '0000-00-00', '', '','','') ";
 		$result_action_entry_20 = $GLOBALS['db']->query($action_query_20);
 	$inserted_id=$GLOBALS['db']->insert_id;
}
 	//$inserted_id1=$GLOBALS['db']->mysql_insert_id();
 	
 	 // updated on 27th june to remove the entry to schactivity by saxan ******************************************  end ****
 	
 	$action_query_22=" INSERT INTO activitylog ( activitylogid ,activitytypeid ,schactivityid ,logdate ,timespent,empactivitylog ,supremarks1 ,supremarks2,loglock,entrydatetime) "
." VALUES (NULL , ".$activity_detail.", '".$inserted_id."', '".$current_date."', '".$time_worked."', '".$report."', '', '',0,'".$today."' ) ";

  $result_action_entry_22 = $GLOBALS['db']->query($action_query_22);
 	
 	
 	if ($result_action_entry_20 && $result_action_entry_22){
 		$result=" Data Entered";
 		}
 		else{
 		$result=" Error Occured.. Please Try Again Later";	
		}
		//$result=$inserted_id."<<<>>>".$result."==== ".$action_query_20." --- ".$action_query_22;
		return $result;
}





 function insert_report_1($report,$sch_id,$time_worked,$activity_detail,$logid,$current_date){
 	
 		$report=htmlspecialchars($report);
 		
$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));

$action_query=" UPDATE activitylog "
								." SET "
											." timespent = '".$time_worked."', "
											." activitytypeid='".$activity_detail."', "
											." entrydatetime='".$today."', "
											." empactivitylog = '".$report."' "
									." WHERE "
											." activitylogid =".$logid;
  $result_action_entry = $GLOBALS['db']->query($action_query);
 	if ($result_action_entry){
 		$result=" Data Updated ";
 		}
 		else{
 		$result=" Error Occured.. Please Try Again ";	
		}
		return $result;
}

 	 function insert_report($report,$sch_id,$time_worked,$activity_detail,$current_date){
 	
$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
 		$report=htmlspecialchars($report);
 		
        $action_query=" INSERT INTO activitylog ( activitylogid ,activitytypeid ,schactivityid ,logdate ,timespent,empactivitylog ,supremarks1 ,supremarks2,loglock,entrydatetime) "
." VALUES (NULL , ".$activity_detail.", '".$sch_id."', '".$current_date."', '".$time_worked."', '".$report."', '', '',0, '".$today."' ) ";
  $result_action_entry = $GLOBALS['db']->query($action_query);
  /*
  $action_query_2=" INSERT INTO schactivity ( schactivityid ,activitytypeid ,scheduleid, employeeid ,activityfromdate ,activitytodate, activitydesc ,emplcomment ,  	activitystatus, activitycomment ) "
." VALUES (NULL , ".$activity_detail.", '".$sch_id."', '".$_SESSION['USERID']."', '0000-00-00', '0000-00-00', '', '','','') ";
  */
  //$result_action_entry_2 = $GLOBALS['db']->query($action_query_2);
  
  
  
 	if ($result_action_entry){
 		$result=" Data Entered";
 		}
 		else{
 		$result=" Error Occured.. Please Try Again ";	
		}
		//$result=$action_query;
		return $result;
}
 	
 	

