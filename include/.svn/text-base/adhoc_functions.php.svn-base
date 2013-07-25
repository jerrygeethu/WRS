<?php		
//to get employee for admin and hod
function employeelist($emp_power,$depid,$emp_id)
{
	
	$result = get_new_employee_list($depid,$emp_power);
/*
				$query="SELECT distinct e.employeeid,
									    e.fullname,
									    e.departmentid
							FROM employee e,
									 department d									
									";
							
				if($emp_power['is_superadmin']==1)
				{
					$query.="WHERE  e.departmentid=d.departmentid  AND e.empstatus='active'
								";										
				}
				
				else if($emp_power['is_admin']==1)
				{
					$query.="WHERE  e.departmentid=d.departmentid  AND e.empstatus='active'
								AND d.departmentid IN (".$emp_power['isadm_deptid'].")
								";			
				}
				else if($emp_power['is_hod']==1)
				{
					$query.="WHERE e.departmentid=d.departmentid  AND e.empstatus='active' 
								AND d.departmentid IN (".$emp_power['ishod_deptid'].")
								";
				}
						
				if($depid!='' && $depid!='0' )   
				{
					$query.=" AND e.departmentid =".$depid." ";
				}
	
				$query.= " AND e.employeeid >1 ";
				$query.=" ORDER BY e.fullname ";
				
				//echo $query;
				$result = $GLOBALS['db']->query($query);
*/
			//$employee.="<select name='employeeid'  id='employeeid' title='Select Employee ' onChange='javascript:changeEmployee(this);'  style='width:150px;'>";
			  	//$employee.="<option value=\"\" >Select</option> ";
			  	if(isset($result) and $result->num_rows>0)
				{
					while($row = $result->fetch_assoc())
					{
						$employee.= " <option value=\"".$row['employeeid']."\"";
						if($row['employeeid'] == $emp_id)
						{ 
							$employee.= " selected=\"selected \"";
						}  
						$employee.= " title=\"".$row['fullname']."\">".$row['fullname']."";
						$employee.= " </option>";					
					}
			  }
			  return $employee;
}
//Get department list for filtering employee list in viewemployee.php
function getDepartmentList($emp_power,$departid)
{   

/*
	if($emp_power['is_superadmin']=="1")
	{
		$query = "SELECT departmentid, depname,depdescription FROM department order by depname";
   	}
	else if($emp_power['is_admin'])
	{
		$query = "SELECT departmentid, depname,depdescription FROM department  ";
		$query .=" WHERE departmentid IN ( ".$emp_power['isadm_deptid'].")  order by depname";
	}
	 else if($emp_power['is_hod']=="1")
	{
		 $query = "SELECT departmentid, depname,depdescription FROM department  ";
		 $query .=" WHERE departmentid = ".$emp_power['ishod_deptid']." order by depname";
	}
	else if($emp_power['is_super']=="1")
	{
		 $query = "SELECT departmentid, depname, depdescription FROM department ";
		 $query .=" WHERE departmentid = ".$emp_power['emp_deptid']." order by depname";
	}
	else
	{
		 $query = "SELECT departmentid, depname,depdescription FROM department";
		 $query .=" WHERE departmentid = ".$emp_power['emp_deptid']." order by depname";
	}
*/

	//$result = $GLOBALS['db']->query($query);
	$result = get_new_dept_list($emp_power['emp_id'],$emp_power);

	while($row = $result->fetch_assoc())
	{		
		echo "<option value=\"" . $row['departmentid'] . "\" title=\"".$row['depdescription']."\" ";
		if($row['departmentid']==$departid) {echo " selected=\"selected\""; } 
		echo ">" . ucwords($row['depname']) . "</option>";	
	}
}

//get activity type for selected department
function activitytype($departSelected,$activitytypeid)
{
	$query="select activitytypeid,activityname from activitytype where departmentid='".$departSelected."' or isschedule=0";
	//echo $query;
	$result = $GLOBALS['db']->query($query);
	while($row = $result->fetch_assoc())
	{		
		echo "<option value=\"" . $row['activitytypeid'] . "\" title=\"".$row['activityname']."\" ";
		if($row['activitytypeid']==$activitytypeid) {echo " selected=\"selected\""; } 
		echo ">" . ucwords($row['activityname']) . "</option>";	
	}
}
//get activity status
function listactivitystatus($id)
{
	$table = "schactivity";
	$column = "activitystatus";
	$options = getEnumValues($table,$column);
	foreach($options as $key=>$value)
	{
		echo "<option value=\"" . $i=$key+1 . "\"";
		if($id!='' AND $value==$id) echo " selected=\"selected\"";
		echo ">" . $value . "</option>";
	}
					
}
?>
