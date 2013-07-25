<?php 

function get_eligibitlity1($emp_id)
{
	if($emp_id=="")
	{
	$emp_id=$_SESSION['USERID'];
	}
	$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
	$today=strftime("%Y-%m-%d 23:59:59", strtotime($timestamp));
							$query = "select leavetypeid, 
										effectivedate as effDate,
										leavedays 
							from 
									leaveeligibility
							where 
										employeeid = '".$emp_id."' and 
										effectivedate <= '".$today."'
							order by effectivedate desc
							limit 0,1 
						";
																																											 
	$result = $GLOBALS['db']->query($query);
	$data['leaveArray']="";
	if(isset($result) and $result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
		if($row['leavetypeid']==$permissionID)
			{$effdate = getsettings('leaveyearstart');}
			else
			{$effdate = $row['effDate'];}
		
			$query_already_taken_leaves="
													select 
													sum(leavedays) as leavesTaken, count(leavedays) as permsAvailed
													from 
													leaveapplication 
													WHERE 
													leavetypeid='".$row['leavetypeid']."' and 
													employeeid='".$emp_id."' and
													 fromdate>='".$effdate."' and
													 cancelled=0 
													";
	
			$permissionID=getsettings('permissionid');
			$maxPermission=getsettings('maxpermissionspermonth');
			$result_already_taken_leaves = $GLOBALS['db']->query($query_already_taken_leaves);
			if(isset($result_already_taken_leaves) and $result_already_taken_leaves->num_rows>0)
			{
				while($row_leave = $result_already_taken_leaves->fetch_assoc())
				{
					if($row['leavetypeid']==$permissionID)
					 { $leavesAvailable=$maxPermission-$row_leave['permsAvailed'];}
					 else
					 {$leavesAvailable=$row['leavedays']-$row_leave['leavesTaken'];}	
					 
					if($data['leaveArray']!="")$data['leaveArray'].=",";
					$data['leaveArray'].=$row['leavetypeid']."=>".$leavesAvailable;
					$data['leave'][$row['leavetypeid']]=$leavesAvailable;
				}
			}
		}// while loops
	}// if loop
	return $data;
}
?>
