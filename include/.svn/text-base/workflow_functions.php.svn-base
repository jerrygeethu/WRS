<?php
function Workflow($wid)
{
	$wfQuery="SELECT 
						w.*
					FROM 
						workflow as w
					WHERE 						
						w.workflowid='".$wid."' and w.parentwfid='0' limit 1 ";
	$wfResult=$GLOBALS['db']->query($wfQuery);
	$wfRow=$wfResult->fetch_assoc();
	$data['subject']=$wfRow['subject'];
	$data['description']=$wfRow['description'];
	$data['file1']=$wfRow['file1'];
	$data['newfile']=$wfRow['newfile'];
	$data['status']=$wfRow['wstatus'];
	//Get routing
	$routeQuery="select
							r.*
						from
							routing as r,workflow as w
						where
							r.`workflowid`=w.`workflowid`
							and
							w.`workflowid`='".$wid."'
						";
	$routeResult=$GLOBALS['db']->query($routeQuery);
	while($routeRow=$routeResult->fetch_assoc())
	{	
		$data['emps'].=$routeRow['employeeid'].",";
	}
	return $data;
}
//to del
function Workflow1($wid)
{
	$wfQuery="SELECT 
						w.*,r.*
					FROM 
						workflow as w,routing as r 
					WHERE 
						w.`workflowid`=r.`workflowid`
						and
						w.`workflowid`='".$wid."' ";
	$wfResult=$GLOBALS['db']->query($wfQuery);
	$data=array();
	$i=0;
	while($wfRow=$wfResult->fetch_assoc())
	{	
		$data['emps'].=$wfRow['employeeid'].",";				
	}
	return $data;
}
//Get workflow
function getWorkflow($wfid)
{
	$getWfQuery="select 
							w.*,e.fullname																		
						from
							workflow as w	, employee as e					
						where							
							w.workflowid='".$wfid."'
							and
							w.createdby=e.employeeid
							";
	$getWfResult=$GLOBALS['db']->query($getWfQuery);
	$getWfRow=$getWfResult->fetch_row();
	return $getWfRow;
}
//View Workflow
function viewWorkflow()
{	
	$wfQuery="select
								wf.*,r.*
							from 
								workflow as wf,
								routing as r
							where 
								wf.workflowid=r.workflowid
								and
								(
								wf.createdby='".$_SESSION['USERID']."'
								or
								r.employeeid='".$_SESSION['USERID']."'
								)	
								group by wf.workflowid							
							";
	$wfResult=$GLOBALS['db']->query($wfQuery);
	$total_pages = $wfResult->num_rows;
	$view="";
	$i=0;
	if($wfResult->num_rows>0)
	{
		while($wfRow=$wfResult->fetch_assoc())
		{
			$i++;
			if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
			$view.="<tr ".$class.">
						<td  align=\"center\">".$i."</td>
						<td  align=\"center\">".$wfRow['subject']."</td>
						<td  align=\"center\">".$wfRow['description']."</td>
						<td  align=\"center\">".ymdtodmy($wfRow['date'])."</td>
						<td align=\"center\">
						";
						if($_SESSION['USERID']==$wfRow['createdby'])
						{
							$view.="<a href=\"workflow.php?editID=".$wfRow['workflowid']."\">Edit</a>/";
						}
			$view.="<a href=\"#\" onclick=\"javascript:newWindow(".$wfRow['workflowid'].");\">Reply</a>
						</td>								
						</tr>
						";
		}
	}
	return $view;
}
//Get department
function depList($depid)
{
	$depQuery="select distinct d.departmentid,d.depname
					 from department d,employee e
					 where e.departmentid=d.departmentid	 					
					 order by d.depname	";
	$depResult=$GLOBALS['db']->query($depQuery);
	$view="";
	$view.="<option value=\"0\">select</option>";
	if($depResult->num_rows>0)
	{
		while($depRow=$depResult->fetch_assoc())
		{
			$view.="<option value=\"".$depRow['departmentid']."\"";
			if($depRow['departmentid']==$depid){ $view.="selected=\"selected\" ";}
			$view.=">".$depRow['depname']."</option>";
		}
	}
	else
	{
		$view.="<option>No records</option>";
	}
	return $view;
}
//Get employees for the selected department
function empList($depid)
{			
	$empQuery="select employeeid,fullname
						from employee 
						where departmentid='".$depid."' and empstatus='active'
						";
						
	$empResult=$GLOBALS['db']->query($empQuery);
	$view="";
	if($empResult->num_rows>0)
	{
		while($empRow=$empResult->fetch_assoc())
		{
			$view.="<option value=\"".$empRow['employeeid']."\">".$empRow['fullname']."</option>";
		}
	}
	else
	{
		$view.="<option>No employees</option>";
	}
	return $view;
}

