<?php
require_once('include/include.php');


function get_employees($super_id){ 
	$query = "select s.employeeid,e.fullname "
	." from empsupervisor as s, employee as e "
	." where s.supervisorid=".$super_id." and s.isactive='1' and e.employeeid=s.employeeid";
	$result = $GLOBALS['db']->query($query);
	return $query;
	
}


function get_report_form($userid){ 
// To get the roles of the current user
  $query = "select userroles.rolesid as rolesid,rolename from userroles,roles where userroles.userid=\"$userid\" and userroles.rolesid=roles.rolesid";
	$result = $GLOBALS['db']->query($query);
				print "<option value=\"0\">Select</option>";
		if(isset($result) and $result->num_rows>0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value=\"" . $row['rolesid'] .",".$row['rolename']."\"";
			if($row['rolesid']==$id) echo " selected=\"selected\"";
			echo ">" . $row['rolename'] . "</option>";
			}
		}
	}




//get all the schedules from the supervisor
function get_schedule($supervisorid){

    $schedules="";
    $query = " select scheduleid,description from schedule ";
        $result = $GLOBALS['db']->query($query);
        
    $schedules.="<select name='scheduleid' id='scheduleid' title='Schedule Type'  >";

    if(isset($result) and $result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
        $schedules.="<option value=\"".$row['scheduleid']."\" title=\"".$row['description']."\">".$row['description']."</option>";
        }
    }else{
    $schedules.="<option value='0' title=\" No Scheduled work !!\">No Scheduled work !!</option>";	
		}
    $schedules.="</select>";
    return $schedules;
}
//
 function listschstatus($id) {
			$table = "schedule";
			$column = "schstatus";
			$options = getEnumValues($table,$column);
				for($i=0; $i<count($options); $i++) {
					echo "<option value=\"" . $i . "\"";
					if($i==$id) echo " selected=\"selected\"";
					echo ">" . $options[$i] . "</option>";
					}
				}
 
//
 function listactivities($id) {
			$table = "schactivity";
			$column = "activitystatus";
			$options = getEnumValues($table,$column);
				for($i=0; $i<count($options); $i++) {
					echo "<option value=\"" . $i . "\"";
					if($i==$id) echo " selected=\"selected\"";
					echo ">" . $options[$i] . "</option>";
					}
				}


function get_activity($id,$actid){
	
	$a=explode('-',$id);
	$act_id=$a[0];
	
	
$activity="";
$query = " select activitytypeid,activityname,activitydesc from activitytype where ( isschedule='0' OR departmentid='".$_SESSION['DEPART']."' )";
	$result = $GLOBALS['db']->query($query);
	
$activity.="<select name=\"".$id."\" id=\"".$id."\" title=\"activity type\"   onchange=\"javascript:get_update('".$act_id."');\"> ";
 $activity.=" <option value=\"0\">Select</option> ";
if(isset($result) and $result->num_rows>0) {
	while($row = $result->fetch_assoc()) {
	    $activity.=" <option value=\"".$row['activitytypeid']."\" ";
	if($row['activitytypeid'] == $actid){$activity.=" selected=\"selected\" ";}
	    $activity.=" title=\"".$row['activitydesc']."\">".$row['activityname']."</option> ";
	}
}
$activity.=" </select> ";
return $activity;
}


function get_activity_2($id,$actid,$readonly){
		$a=explode('-',$id);
	$act_id=$a[0];
$activity="";
$query = " select activitytypeid,activityname,activitydesc from activitytype ";
	$result = $GLOBALS['db']->query($query);

$activity.="<select name=\"".$id."\" id=\"".$id."\" ".$readonly." title=\"activity type\"   onchange=\"javascript:get_update('".$act_id."');\" > ";
 $activity.=" <option value=\"0\">Select</option> ";
if(isset($result) and $result->num_rows>0) {
	while($row = $result->fetch_assoc()) {
	    $activity.=" <option value=\"".$row['activitytypeid']."\" ";
	if($row['activitytypeid'] == $actid){$activity.=" selected=\"selected\" ";}
	    $activity.=" title=\"".$row['activitydesc']."\">".$row['activityname']."</option> ";
	}
}
$activity.=" </select> ";

/*
if(isset($result) and $result->num_rows>0) {
	while($row = $result->fetch_assoc()) {
		if($row['activitytypeid'] == $actid){
$activity.="<input type=text value=\"".$row['activitytypeid']."\" name=\"".$id."\" id=\"".$id."\" ".$readonly." title=\"activity type\"  style=\"width:150px;\"> ";
}
}
}
*/
return $activity;
}

