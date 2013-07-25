<?php  

if(isset($_POST['dept_drop_down'] )&&($_POST['dept_drop_down']!='0'))
{
	if($_SESSION['DPTRV1']!=$_POST['dept_drop_down'])
	$sc=1;else $sc=0;
	$_SESSION['DPTRV1']=$_POST['dept_drop_down'];
	$_SESSION['EMPRV1']=0;
	$_SESSION['SCH1']=0;
}


if(isset($_POST['sch_drop_down'] )&&($_POST['sch_drop_down']!='0')&&($_SESSION['DPTRV1']>0)&&($sc==0))
{
	if($_SESSION['SCH1']!=$_POST['sch_drop_down'])
	$em=1;
	else
	$em=0;

	$_SESSION['DPTRV1']=$_POST['dept_drop_down'];
	$_SESSION['SCH1']=$_POST['sch_drop_down'];
	$_SESSION['EMPRV1']=0;
}
else
{
	$_SESSION['SCH1']=0;
} 

if(isset($_POST['emp_drop_down'] )&&($_POST['emp_drop_down']!='0'))

{	
	$_SESSION['DPTRV1']=$_POST['dept_drop_down'];
	$_SESSION['SCH1']=$_POST['sch_drop_down'];
	$_SESSION['EMPRV1']=$_POST['emp_drop_down'];
}
else
{
	$_SESSION['EMPRV1']=0;
}


/*print " ========================<br/>";
print "D=>".$_SESSION['DPTRV1']."<br/> S=>".$_SESSION['SCH1']."<br/> E=>".$_SESSION['EMPRV1'];
print "<br/>========================";*/


/*
$_SESSION['DPTRV1']=0;
$_SESSION['EMPRV1']=0;
$_SESSION['SCH1']=0;

if(isset($_POST['dept_drop_down'] )&&($_POST['dept_drop_down']!=0))
{
	// get schedules
	$_SESSION['DPTRV1']=$_POST['dept_drop_down'];
	$_SESSION['EMPRV1']=0;
	$_SESSION['SCH1']=0;
	if(isset($_POST['sch_drop_down'] )&&($_POST['sch_drop_down']!=0))
	{
		// get employees
		$_SESSION['SCH1']=$_POST['sch_drop_down'] ;
		$_SESSION['EMPRV1']=0;
		if(isset($_POST['emp_drop_down'] )&&($_POST['emp_drop_down']!=0))
		{
			$_SESSION['EMPRV1']=$_POST['emp_drop_down'] ;
		}
	}// get employees
}// get schedules
else
{
	if(!(isset($_SESSION['DPTRV1'])))
	{
		$_SESSION['DPTRV1']=0;
		$_SESSION['EMPRV1']=0;
		$_SESSION['SCH1']=0;
	}
}
*/




//////////////////////////////////////////////////////////////////////////////////////////////
//old code
/*if(isset($_POST['dept_drop_down'])&&(isset($_POST['emp_drop_down'])))
{
	$_SESSION['DPTRV']=$_POST['dept_drop_down'];
	$_SESSION['EMPRV']=$_POST['emp_drop_down'];
	$_SESSION['SCH']=$_POST['sch_drop_down'];
} 
else if(isset($_POST['dept_drop_down']))
{
	$_SESSION['DPTRV']=$_POST['dept_drop_down'];
	$_SESSION['EMPRV']=0;
}
else if(!(isset($_SESSION['DPTRV'])))
{
	$_SESSION['DPTRV']=0;
	$_SESSION['EMPRV']=0;
}*/
//old code
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

//From date
if(isset($_POST['rdate']))
{
	$date_ar=explode('/',$_POST['rdate']);
	$_SESSION['RVDATE']=$date_ar[2]."-".$date_ar[1]."-".$date_ar[0];
	$_SESSION['RDATESHOW']=$_POST['rdate'];
}
else if(!(isset($_SESSION['RVDATE'])))
{	
	//make starting date of month
	$a = localtime();
	$a[4] += 1;
	$a[5] += 1900;
	$yest="01/".$a[4]."/".$a[5]; //dmy		
	$from=$yest;

	

	// make yesterday date	
	//$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
	//echo "Yest  is ".date("d-m-Y", $yest);
	//$_SESSION['RVDATE']=date("Y-m-d", $yest);
	//$_SESSION['RDATESHOW']=date("d/m/Y", $yest);		

	$_SESSION['RVDATE']=dmyToymd($yest);	
	$_SESSION['RDATESHOW']=$yest;
}

