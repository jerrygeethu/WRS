<?php
	session_start();
		require_once('include.php');
		require_once('activitydetails.php');
		
	if(isset($_GET['menuid'])){
	$menuid=$_GET['menuid'];
	}

	switch($menuid){
	case '1':
	// include/getvalues.php?menuid=1&entryfn=1&first="+first+"&second="+second+"&sch_id="+id+"
	// &time_worked="+time_worked+"&activity_detail="+activity_detail;
				$entryfn=$_GET['entryfn'];
				$report=$_GET['report'];
        $sch_id=$_GET['sch_id'];
        $time_worked=$_GET['time_worked'];
        $activity_detail=$_GET['activity_detail'];
        $logid=$_GET['logid'];
        $current_date=$_GET['current_date'];
        $sub=check_submission($report,$time_worked,$sch_id."".$logid."".$current_date);
        if($sub==true){
        //$result =  $report."===".$sch_id."===".$time_worked."===".$activity_detail;
        $result=entryfunction_1($entryfn,$report,$sch_id,$time_worked,$activity_detail,$logid,$current_date);
        break;
			}
			else{
				$result=" Data Already Entered ";
				break;
			}
		case '2':
				$entryfn=$_GET['entryfn'];
				$super_id=$_GET['super_id'];
        $second=$_GET['second'];
        $sch_id=$_GET['sch_id'];
        $time_worked=$_GET['time_worked'];
        $activity_detail=$_GET['activity_detail'];
        $sub=check_submission($first."".$second,$time_worked,$sch_id);
        if($sub==true){
        $result=entryfunction_1($entryfn,$first,$second,$sch_id,$time_worked,$activity_detail);
        break;
			}
		case '3':
				$comment=$_GET['comment'];
				$act_id=$_GET['act_id'];
				$com_to=$_GET['com_to'];
        $sub=check_submission($comment,$act_id,$com_to);
        if($sub==true){
        $result=enter_comment($comment,$act_id,$com_to);
        break;
			}
			else{
				$result=" Data Already Entered ";
				break;
			}
		case '4':
				$act_id=$_GET['act_id'];
				$data=$_GET['data'];
        $sub=check_submission($act_id,$data,$act_id);
        if($sub==true){
        $result=lock_report($act_id,$data);
        break;
			}
			else{
				$result=" Data Already Entered ";
				break;
			}
			
			case '5':
				$act_id=$_GET['logid'];
				
        $result=delete_work_report($act_id);
        
        
        
        
				break;
			
			case '6':
			// employee report comment
				$log_id=$_GET['log_id'];
				$report=$_GET['report'];
				$entryfn=$_GET['entryfn'];
        $result=insert_comment_to_report($entryfn,$log_id,$report);
				break;
	}
			print $result;
	?>