function activity_for_misc(){
$activity="";
$query = " select activitytypeid,activityname,activitydesc from activitytype ";
	$result = $GLOBALS['db']->query($query);
	
 $activity.=" <option value=\"0\" >Select</option> ";
 
if(isset($result) and $result->num_rows>0) {
while($row = $result->fetch_assoc()) {
$activity.=" <option value=\"".$row['activitytypeid']."\"";
$activity.=" title=\"".$row['activitydesc']."\">".$row['activityname']."</option> ";

}
}

return $activity;
}

function get_depemployee($deptid){
$employee="";
$query = " select employeeid,fullname AS name,empname  from employee ";
if($deptid)
     $query .= " where departmentid = ".$deptid;

$result = $GLOBALS['db']->query($query);

	
$employee.="<select name='employeeid' id='employeeid' title='Select Employee ' >";

if(isset($result) and $result->num_rows>0) {
	while($row = $result->fetch_assoc()) {
	$employee.="<option value=\"".$row['employeeid']."\" title=\"".$row['empname']."\">".$row['name']."</option>";
	}
}
return $employee;
}



function get_time($id,$selected,$en){
	$a=explode('-',$id);
	$act_id=$a[0];
	if($en==0){
		$get= "  ";
	}
	else if($en==1){
		$get= "  onchange=\"javascript:get_update('".$act_id."');\" ";
	}
	
	
$dd_time="";
if($selected==30){ $sel1="selected=selected";}else{ $sel1="";}
if($selected==60){ $sel2="selected=selected";}else{ $sel2="";}
if($selected==90){ $sel3="selected=selected";}else{ $sel3="";}
if($selected==120){ $sel4="selected=selected";}else{ $sel4="";}
if($selected==150){ $sel5="selected=selected";}else{ $sel5="";}
if($selected==180){ $sel6="selected=selected";}else{ $sel6="";}
if($selected==210){ $sel7="selected=selected";}else{ $sel7="";}
if($selected==240){ $sel8="selected=selected";}else{ $sel8="";}
if($selected==270){ $sel9="selected=selected";}else{ $sel9="";}
if($selected==300){ $sel10="selected=selected";}else{ $sel10="";}
if($selected==330){ $sel11="selected=selected";}else{ $sel11="";}
if($selected==360){ $sel12="selected=selected";}else{ $sel12="";}
if($selected==390){ $sel13="selected=selected";}else{ $sel13="";}
if($selected==420){ $sel14="selected=selected";}else{ $sel14="";}
if($selected==450){ $sel15="selected=selected";}else{ $sel15="";}
if($selected==480){ $sel16="selected=selected";}else{ $sel16="";}

$dd_time.="<select name=".$id." id=".$id."   ".$get."  >"
."<option value=\"30\" ".$sel1.">30 mins</option>"
."<option value=\"60\" ".$sel2.">1 Hours</option>"
."<option value=\"90\" ".$sel3.">1.5 Hours</option>"
."<option value=\"120\" ".$sel4.">2 Hours</option>"
."<option value=\"150\" ".$sel5.">2.5 hours</option>"
."<option value=\"180\" ".$sel6.">3 Hours</option>"
."<option value=\"210\" ".$sel7.">3.5 Hours</option>"
."<option value=\"240\" ".$sel8.">4 Hours</option>"
."<option value=\"270\" ".$sel9.">4.5 Hours</option>"
."<option value=\"300\" ".$sel10.">5 Hours</option>"
."<option value=\"330\" ".$sel11.">5.5 Hours</option>"
."<option value=\"360\" ".$sel12.">6 Hours</option>"
."<option value=\"390\" ".$sel13.">6.5 Hours</option>"
."<option value=\"420\" ".$sel14.">7 Hours</option>"
."<option value=\"450\" ".$sel15.">7.5 Hours</option>"
."<option value=\"480\" ".$sel16.">Full day</option>"
."</select>";
return $dd_time;
}
function get_misc_time(){
$dd_time="";
$dd_time.="<option value=\"30\">30 mins</option>"
."<option value=\"60\">1 Hours</option>"
."<option value=\"90\">1.5 Hours</option>"
."<option value=\"120\">2 Hours</option>"
."<option value=\"150\">2.5 hours</option>"
."<option value=\"180\">3 Hours</option>"
."<option value=\"210\">3.5 Hours</option>"
."<option value=\"240\">4 Hours</option>"
."<option value=\"270\">4.5 Hours</option>"
."<option value=\"360\">5 Hours</option>"
."<option value=\"300\">5.5 Hours</option>"
."<option value=\"330\">6 Hours</option>"
."<option value=\"360\">6.5 Hours</option>"
."<option value=\"360\">7 Hours</option>"
."<option value=\"360\">7.5 Hours</option>"
."<option value=\"360\">Full day</option>";
return $dd_time;
}

