<?php
function emp_authority($emp_id){
    $query_1 = "select employeeid,departmentid,fullname,isadmin,email, repto from employee where employeeid=".$emp_id;
    $result_1 = $GLOBALS['db']->query($query_1);
    $row_1 = $result_1->fetch_assoc();
   $rept=unserialize($row_1['repto']); // reporting to 
    $emailid=$row_1['email'];
    
    if(($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
		
		$emp_dept_id=0;
		}
		else{
		 $emp_dept_id=$row_1['departmentid'];
		}
		$emp_name=$row_1['fullname'];
		
		
		
		
		
		
    $query_0_0="select depname from department where departmentid=".$emp_dept_id;
    $result_0_0 = $GLOBALS['db']->query($query_0_0);
    $row_0_0 = $result_0_0->fetch_assoc();
    $emp_dep_name=$row_0_0['depname'];
    
    $superadmin_list=explode(",",getsettings('superadmin_list')); 
		if(($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
		
		$is_super_admin=1;
		}
		else if(in_array($emp_id, $superadmin_list)){
		$is_super_admin=1;
		}
		else{
		$is_super_admin=0;
		}
		
	
		
		
		
		
		############################################HRHRHRRHRHR#######################
		
		$query_0_1_1=" select hod,email,fullname from employee,department where employeeid=hod and department.departmentid=\"".$emp_dept_id."\"";
		$result_0_1_1 = $GLOBALS['db']->query($query_0_1_1);
    $row_0_1_1 = $result_0_1_1->fetch_assoc();
		
		$emp_hod_id=$row_0_1_1['hod'];
		$emp_hod_name=$row_0_1_1['fullname'];
		$emp_hod_email=$row_0_1_1['email']; 
		
		
		
		############################################HRHRHRRHRHR#######################
		
		############################################HRHRHRRHRHR#######################
		// reporting to 
	if(empty($rept)){ 
		$rept[]=$row_0_1_1['hod'];
		$query_0_1_22=" UPDATE  employee SET repto = '".trim(serialize($rept))."' WHERE employeeid = '".$row_1['employeeid']."' LIMIT 1; ";
		$result_0_1_1 = $GLOBALS['db']->query($query_0_1_22);
		}
		$repto="";	
		
		$is_hod_reporting=getsettings('is_hod_reporting');
			if(($is_hod_reporting == 1) && (! in_array($emp_hod_id,$rept ))){
		$rept[]=$emp_hod_id;
		$query_0_1_22=" UPDATE  employee SET repto = '".trim(serialize($rept))."' WHERE employeeid = '".$row_1['employeeid']."' LIMIT 1; ";
		$result_0_1_1 = $GLOBALS['db']->query($query_0_1_22); 
		}
		
		
		
	foreach($rept as $rep){
		$repto .= ($repto=="")? intval($rep): ",".intval($rep) ;		
	}
		
		############################################HRHRHRRHRHR#######################
		############################################HRHRHRRHRHR#######################
		// people reporting to this employee 
		 $query_0_1_110=" select employeeid, repto from employee where repto like '%\"".trim($row_1['employeeid'])."\"%' ";
		$result_0_1_110 = $GLOBALS['db']->query($query_0_1_110);		$from_rep = "";		while($row_0_1_110 = $result_0_1_110->fetch_assoc()){ 	$repfrom= unserialize( $row_0_1_110['repto'] ) ; 		if(in_array((string)$row_1['employeeid'],$repfrom)){ $from_rep .= ( $from_rep == "" )? $row_0_1_110['employeeid'] : ",".$row_0_1_110['employeeid'];	}}
		############################################HRHRHRRHRHR#######################
		############################################HRHRHRRHRHR#######################
		
		$query_0_1_12=" select e.employeeid,e.fullname,e.email from employee as e , admindepart as a where  a.employeeid=e.employeeid and a.departmentid=\"".$emp_dept_id."\"";
		$result_0_1_12 = $GLOBALS['db']->query($query_0_1_12);
    $row_0_1_12 = $result_0_1_12->fetch_assoc();
		 
		 $emp_admin_id=$row_0_1_12['employeeid'];
		$emp_admin_name=$row_0_1_12['fullname'];
		$emp_admin_email=$row_0_1_12['email']; 
		
		
		
		############################################HRHRHRRHRHR#######################
		
if(($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
	$is_hr=1;
}
else{
		$hridList=getsettings('hrid');
		$query_122="SELECT * FROM employee where employeeid in (".$hridList.") and employeeid='".$row_1['employeeid']."' ";

$result_122 = $GLOBALS['db']->query($query_122);
   if(isset($result_122) and $result_122->num_rows>0) {
   	$is_hr=1;
	}else{
		$is_hr=0;
	}
	}
		############################################HRHRHRRHRHR#######################
		
		
		if(($row_1['isadmin']==1)||($is_super_admin==1)){ $adminPrivilaged=1;	}else{ $adminPrivilaged=0;	}
		
		
		
		
		
		
		
		
if(($row_1['isadmin']==1)||($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
// to get the dept assigned to him / her if assigned as admin
    
		if(($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
		
		$query_1_1=" select departmentid from department ";
		}
		else{
			$query_1_1="select departmentid from admindepart where employeeid=".$emp_id;
		}
		
		
		
    $result_1_1 = $GLOBALS['db']->query($query_1_1);
   if(isset($result_1_1) and $result_1_1->num_rows>0) {
    $isadmin=1;
    $dept_assigned="";
while($row_1_1 = $result_1_1->fetch_assoc()){
if($dept_assigned!="")$dept_assigned.=",";
    $dept_assigned.=$row_1_1['departmentid'];
}
}
else{
    $isadmin=0;
    $dept_assigned="";
}
}
else{
$isadmin=0;
$dept_assigned="";
}
// to check whether he is HOD

	if(($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
		
	$query_1_2="select departmentid,depname from department ";
		}
		else{
			$query_1_2="select departmentid,depname from department where hod=".$emp_id;
		}
		

$result_1_2 = $GLOBALS['db']->query($query_1_2);
if(isset($result_1_2) and $result_1_2->num_rows>0) {
    $ishod="1";
    $ishod_dep_name="";
    $ishod_dept_id="";
while($row_1_2 = $result_1_2->fetch_assoc()){
if($ishod_dept_id!="")$ishod_dept_id.=",";
if($ishod_dep_name!="")$ishod_dep_name.=",";
    $ishod_dept_id.=$row_1_2['departmentid'];
    $ishod_dep_name.=$row_1_2['depname'];
}
}
else{
    $ishod="0";
    $ishod_dept_id="";
    $ishod_dep_name="";
}
// to check whether he is supervisor
if(($row_1['employeeid']<2)&&($row_1['employeeid']>=0)){
		
	$query_1_3="select scheduleid from schedule where schstatus!='completed'";
		}
		else{
			$query_1_3="select scheduleid from schedule where supervisorid=".$emp_id." and schstatus!='completed'";
		}
		
    
    $result_1_3 = $GLOBALS['db']->query($query_1_3);
if(isset($result_1_3) and $result_1_3->num_rows>0) {
	$is_super="1";
	$is_super_schid="";
while($row_1_3 = $result_1_3->fetch_assoc()){
if($is_super_schid!="")$is_super_schid.=",";
$is_super_schid.=$row_1_3['scheduleid'];
}
}
else{
	$is_super="0";
	$is_super_schid="";
} 
				$emp_power['emp_id'] = $emp_id;// single value
				$emp_power['emp_name']=$emp_name; // employee name
				$emp_power['emp_deptid'] = $emp_dept_id;// single value
				$emp_power['emp_deptname'] = $emp_dep_name;// string
				$emp_power['dep_hod_id'] = $emp_hod_id;// string
				$emp_power['dep_hod_name'] = $emp_hod_name;// string
				$emp_power['dep_hod_email'] = $emp_hod_email;// string
				$emp_power['dep_admin_id'] = $emp_admin_id;// string
				$emp_power['dep_admin_name'] = $emp_admin_name;// string
				$emp_power['dep_admin_email'] = $emp_admin_email;// string
				$emp_power['emp_email'] = $emailid;// string
				$emp_power['is_superadmin'] = $is_super_admin; // boolean type
				$emp_power['is_admin']=$isadmin; // boolean type
				$emp_power['isadm_deptid']= $dept_assigned; // multiple values seprated by comma
				$emp_power['is_hod']=$ishod;// boolean type
				$emp_power['ishod_deptid']=$ishod_dept_id; // multiple values seprated by comma
				$emp_power['ishod_depname']=$ishod_dep_name; // multiple values seprated by comma
				$emp_power['is_super']=$is_super;// boolean type
				$emp_power['issup_schid']=$is_super_schid; // multiple values seprated by comma
				$emp_power['is_adminemp']=$adminPrivilaged; // whether HR privilaged
				$emp_power['is_hr']=$is_hr; // whether HR privilaged
				$emp_power['is_repto']=$repto; // employee reporting to
				$emp_power['from_rep']= $from_rep; // employees reporting to this employee
				return $emp_power;
}

?>
