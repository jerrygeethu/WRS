<?php
require_once('include.php');
//Get employees for job request in  department wise
function get_all_employees($depid,$emps)
{		
	//$employees=explode(",",$emps);
	//$employees=$emps;
	$depquery="select distinct d.departmentid,d.depname
					 from department d,employee e
					 where e.departmentid=d.departmentid	 
					 and 	d.departmentid	!='".$depid."'
					 order by d.depname	
					";	
	$depresult=$GLOBALS['db']->query($depquery);
	if($depresult->num_rows>0)
	{
		while($deprow=$depresult->fetch_assoc())
		{
			$view.="<optgroup label=\" ".$deprow['depname']."\">";
			$empquery="select employeeid,fullname
							 from employee
							where departmentid='".$deprow['departmentid']."' 
							and empstatus='active' order by fullname
							";
			$empresult=$GLOBALS['db']->query($empquery);
			if($empresult->num_rows>0)
			{
				while($emprow=$empresult->fetch_assoc())
				{
					$view.="<option value=\"".$emprow['employeeid']."-".$deprow['departmentid']."\" ";				
					if(in_array($emprow['employeeid'],$emps))
					{
						$view.="selected=\"selected\" ";		
					}	
					$view.="	 >".$emprow['fullname']."</option>";
				}
			}
			else
			{
				$view.="<option>No employees</option>";
			}
			$view.="</optgroup>";
		}
	}
	else
	{
		$view.="<option>No records</option>";
	}
	return $view;
}

//Get status
function liststatus() 
{			
	$table = "emprequest";
	$column = "status";
	$options = getEnumValues($table,$column);
	
	foreach($options as $key => $value)
	{
		echo "<option value=\"" . $i=$key+1 . "\"";
		//if($value==$status) echo " selected=\"selected\"";
		echo ">" . $value . "</option>";
	}
}

						




//////////////////////////////////////////////////
//Not in use
//Get employee list based on department
function listemployee($depid)
{
	$empquery="select employeeid,fullname
					 from employee 	
					 where departmentid='".$depid."'		 
					";					
	$result=$GLOBALS['db']->query($empquery);
	if($result->num_rows>0)
	{
		while($row=$result->fetch_assoc())
		{
			$view.="<option value=\"".$row['employeeid']."\" >".$row['fullname']."</option>";
		}
		echo $view;
	}
}

//Get department list
function listdepartment($depid)
{
	$depquery="select distinct d.departmentid,d.depname
					 from department d,employee e
					 where e.departmentid=d.departmentid		
					 order by d.depname		 
					";	
	$result=$GLOBALS['db']->query($depquery);
	if($result->num_rows>0)
	{
		$view="";
		while($row=$result->fetch_assoc())
		{	
			$view.="<option value=\"".$row['departmentid']."\"  ";
			if($row['departmentid']==$depid) { $view.=" selected=\"selected\" "; }			
			 $view.=">".$row['depname']."</option>";			
		}
		echo $view;
	}
}
?>