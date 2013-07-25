<?php
function openreport_analytics($depid="",$emp="",$year="",$month="")
{	
	//echo  "   d=".$depid."  e=".$emp."    m=".$month;

$query="SELECT o.*,e.fullname FROM openreport o,employee e 
WHERE 
o.	openedto=e.employeeid AND 
o.deptid='".$depid."'  AND 	
o.openedto='".$emp."' AND 
YEAR(o.entrydate) = '".$year."' AND 
MONTH(o.entrydate) = ".$month;
$result13 = $GLOBALS['db']->query($query);	
	
		$analytics_report="";
		$analytics_report.="<table border=\"0\"cellspacing=\"2px\" width=\"100%\" class=\"main_content_table\">
			<tr><td colspan=\"5\" class=\"table_heading\">Open Report Analytics</td></tr>
			<tr>
			<th width=\"10%\">
			Sl No:
			</th>
			<th width=\"20%\">
			Entered by 
			</th>
			<th width=\"20%\">
			Opened date
			</th>
			<th width=\"50%\" >
			Entered date
			</th>
			
			</tr>";
			$i=0;
			if(isset($result13) and $result13->num_rows>0)
			{
				while($row13=$result13->fetch_assoc())
				{$i++;
						if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
					$analytics_report.="	
					<tr ".$class." width=\"10%\">
					<td width=\"10%\">".$i."</td>
					<td width=\"20%\">".$row13['fullname']."</td>
					<td width=\"20%\">".ymdtodmy($row13['datetoenter'])."</td>
					<td width=\"50%\" >".ymdtodmy($row13['entrydate'])."</td>
					</tr>";
				}
		}else
		{
			$analytics_report.="	
			<tr>
			<td colspan='4'>No Records</td>
			</tr>";
		}
			$analytics_report.="
			</table>";
			return $analytics_report;
	
}
function department($emp_power,$departid)
{		
		$result =get_new_dept_list($emp_power['emp_id'],$emp_power);
		$view="";	
		//$view.= " <option value=\"0\" selected=\"selected\">Select Department</option>";	 		
		while($row = $result->fetch_assoc())
		{	
			$view.="
			
			<option value=\"".$row['departmentid']."\" 
			";
			if(($row['departmentid']==$departid)||($row['departmentid']==$editDepid))
			{
				$view.="selected=\"selected\"";
			}
			$view.=">".$row['depname']."</option>
			";				
		}
		return $view;
}
	
	
function employeelist($emp_power,$departSelected,$emp_id,$editempid="")
{
				$result = get_new_employee_list($departSelected,$emp_power);
				$view="";
					if(isset($result) and $result->num_rows>0)
					{
									
								while($row = $result->fetch_assoc())
								{
									if(($result->num_rows==1)&&($_SESSION['USERID'] == $row['employeeid']))
									{
										$view.="<option value=\"0\">No reporting employees</option>";
									}
									else
									{			
											if($_SESSION['USERID'] == $row['employeeid'])
											continue;
												$view.= " <option value=\"".$row['employeeid']."\" ";
												if(($row['employeeid']==$emp_id)||($row['employeeid']==$editempid))
												{
													$view.="selected=\"selected\" ";
												}	
												$view.=">".$row['fullname']."</option>";
										}
								}
							
				 }
				 
				  return $view;
}
	
	
	function getopenreports($start,$limit)
	{
		$emparr=array();
		$emp_power=emp_authority($_SESSION['USERID']);	
		$resultdep=get_new_dept_list($emp_power['emp_id'],$emp_power);
		while($row = $resultdep->fetch_assoc())
		{
			$depid=$row['departmentid'];
			$resultemp=get_new_employee_list($depid,$emp_power);		
			while($row = $resultemp->fetch_assoc())
			{
				if($_SESSION['USERID'] == $row['employeeid'])
				continue;
				$emparr[]=$row['employeeid'];
			}
		}
		
		
	$query="SELECT r.*,e.fullname,(select f.fullname from employee f where r.openedby=f.employeeid)  as openbyemp FROM `openreport` r,employee e WHERE r.`openedto`=e.employeeid and r.openedto!='".$_SESSION['USERID']."' order by entrydate desc";
	$result1 = $GLOBALS['db']->query($query);
	//$totoal_count=$result1->num_rows;
		
	$query .= " limit  ".$start." , ".$limit;
	$s=$start;
	$result = $GLOBALS['db']->query($query);
	if($result->num_rows>0 )
	{  			$i=$start;
									$f=$result->num_rows;		
									$j=$i+1; 
			while($row = $result->fetch_assoc())
			{							 
									
									if(!empty($emparr))
									{
										if(in_array($row['openedto'],$emparr))
										{ 
											 $i++;
												$view.="<tr align=\"center\">
																		<td>".$row['fullname']."</td>
																		<td>".$row['openbyemp']."</td>
																		<td>".ymdtodmy($row['datetoenter'])."</td>
																		<td>".ymdtodmy($row['entrydate'])."</td>
																		<td>
																		<form name=\"frmedit\" id=\"frmedit\" method=\"post\" action=\"editopenreport.php\">";
												$view.="<input type=\"submit\" name=\"editBtn\" id=\"editBtn\" value=\"Edit\"/>";								
												$view.="<input type=\"hidden\" name=\"rid\" id=\"rid\" value=\"".$row['openreportid']."\"/>";																															
												$view.="</form>
																		</td>
																		</tr>";
										}										 
									}
			}// while loop 
	}
	else
	{
		$view.="<td colspan=\"4\" align=\"center\">No Records</td>";
	}
	$data['tables']=$view;
			$data['last_count']=$i;
			$data['found_rows']=$f;
			$data['total_count']=$i+1;
			return $data;
	}
	?>
