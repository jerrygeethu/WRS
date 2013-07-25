<?php

 if(isset($_POST['dept_drop_down'])){
$_SESSION['VDPRT']=$_POST['dept_drop_down'];
}
else if(($emp_power['is_superadmin'] !='1')&&($emp_power['is_admin'] !='1')&&($emp_power['is_hod'] !='1')&&($emp_power['is_super'] =='1')){
	$_SESSION['VDPRT']=$emp_power['emp_deptid'];
}
else if(!(isset($_SESSION['VDPRT']))){
	$_SESSION['VDPRT']=0;
}

// ******************************************************************************
// ******************************************************************************
// ******************************************************************************

function get_dept_list($id){
	$emp_power = emp_authority($_SESSION['USERID']);
/*
	if($emp_power['is_superadmin'] =='1'){
	$view_dept_query="select departmentid,depname from department ";
	}
	else if($emp_power['is_admin'] =='1'){
	$view_dept_query=" select departmentid,depname from department where departmentid in (".$emp_power['isadm_deptid'].") ";
	}
	else if($emp_power['is_hod'] =='1'){
	$view_dept_query=" select departmentid,depname from department where departmentid in (".$emp_power['ishod_deptid'].") ";
	}
	$result_dept_query = $GLOBALS['db']->query($view_dept_query);
*/
	$dept.="";
	$dept.=" <form method=\"post\" id=\"get_dept\" name=\"get_dept\" action=\"viewreport.php\" >
		<table border=\"0\">
		    <tr> 
		        <td  nowrap >Department :
<select name=\"dept_drop_down\" id=\"dept_drop_down\"  style=\"width:184px\" onchange=\"document.getElementById('get_dept').submit();\">";
					$result_dept_query=get_new_dept_list($emp_power['emp_id'],$emp_power) ;
	if(isset($result_dept_query) and $result_dept_query->num_rows>1) {
				$dept.=" <option value=\"0\">Select</option>";		
		while($row_dept_query = $result_dept_query->fetch_assoc()) {
	
	
	$dept.=" <option value=\"".$row_dept_query['departmentid']."\"";
if($id==$row_dept_query['departmentid']){$dept.=" selected=\"selected\" ";}
$dept.=" title=\"Department Name\">".$row_dept_query['depname']."</option> ";
	
	
	
}// while loop

//$dept.=$employees;
}// if loop
else{
	$row_dept_query = $result_dept_query->fetch_assoc();
	$dept.="<option value=\"".$row_dept_query['departmentid']."\" selected=\"selected\" >".$row_dept_query['depname']."</option>";
	$_SESSION['VDPRT']=$row_dept_query['departmentid'];
//	$dept.=get_schedule_list($row_dept_query['departmentid'],0);
//	$dept.=get_employee_list($row_dept_query['departmentid'],0);
}
$dept.="</select>
		        </td>
		    </tr>
		</table></form>";
return $dept;
}

//print $_SESSION['DPRT'];

?>