//Get status
function liststatus($status) 
{			
	$table = "workflow";
	$column = "wstatus";
	$options = getEnumValues($table,$column);
	
	foreach($options as $key => $value)
	{
		echo "<option value=\"" . $i=$key+1 . "\"";
		if($value==$status) { echo "selected=\"selected\""; }
		echo ">" . $value . "</option>";
	}
}
//insert workflow
function insertWorkflow($arr,$chk_files,$new_file_name,$edit,$delete)
{
	$date=date("Y-m-d");
	$empid = $_SESSION['USERID'];   
	$subject=$arr['subject'];
	$desc=$arr['description'];
	$emplist=$arr['wfemployee'];
	
	$status=$arr['status'];
	if($edit>0)
	{
		//$result="edit";
		$updateQuery="update workflow
							  set subject='$subject',description='$desc',file1='$chk_files',newfile='$new_file_name',date='$date',wstatus='$status'
		 					 where workflowid='".$edit."'		
							";
		$updateResult=$GLOBALS['db']->query($updateQuery);		
		$delRouting="delete from routing where workflowid='".$edit."' ";
		$delResult=$GLOBALS['db']->query($delRouting);
		foreach($emplist as $key =>$empid)
		{
			$key=$key+1; 
			$insertRouting="insert into routing(`workflowid`,`employeeid`,`order`,`rstatus`)
								values('$edit','$empid','$key','pending')";
			$result1=$GLOBALS['db']->query($insertRouting);
		}
		if($result1)
		{
			header("Location:listWorkflow.php?msg=1");
			exit;
		}
		else
		{
			header("Location:listWorkflow.php?msg=3");
			exit;
		}		
	}
	else if($delete>0)
	{
		$result="delete";
		$delWorkflow="delete from workflow where workflowid='".$delete."' ";
		$delResult=$GLOBALS['db']->query($delWorkflow);
		$delRouting="delete from routing where workflowid='".$delete."' ";
		$delResult1=$GLOBALS['db']->query($delRouting);
		if($delResult and $delResult1) { header("Location:listWorkflow.php?msg=2"); exit; } else {  header("Location:listWorkflow.php?msg=3"); exit; }		
	}
	else
	{
		$insertQuery="insert into workflow(subject,description,file1,newfile,parentwfid,createdby,date,wstatus) 
							values('$subject','$desc','$chk_files','$new_file_name','','$empid','$date','$status')";
		$result=$GLOBALS['db']->query($insertQuery);
		$id=$GLOBALS['db']->insert_id;
		foreach($emplist as $key =>$empid)
		{
			$key=$key+1; 
			$insertRoute="insert into routing(`workflowid`,`employeeid`,`order`,`rstatus`)
								values('$id','$empid','$key','pending')";
			$result1=$GLOBALS['db']->query($insertRoute);			
		}
		if($result1) { header("Location:listWorkflow.php?msg=0"); exit;} else {  header("Location:listWorkflow.php?msg=3"); exit; }
	}
	//return $result;
}


function get_selected_employees($data)
{
	$emps=explode(",",$data['selected_employees']);
	$emps=array_unique($emps);
	$i=1;
	$view='<select name="wfemployee[]" id="wfemployee" size="10" multiple="multiple" title="Scheduled employee list" style="width:170px;" >';
	foreach($emps as $key=>$value)
	{			
		$empQuery="select employeeid,fullname
						from employee 
						where   empstatus='active' and
						employeeid='".$value."' limit 1
						";
		$empResult=$GLOBALS['db']->query($empQuery);
		if($empResult->num_rows>0)
		{				
			while($empRow=$empResult->fetch_assoc())
			{					
				$view.="<option value=\"".$empRow['employeeid']."\">".$i.". ".$empRow['fullname']."</option>";
				$i++;
			}
		}
	}	
	$view.="</select>";	
	return $view;	
}
?>