//To date
if(isset($_POST['todate']))	
{
	$to_date_arr=explode('/',$_POST['todate']);
	$_SESSION['TODATE']=$to_date_arr[2]."-".$to_date_arr[1]."-".$to_date_arr[0];
	$_SESSION['TODATESHOW']=$_POST['todate'];
}
else if(!(isset($_SESSION['TODATE'])))
{
	$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
	$_SESSION['TODATE']=date("Y-m-d", $yest);
	$_SESSION['TODATESHOW']=date("d/m/Y", $yest);	
	//$to=date("d/m/Y", $yest);
	//echo "yest=".$yest;
	//echo "<br/>to=".$to;
	//echo "<br/>f=".$from."<br/>t=".$to;
	//compare dates
	$fromdate=strtotime($from);
	$todate=$yest;
	//echo "<br/>strFrom=".$fromdate."<br/>strTo=".$todate;
	if($fromdate > $todate)	
	{		
		//echo "<br/>from greater than to";
		$arr=explode("/",$from);
		$day=$arr[0];
		$month=$arr[1]-1;
		$year=$arr[2];
		$arr_date=$day."/".$month."/".$year;
		$_SESSION['RVDATE']=$arr_date;
		$_SESSION['RDATESHOW']=$arr_date;						
	}
}

// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

if(isset($_POST['lock_btn']))
{
	$btnvalue=$_POST['lock_btn'];
	$act_log_id=$_POST['act_log_id'];
	if($btnvalue=="Lock")
	{
		$action_query=" UPDATE activitylog "
								." SET "
											." loglock = '1' "
									." WHERE "
											." activitylogid ='".$act_log_id."' ";
	}
	else
	{
		$action_query=" UPDATE activitylog "
								." SET "
											." loglock = '0' "
									." WHERE "
										." activitylogid ='".$act_log_id."' ";
	}
	$result_action_entry = $GLOBALS['db']->query($action_query);
	if (!$result_action_entry)
	{
 		print " Error Occured.. Please Try Again ";	
	}
}


// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

if(isset($_POST['com_to_adm']))
{
	$com_text=$_POST['com2adm'];
	$act_log_id=$_POST['act_log_id'];
	$action_query=" UPDATE activitylog "
								." SET "
											." supremarks2 = '".$com_text."' "
									." WHERE "
											." activitylogid ='".$act_log_id."' ";
	$result_action_entry = $GLOBALS['db']->query($action_query);
	if (!$result_action_entry)
	{
 		print " Error Occured.. Please Try Again ";	
	}
}


// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

if(isset($_POST['com_to_emp']))
{
	$com_text=$_POST['com2emp'];
	$act_log_id=$_POST['act_log_id'];
	$action_query=" UPDATE activitylog "
								." SET "
											." supremarks1 = '".$com_text."' "
									." WHERE "
										." activitylogid ='".$act_log_id."' ";
	$result_action_entry = $GLOBALS['db']->query($action_query);
	if (!$result_action_entry)
	{
 		print " Error Occured.. Please Try Again ";	
	}
}


// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

function get_dept_list($id)
{
	$emp_power = emp_authority($_SESSION['USERID']);
	if($emp_power['is_superadmin'] =='1')
	{
	$view_dept_query="select departmentid,depname from department order by depname asc ";
	}
	else if($emp_power['is_admin'] =='1')
	{
	$view_dept_query=" select departmentid,depname from department where departmentid in (".$emp_power['isadm_deptid'].")  order by depname asc ";
	}
	else if($emp_power['is_hod'] =='1')
	{
	$view_dept_query=" select departmentid,depname from department where departmentid in (".$emp_power['ishod_deptid'].")  order by depname asc ";
	}
	$result_dept_query = $GLOBALS['db']->query($view_dept_query);
	$dept.="";
	$dept.=" <form method=\"post\" id=\"get_dept\" name=\"get_dept\" action=\"rep_valid.php\" >
		<table border=\"0\" >
		    <tr>
		        <td  nowrap ><label style=\"width:150px;\">Department</label>:
<select name=\"dept_drop_down\" id=\"dept_drop_down\" onchange=\"document.getElementById('get_dept').submit();\" title=\"Select Department To Validate Report\">";
	if(isset($result_dept_query) and $result_dept_query->num_rows>1)
	{
		$dept.=" <option value=\"0\">Select</option>";		
		while($row_dept_query = $result_dept_query->fetch_assoc())
		{
			$dept.=" <option value=\"".$row_dept_query['departmentid']."\"";
			if($id==$row_dept_query['departmentid']){$dept.=" selected=\"selected\" ";}
			$dept.=" title=\"Department Name :".ucwords($row_dept_query['depname'])."\" >".ucwords($row_dept_query['depname'])."</option> ";
		}// while loop
	}// if loop
	else
	{
		$row_dept_query = $result_dept_query->fetch_assoc();
		$dept.="<option value=\"".$row_dept_query['departmentid']."\" selected=\"selected\" title=\"You Have Only One Department Assigned :".$row_dept_query['depname']."\"  >".$row_dept_query['depname']."</option>";
		$_SESSION['DPTRV']=$row_dept_query['departmentid'];
		//$dept.=get_schedule_list($row_dept_query['departmentid'],0);
		//$dept.=get_employee_list($row_dept_query['departmentid'],0);
	}
	$dept.="</select>
					</td>
				</tr>
			</table></form>";
	return $dept;
}



// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