//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
if(isset($_POST['dept_drop_down'])){
	$_SESSION['DPT']=$_POST['dept_drop_down'];
	$_SESSION['SCH']=$_POST['sch_drop_down'];
	$_SESSION['EMP']=$_POST['emp_drop_down'];
	if(!(isset($_POST['emp_drop_down'])))$_SESSION['EMP']=0;
	if(!(isset($_POST['sch_drop_down'])))$_SESSION['SCH']=0;
	$schedule_list= get_schedule_list($_SESSION['DPT'],$_SESSION['SCH']);
	//$schedule_list.=get_employee_list($_SESSION['DPT'],$_SESSION['EMP'],$_SESSION['SCH']);
	}
	else if(((isset($_SESSION['EMP'])))&&($_SESSION['EMP']!=0)&&(isset($_SESSION['DPT']))&&($_SESSION['DPT']!=0)&&(isset($_SESSION['SCH']))&&($_SESSION['SCH']!=0)){
	$schedule_list= get_schedule_list($_SESSION['DPT'],$_SESSION['SCH']);
	//$schedule_list.=get_employee_list($_SESSION['DPT'],$_SESSION['EMP'],$_SESSION['SCH']);
	}
else if(!(isset($_SESSION['DPT']))){
	$_SESSION['DPT']=0;
	$_SESSION['EMP']=0;
	$_SESSION['SCH']=0;
}
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
function get_interface_filter($id,$employees){
	$emp_power = emp_authority($_SESSION['USERID']);
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
	$dept.="Department :";
	if(isset($result_dept_query) and $result_dept_query->num_rows>1) {
		$dept.=" <form method=\"post\" id=\"get_dept\" name=\"get_dept\" action=\"report_validation.php\" >
		<table border=\"0\">
		    <tr>
		        <td  nowrap >
<select name=\"dept_drop_down\" id=\"dept_drop_down\" onchange=\"document.getElementById('get_dept').submit();\">";
					$dept.=" <option value=\"0\">Select</option>";				
		while($row_dept_query = $result_dept_query->fetch_assoc()) {
	
	
	$dept.=" <option value=\"".$row_dept_query['departmentid']."\"";
if($id==$row_dept_query['departmentid']){$dept.=" selected=\"selected\" ";}
$dept.=" title=\"Department Name\">".$row_dept_query['depname']."</option> ";
	
	
	
}// while loop
$dept.="</select>
		        </td>
		    </tr>
		</table></form>";
$dept.=$employees;
}// if loop
else{
	$row_dept_query = $result_dept_query->fetch_assoc();
	$dept.="<label><strong>".$row_dept_query['depname']."</strong></label>";
	$dept.=get_schedule_list($row_dept_query['departmentid'],0);
//	$dept.=get_employee_list($row_dept_query['departmentid'],0);
}
return $dept;
}
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
function get_schedule_list($dept_selected,$id){
		$emp_power = emp_authority($_SESSION['USERID']);
		$view_sch_query="select scheduleid,description from schedule where departmentid='".$dept_selected."' ";
		$result_sch_query = $GLOBALS['db']->query($view_sch_query);
		$result_sch_list.=" <br/>Schedule : ";
		if(isset($result_sch_query) and $result_sch_query->num_rows>0) {
		if(isset($result_sch_query) and $result_sch_query->num_rows>1) {
		$result_sch_list.=" <form method=\"post\" id=\"get_sch\" name=\"get_sch\" action=\"report_validation.php\" >
		<table  border=\"0\">
		    <tr>
		        <td nowrap >
		        
		<input type=\"hidden\" value=\"".$dept_selected."\" name=\"dept_drop_down\" id=\"dept_drop_down\" />
												<select name=\"sch_drop_down\" id=\"sch_drop_down\" onchange=\"document.getElementById('get_sch').submit();\"  > 
												<option value=\"0\" >Select </option> ";
while($row_sch_query = $result_sch_query->fetch_assoc()) {
$result_sch_list.=" <option value=\"".$row_sch_query['scheduleid']."\"";
if($id==$row_sch_query['scheduleid']){$result_sch_list.=" selected=\"selected\" ";}
$result_sch_list.=" title=\"Schedule Name\">".$row_sch_query['description']."</option> ";
}
$result_sch_list.="</select></td>
		    </tr>
		</table></form>";
}
else{
	$row_sch_query = $result_sch_query->fetch_assoc();
	$result_sch_list.="<label><strong>".$row_sch_query['description']."</strong></label>";
	$result_sch_list.=get_employee_list($dept_selected,$_SESSION['EMP'],$row_sch_query['scheduleid']);
}
}
else{
	$result_sch_list.="<label><strong>No Schedules</strong></label>";
}
return $result_sch_list;
}
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
function get_employee_list($dept_selected,$id,$sch_id){

	$emp_power = emp_authority($_SESSION['USERID']);
    // echo $emp_power['is_admin'];
	//print_r($emp_power);
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')){
		 
		  $view_emp_query="select "
											." e.employeeid as empid, "
											." e.fullname as fn "
											
									." from "
											." schedule as sc, "
											." schemployee as se, "
											." employee as e "
									." where "
											." sc.departmentid  ='".$dept_selected."' "
											." and se.scheduleid=sc.scheduleid "
											." and se.scheduleid=".$sch_id." "
											." and e.employeeid=se.employeeid "
											." group by se.employeeid "
											." order by e.fullname asc";
		 
		 }
	$result_employee_list="<br/>Employees : ";
	$result_emp_query = $GLOBALS['db']->query($view_emp_query);
	//$result_employee_list.="<option>".$_SESSION['TYPE']."</option>";
	
	