function get_emp_list($emp_sel,$dept_selected)
{
	$emp_power = emp_authority($_SESSION['USERID']);
	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1'))
	{
		$view_emp_query=" select 
													employeeid as empid,
													title as title,
													fullname as fn 
											from 
													employee 
											where  
													empstatus = 'active'
												and 	employeeid!=".$_SESSION['USERID']."
	 											and 
													departmentid ='".$dept_selected."' order by fullname asc  ";		 
	}
	else if($emp_power['is_hod'] =='1')
	{
		$view_emp_query=" select 
												employeeid as empid,
												title as title,
												fullname as fn
											from 
													employee 
											where 
												empstatus = 'active'
											and
		employeeid!=".$_SESSION['USERID']."	
	 										and 
											departmentid ='".$dept_selected."' order by fullname asc ";
	}
	else if($emp_power['is_super'])
	{
		$view_emp_query=" 	select 
	 											e.employeeid as empid,
													title as title,
	 											e.fullname as fn
	 										from 
	 											employee as e ,
	 											schemployee as s
	 										where   
												e.empstatus = 'active'
											and
			s.employeeid=e.employeeid
											and 
												s.employeeid!='".$_SESSION['USERID']."'
											and 
												s.scheduleid in (".$emp_power['issup_schid'].") 
	 										group by s.employeeid order by e.fullname asc  ";
	}
	//print $view_emp_query;
	$result_emp_query = $GLOBALS['db']->query($view_emp_query);
	$emp.="";
	$emp.=" <form method=\"post\" id=\"get_emp\" name=\"get_emp\" action=\"rep_valid.php\" >
		<table border=\"0\">
		    <tr>
		        <td  nowrap ><label style=\"width:150px;\">Employee&nbsp;&nbsp;&nbsp;</label>:
		        <input type=\"hidden\" value=\"".$dept_selected."\" name=\"dept_drop_down\" id=\"dept_drop_down\" />
<select name=\"emp_drop_down\" id=\"emp_drop_down\" onchange=\"document.getElementById('get_emp').submit();\" title=\"Select Employee To Validate Report\" >";
	if(isset($result_emp_query) and $result_emp_query->num_rows>1)
	{
		$emp.=" <option value=\"#\">select</option>";			
		//$emp.=" <option value=\"0\">All Employees</option>";			
		/*
		$emp.=" <option value=\"all\"  ";		
		if( $emp_sel=='all') 	
		{$emp.=" selected=\"selected\" ";}		
		$emp.=" >All</option>";				
		*/
		while($row_emp_query = $result_emp_query->fetch_assoc())
		{
			$emp.=" <option value=\"".$row_emp_query['empid']."\"";
			if($emp_sel==$row_emp_query['empid'] ){$emp.=" selected=\"selected\" ";}
			$emp.="   title=\"Employee Name :".ucwords($row_emp_query['fn'])."\" >".ucwords($row_emp_query['fn'])."</option> ";
		}// while loop
	}// if loop
	else
	{
		$row_emp_query = $result_emp_query->fetch_assoc();
		$emp.="<option value=\"".$row_emp_query['empid']."\" selected=\"selected\"   title=\"You Have Only One Employee Assigned In This Department \"  >".ucwords($row_emp_query['fn'])."</option>";
		$_SESSION['EMPRV']=$row_emp_query['empid'];
	}
	$emp.="</select>
					</td>
				</tr>
			</table></form>";
	return $emp;
}

// ******************************************************************************
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************
// ******************************************************************************



function get_sch_list($sel_sch,$dept_selected)
{
	// this query works when the user is in higher power than supervisor 
	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
	{
		$view_sch_query="select scheduleid,description from schedule where departmentid='".$dept_selected."' ";
	}
	else if($emp_power['is_super'] =='1')
	{
		$view_sch_query="select scheduleid,description from schedule where scheduleid in (".$dept_selected.")";
	}
	$result_sch_query = $GLOBALS['db']->query($view_sch_query);
	$sch.="";
	$sch.=" <form method=\"post\" id=\"get_sch\" name=\"get_sch\" action=\"rep_valid.php\" >
		<table border=\"0\">
		    <tr>
		        <td  nowrap >Schedule :
<input type=\"hidden\" value=\"".$dept_selected."\" name=\"dept_drop_down\" id=\"dept_drop_down\" />
<select name=\"sch_drop_down\" id=\"sch_drop_down\" onchange=\"document.getElementById('get_sch').submit();\" >";
	if(isset($result_sch_query) and $result_sch_query->num_rows>1)
	{
		$sch.=" <option value=\"0\">Select Schedule</option>";		
		while($row_sch_query = $result_sch_query->fetch_assoc())
		{
			$sch.=" <option value=\"".$row_sch_query['scheduleid']."\"";
			if($sel_sch==$row_sch_query['scheduleid']){$sch.=" selected=\"selected\" ";}
			$sch.=" title=\"Department Name\">".$row_sch_query['description']."</option> ";
		}// while loop
		//$dept.=$employees;
	}// if loop
	else
	{
		$row_sch_query = $result_sch_query->fetch_assoc();	
		$sch.="<option value=\"".$row_sch_query['scheduleid']."\" selected=\"selected\" >".$row_sch_query['description']."</option>";
	}
	$sch.="</select>
		     </td>
		    </tr>
			</table></form>";
	return $sch;
}

	

	

	

	

// ******************************************************************************

// ******************************************************************************

// ******************************************************************************

?>