if(isset($result_emp_query) and $result_emp_query->num_rows>0){
if(isset($result_emp_query) and $result_emp_query->num_rows>1) {
		$result_employee_list.=" <form method=\"post\" id=\"get_emp\" name=\"get_emp\" action=\"report_validation.php\" >
		<table  border=\"0\">
		    <tr>
		        <td nowrap >
		<input type=\"hidden\" value=\"".$dept_selected."\" name=\"dept_drop_down\" id=\"dept_drop_down\" />
		<input type=\"hidden\" value=\"".$sch_id."\" name=\"sch_drop_down\" id=\"sch_drop_down\" />
												<select name=\"emp_drop_down\" id=\"emp_drop_down\" onchange=\"document.getElementById('get_emp').submit();\" > 
												<option value=\"0\" >Select </option> ";
while($row_emp_query = $result_emp_query->fetch_assoc()) {
$result_employee_list.=" <option value=\"".$row_emp_query['empid']."\"";
if($id==$row_emp_query['empid']){$result_employee_list.=" selected=\"selected\" ";}
$result_employee_list.=" title=\"Employee Name\">".$row_emp_query['fn']."</option> ";
}
$result_employee_list.="</select></td>
		    </tr>
		</table></form>";
}
else{
	$row_emp_query = $result_emp_query->fetch_assoc();
	$result_employee_list.="<label><strong>".$row_emp_query['fn']."</strong></label>";
}
}
else{
	$result_employee_list.="<label><strong>No Employees Assigned</strong></label>";
}
	return $result_employee_list;
	/*
	$emp_power = emp_authority($_SESSION['USERID']);
    // echo $emp_power['is_admin'];
	print_r($emp_power);
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')){
		 $view_emp_query="select "
											." emp.employeeid as empid, "
											." emp.fullname as fn "
											
									." from "
											." employee as emp "
											." order by emp.fullname asc";
}
else if($emp_power['is_super']=="1"){
  $view_emp_query="select "
											." emp.employeeid as empid, "
											." emp.fullname as fn "
											
									." from "
											." schedule as sch, "
											." schactivity as sact, "
											." employee as emp "
									." where "
											." sch.supervisorid='".$_SESSION['USERID']."' "
											." and sch.scheduleid=sact.scheduleid "
											." and emp.employeeid=sact.employeeid "
											." group by sact.employeeid "
											." order by emp.fullname asc";
										}
	$result_employee_list="";
	$result = $GLOBALS['db']->query($view_emp_query);
	//$result_employee_list.="<option>".$_SESSION['TYPE']."</option>";
 $result_employee_list.=" <option value=\"0\" >Select Employee</option> ";
if(isset($result) and $result->num_rows>0) {
while($row = $result->fetch_assoc()) {
$result_employee_list.=" <option value=\"".$row['empid']."\"";
if($_SESSION['EMP_ID']==$row['empid']){$result_employee_list.=" selected=\"selected\" ";}
$result_employee_list.=" title=\"Employee Name\">".$row['fn']." ".$row['ln']."</option> ";
}
}
*/
}


















//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************
//****************************************************************

?>
