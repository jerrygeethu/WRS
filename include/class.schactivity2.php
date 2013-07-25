<?php

class schactivity {

/*
get employees for a schedule
*/
function getEmpOfSch($schid)
{
	
	 $getEmp="select schemp.scheduleid,schemp.employeeid,e.fullname,e.departmentid,dep.depname
					from
					schemployee schemp,employee e,department dep
					where
					e.employeeid=schemp.employeeid
					and
					e.departmentid=dep.departmentid
					and
					schemp.scheduleid='".$schid."'
					and
					e.employeeid!='".$_SESSION['USERID']."'
					order by dep.depname
					";
	$resultEmp=$GLOBALS['db']->query($getEmp);
	if(isset($resultEmp) and $resultEmp->num_rows>0)
	{
     	$i=1;
		print "<form action='' method='POST'>
							<table  border='0' width='100%'   class=\"main_content_table\" >";
						
		echo ' <tr align="center" valign="middle" style="background-color:#CDCDCD;">
				<th width="10px" class="main_matter_txt">Sl No</th>
				<th width="125px" class="main_matter_txt">Name</th>			
				<th width="100px" class="main_matter_txt">Department</th>					
				<th width="100px" class="main_matter_txt">Assign work </th>
				</tr>';
		while($rowEmp=$resultEmp->fetch_assoc())
		{
			echo "<tr  align=\"center\" valign=\"middle\" style=\"border:1px black;\" ";
			echo (($i%2)==0)?"bgcolor=\"#d1d1d3\" ":"bgcolor=\"#FFFFFF\" "; 					
			echo "><td  width=\"10px\">" . $i++ . "</td>";
			echo "<td class=\"Link_text\"   width=\"125px\">".$rowEmp['fullname']."</td>";
			echo "<td class=\"Link_text\"   width=\"125px\">".$rowEmp['depname']."</td>";
			echo "<td class=\"Link_text\"   width=\"125px\">
			<input type=\"button\" name=\"assign_work\" id=\"assign_work\"  onclick=\"javascript:assignwork('".$rowEmp['employeeid']."','".$rowEmp['departmentid']."');\" value=\"Assign   Work\"/>
			</td>";
			echo "</tr>";
		}
	}
	else
	{
		//echo '<tr><td class="warn" align="center" colspan="4"><strong>No Records Found</strong></td></tr>';
	}
	print "</table></form>";
}



/*
get email id of employee for email activity information
*/
function get_emp_email($empid)
{
	$query="select email from employee where employeeid=".$empid."";	
	$result = $GLOBALS['db']->query($query);
	$row = $result->fetch_assoc();
	$to_mail=$row['email'];
	return $to_mail;
	
}

/*
get schedule description for email activity information
*/
function get_schedule_desc($sch_id)
{
	$query="select description from schedule where scheduleid =".$sch_id."";	
	$result = $GLOBALS['db']->query($query);
	$row = $result->fetch_assoc();
	$schedule_desc=$row['description'];
	return $schedule_desc;
}



//get all the schedules from the supervisor for  schactivity
function get_scheduleForActivity($emp_power,$supervisorid,$scheduleid,$empid){

       $schedules="";
       
       //print_r($emp_power);
       
 if( $emp_power['is_superadmin']==1)
 {
  
    $query1  = " SELECT schedule.scheduleid,description,";
    $query1 .=" CONCAT(DATE_FORMAT(schfromdate,'%d/%m/%Y'),' - ',DATE_FORMAT(schtodate,'%d/%m/%Y')) AS time,";
    $query1 .=" schcomment FROM schedule, schemployee ";
   
   
    $query1  .=" WHERE schedule.scheduleid=schemployee.scheduleid AND schemployee.employeeid =".$empid."  ";
   
    $query  = $query1. "  AND schstatus!='completed' ";
   
   
   
   		
   
	
	//$query = $query." UNION DISTINCT ";
    //$query = $query." ".$query1;
    
	//$query .=" WHERE schstatus!='completed' ";
 }
 
 else if(( $emp_power['is_admin']==1)||( $emp_power['is_hod']==1))
 {
  
    $query1  = " SELECT schedule.scheduleid,description,";
    $query1 .=" CONCAT(DATE_FORMAT(schfromdate,'%d/%m/%Y'),' - ',DATE_FORMAT(schtodate,'%d/%m/%Y')) AS time,";
    $query1 .=" schcomment from schedule, schemployee ";
    
  if($empid!='')
    $query1 .=" WHERE schedule.scheduleid = schemployee.scheduleid AND schemployee.employeeid =".$empid." AND ";
	
	$query = $query1."  schstatus!='completed' ";
    //$query = $query." UNION ";
    //$query = $query." ".$query1;
    //$query .="  departmentid IN (".$emp_power['isadm_deptid'].") AND schstatus!='completed' ";
 } 
  
 else if( $emp_power['is_super']==1)
 {
  
    $query = " select distinct schedule.scheduleid,description,";
    $query .=" CONCAT(DATE_FORMAT(schfromdate,'%d/%m/%Y'),' - ',DATE_FORMAT(schtodate,'%d/%m/%Y')) AS time,";
    $query .=" schcomment from schedule, schemployee ";
    $query .=" WHERE supervisorid =".$supervisorid." AND schstatus!='completed' AND schedule.scheduleid=schemployee.scheduleid ";
 } 
 
  //echo $query;
   $result = $GLOBALS['db']->query($query);
        
    $schedules.="<select name='scheduleid' id='scheduleid' title='Schedule Type' onChange='javascript:changeSchedule(this);'  style='width:150px;'>";

    if(isset($result) and $result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
        $schedules.="<option value=".$row['scheduleid']." ";
 	if($row['scheduleid']==$scheduleid)  
	$schedules.= "selected=\"selected\" ";
	 $schedules.=" title=\"".$row['schcomment'].", From-To =".$row['time']."\">".$row['description']."</option>";
        }
    }
    $schedules.="</select>";
    return $schedules;
   
}

 
function get_activity($emp_id,$actid){
		$activity="";
		//$query = " select activitytypeid,activityname,activitydesc from activitytype ORDER BY activityname ";
		$query = " select activitytypeid,activityname,activitydesc from activitytype,department,employee "
			." WHERE `isschedule`=1 AND activitytype.departmentid=department.departmentid AND "
			."employee.departmentid=department.departmentid AND "
			."employee.employeeid=".$emp_id." "
			."ORDER BY activityname ";
		
		$result = $GLOBALS['db']->query($query);
			
		$activity.="<select name='activitytypeid' id='activitytypeid' title='Activity Type'  style='width:150px;'>";
		$activity.="<option value='0'>Select</option> ";
		
		if(isset($result) and $result->num_rows>0) {
			while($row = $result->fetch_assoc()) {
			    $activity.="<option value=\"".$row['activitytypeid']."\" ";
			if($row['activitytypeid'] == $actid){$activity.=" selected=\"selected\"";}
			    $activity.=" title=\"".$row['activitydesc']."\">".$row['activityname']."</option>";
			}
}
		return $activity;
}


function get_emplForAssignActvitiy($emp_id,$schid){
   
   //echo $emp_id;
   $employee="";
    $query = " select distinct(emp.employeeid),fullname AS name,empname  from employee emp,`schemployee` sch"
            ." where emp.`employeeid`= sch.`employeeid` AND  emp.employeeid=".$emp_id." ";
   if($schid!='')
        $query .= "AND `scheduleid`=".$schid." ";
   $query .= " ORDER BY name"; 
  
   $result = $GLOBALS['db']->query($query);

	
      $employee.="<select name='employeeid'  id='employeeid' title='Select Employee ' onChange='javascript:changeEmployee(this);'  style='width:150px;'>";
      //$employee.="<option value=\"\" >Select</option> ";
      if(isset($result) and $result->num_rows>0) {
      	while($row = $result->fetch_assoc()) {
      	$employee.= " <option value=\"".$row['employeeid']."\"";
      	if($row['employeeid'] == $emp_id){ 
      	$employee.= " selected=\"selected \"";
        }  
        $employee.= " title=\"".$row['empname']."\">".$row['name']."";
      	$employee.= " </option>";
      	
      	}
      }
      return $employee;
}


	
	
		//To show assigned activity in a dropdown from field enum of 
		// This function using on assignactivity.php file
		public function listactivitystatus($id) {
			$table = "schactivity";
			$column = "activitystatus";
			$options = getEnumValues($table,$column);
				foreach($options as $key=>$value) {
					echo "<option value=\"" . $i=$key+1 . "\"";
					if($id!='' AND $value==$id) echo " selected=\"selected\"";
					echo ">" . $value . "</option>";
					}
					
				}
				//To edit schedule for adhoc type	
				public function editSchedule()
				{
				}
		// To save OR update assignactivity's records to db tbl
		public function insertassignactivity($toassignactivity,$tablename,$editid,$delid){
				$result_arr=array();
			if(isset($delid) and $delid > 0 ) {
				$query = "DELETE FROM $tablename where $tablename.schactivityid = '$delid'";				
				//header("Location:assignactivity.php?empid=".$toassignactivity['employeeid']);
				//exit;
				$result_arr['result']=$GLOBALS['db']->query($query);
				$result_arr['empid']=$toassignactivity['employeeid'];
				
			} else if(isset($editid) and $editid > 0 ) {
				// To updae user record
				$query = "update $tablename set ";
				foreach( $toassignactivity as $key => $value){
					$query .= "$key = '$value', ";
				}
				$query = rtrim($query, ', ');
				$query .= " where $tablename.schactivityid = '$editid'";	
				
				//header("Location:assignactivity.php?empid=".$toassignactivity['employeeid']);
				//exit;
				$result_arr['result']=$GLOBALS['db']->query($query);
				$result_arr['empid']=$toassignactivity['employeeid'];
				
			}
			else
			{
				$query = "insert into " . $tablename . " (";
				foreach( $toassignactivity as $key => $value){
					$query .= "$key, ";
				}
				$query = rtrim($query, ', ');
				$query .= ") values (";
				foreach( $toassignactivity as $key => $value){
					$query .= "'$value', ";
				}
				$query = rtrim($query, ', ');
				$query .= ")";				
				//header("Location:assignactivity.php?empid=".$toassignactivity['employeeid']);
				//exit;
				$result_arr['result']=$GLOBALS['db']->query($query);
				$result_arr['empid']=$toassignactivity['employeeid'];
				
			}
			return $result_arr;
		}
		
		// To list assigned activity in a list from table
		// this function is using in assignactivity.php
		public function listschactivity($supid,$emp_id,$schid) {
			//echo $emp_id;
			$query = "select schactivity.schactivityid,employee.fullname, activitytype.activityname, schactivity.activitydesc, ";
			$query .= " DATE_FORMAT(schactivity.activityfromdate,'%Y-%m-%d') as activityfromdate, DATE_FORMAT(schactivity.activitytodate,'%Y-%m-%d') as activitytodate, schactivity.activitystatus ";
			
			$query .= " from employee, activitytype, schactivity,schedule ";
			$query .= " where schactivity.employeeid = employee.employeeid AND schactivity.activitytypeid = activitytype.activitytypeid";
			
			$query .= " AND schedule.scheduleid= schactivity.scheduleid ";
			//$query .= " AND schedule.supervisorid=".$supid."  ";
			
			if(isset($emp_id) AND $emp_id > 0){
			$query .= " AND employee.employeeid =".$emp_id." ";
			}
			
			if(isset($schid) AND $schid > 0){
			$query .= " AND schedule.scheduleid =".$schid." ";
			}
			
//echo $query;			
			$result = $GLOBALS['db']->query($query);
			if(isset($result) and $result->num_rows>0) {
			$i=1;
				while ($row = $result->fetch_assoc()) {
					echo "<tr align=\"center\"  valign=\"middle\" style='border:1px  black;'>";
        				echo "<td class=\"Link_txt\" width=\"50px\">" . $i++ . "</td>";
        				echo "<td class=\"Link_txt\" width=\"200px\" ><a href=\"assignactivity.php?empid=".$emp_id."&id=".$row['schactivityid']." \">" . $row['fullname'] . "</a></td>";
        				echo "<td class=\"Link_txt\" width=\"200px\" >" . $row['activityname'] . "</td>";
        				echo "<td class=\"Link_txt\" width=\"100px\" ><a href=\"assignactivity.php?empid=".$emp_id."&id=".$row['schactivityid']." \">" . $row['activitydesc'] . "</td>";
					echo "<td class=\"Link_txt\" width=\"100px\" >" . ymdToDmy($row['activityfromdate']) ." to ". ymdToDmy($row['activitytodate']) . "</td>";
					echo "<td class=\"Link_txt\" width=\"100px\" >" . $row['activitystatus'] . "</td>";
     					echo "</tr>";
				
				}
			}
		}
function getschactivity($schactivityid){
	$query = "select 
					schactivityid,activitytypeid,scheduleid,employeeid,
					DATE_FORMAT(activityfromdate,'%Y-%m-%d') as activityfromdate,
					DATE_FORMAT(activitytodate,'%Y-%m-%d') as activitytodate,
					activitydesc,emplcomment,	
					activitystatus,activitycomment
	 				from schactivity where schactivityid = '$schactivityid'";
			$result = $GLOBALS['db']->query($query);
    			if(isset($result) and $result->num_rows>0) {
		  	return $row = $result->fetch_assoc();		
		}
}	
}

/*
function saveSchData($schid,$suprid,$des,$schfromdate,$schtodate,$schstatus,$schcomment,$schdepart,$schempls)
{
          
      if(isset($schid) and $schid>0) {
			$updSql = "UPDATE  `schedule` SET `departmentid` = '$schdepart', supervisorid='$suprid',`description` = '$des',
                  schfromdate='$schfromdate',schtodate='$schtodate',schstatus='$schstatus',`schcomment` = '$schcomment' "; 
    	    $updSql.= "WHERE `schedule`.`scheduleid`='$schid'";
			
			$val = $GLOBALS['db']->query($updSql);
			if(isset($val) and $val==1) {
			    
			    insertUpdateSchEmp($schid,$schempls);
			    
			    header('Location: assignschwork.php?schid='.$schid);
				exit;
			} else {
   			header('Location: assignschwork.php?schid='.$schid);
   			exit;
   			}
   		}
   		else  {
			
            $insSql= "INSERT INTO `schedule` (`scheduleid`, `supervisorid`, `description`, `schfromdate`, `schtodate`, `schstatus`, `schcomment`) VALUES
      ('', '$suprid', '$des', '$schfromdate', '$schtodate', '$schstatus', '$schcomment')";					
      			
     			$val = $GLOBALS['db']->query($insSql);
     			if($val==1)
     			    header('Location: assignschwork.php?ins=1');
     			else 
     			    header('Location: assignschwork.php?ins=0');
      }
      
     
      
      
}
function  insertUpdateSchEmp($schid,$schempls){
    $schempSql = "Select * from schemployee Where  scheduleid='".$schid."'";
    $rstschemp = $GLOBALS['db']->query($schempSql);
    if(isset($rstschemp) and $rstschemp->num_rows>0) {
        while($rowschemp = $rstschemp->fetch_assoc()) {
            
        }
    }
    
}
function deleteSchData($schid)
{
    if(isset($schid) and $schid>0) {
			$query = "DELETE FROM schedule WHERE schedule.scheduleid = '$schid'";
			$val = $GLOBALS['db']->query($query);
			if(isset($val) and $val==1) {
				header('Location: assignschwork.php');
				exit;
			} else {
			header('Location: assignschwork.php');
			exit;
			}
}
}


function get_employees($super_id){ 
	$query = "select s.employeeid,e.fullname "
	." from empsupervisor as s, employee as e "
	." where s.supervisorid=".$super_id." and s.isactive='1' and e.employeeid=s.employeeid";
	$result = $GLOBALS['db']->query($query);
	return $query;
	
}
*/
/*
// To pick User data to Edit
 function getData($schid) {
			$query = "select * from schedule where scheduleid = '$schid'";
			$result = $GLOBALS['db']->query($query);
    			if(isset($result) and $result->num_rows>0) {
		  	return $row = $result->fetch_assoc();
   	 	}
		}


// To list schedules  by supervisor
		Public function viewschedules($suprid) {
			//echo $suprid;
			 $viewquery = "SELECT `scheduleid`,`supervisorid`,fullname AS supervisor,`description`,`schfromdate`,`schtodate`,`schstatus` FROM `schedule`,`employee`   "
		    			 ."WHERE `supervisorid`='".$suprid."' AND  schedule.`supervisorid`= employee.`employeeid`";
			
			$viewresult = $GLOBALS['db']->query($viewquery);
		  	if(isset($viewresult) and $viewresult->num_rows>0) {
        		$i=1;
        		
        		
				while ($viewrow = $viewresult->fetch_assoc()) {
					echo "<tr width=\"100%\" align=\"center\" valign=\"middle\" style='border:1px  black;'>";
					echo "<td class=\"\" width='50px'>" . $i++ . "</td>";
        				echo "<td class=\"link_txt\"  width='200px'><a title=\"Click to Edit or Delete Schedule \" href=\"assignschwork.php?schid=";
					echo $viewrow['scheduleid'] . "\">";
					echo $viewrow['supervisor']  . "</a> </td>";
					echo "<td class=\"main_matter_txt\"    width='200px'>" . $viewrow['description'] . " </td>";
					//print "<input type='hidden' name='es_id' id='es_id' value='".$row['esid']."'/>";
					echo "<td class=\"main_matter_txt \" width='200px'>" . ymdToDmy($viewrow['schfromdate']) . "-". ymdToDmy($viewrow['schtodate']) ."</td>";
					echo "<td class=\"main_matter_txt \" width='200px'>" . $viewrow['schstatus'] . " </td>";
					
					echo "</tr>";
					
				}
				
			}
		}
	
	
        
//17/03/2009
function get_nonschemployee($deptid,$schid=''){
   $employee="";
  if($schid=='')
   $query = " select employeeid,fullname ,empname  from employee ";
   if($deptid!='')
        echo $query .= " where departmentid = ".$deptid;
  
   $result = $GLOBALS['db']->query($query);

	
     // $employee.="<select name='employeeid' id='employeeid' title='Select Employee ' onChange='javascript:changeEmployee(this);'  style='width:150px;'>";
     // $employee.="<option value=\"0\" >--Select--</option> ";
      if(isset($result) and $result->num_rows>0) {
      	while($row = $result->fetch_assoc()) {
      	$employee.= " <option value=\"".$row['employeeid']."\"";
      	if($row['employeeid'] == $emp_id){ 
      	$employee.= " selected=\"selected \"";
        }  
        $employee.= " title=\"".$row['empname']."\">".$row['fullname']."";
      	$employee.= " </option>";
      	
      	}
      }
      return $employee;
}

function get_schemployee($deptid,$schid=''){
   $employee="";
   
   $query = " select schemp.employeeid AS employeeid, fullname ,empname  from employee emp,schemployee schemp ";
   if($deptid!='')
         $query .= " where departmentid = ".$deptid;
         $query .= " AND schemp.scheduleid = ".$schid;
         $query .= " AND schemp.employeeid = emp.employeeid ";
   $result = $GLOBALS['db']->query($query);

	
     // $employee.="<select name='employeeid' id='employeeid' title='Select Employee ' onChange='javascript:changeEmployee(this);'  style='width:150px;'>";
     // $employee.="<option value=\"0\" >--Select--</option> ";
      if(isset($result) and $result->num_rows>0) {
      	while($row = $result->fetch_assoc()) {
      	$employee.= " <option value=\"".$row['employeeid']."\"";
      
        $employee.= " title=\"".$row['empname']."\">".$row['fullname']."";
      	$employee.= " </option>";
      	
      	}
      }
      return $employee;
}

 
function getDepartmentForSch($emp_power)
{
    $depList="";
    if($emp_power['isadm_deptid']!=''){
        $quearyDep="select * from department where departmentid IN (".$emp_power['isadm_deptid'].")";
    }
     else{
        $quearyDep="select * from department where departmentid";
    }
    
    $resultDep = $GLOBALS['db']->query($quearyDep);
    
         if(isset($resultDep) and $resultDep->num_rows>0) {
      	    $depList.= " <select id=\"departmentid\" name=\"departmentid\" onChange=\"ChangeDepart();\">";    
      	    while($rowDep = $resultDep->fetch_assoc()) {
            
                                      
                        $depList.= " <option value=\"".$rowDep['departmentid']."\"";
                        $depList.= " title=\"".$rowDep['depdescription']."\">".$rowDep['depname']."";
                        $depList.= " </option>";
                      
                     
            }
            $depList.= " </select>";
     }
   
   
 return $depList;
}

*/


//**********************************************************************
//// RAFEEK/////////////////////////////////////////////////////////////
//
/*
 function listschstatus($status) {
			//echo "status=".$status;
			$table = "schedule";
			$column = "schstatus";
			$options = getEnumValues($table,$column);
				
				foreach($options as $key => $value) {
					echo "<option value=\"" . $i=$key+1 . "\"";
					if($value==$status) echo " selected=\"selected\"";
					echo ">" . $value . "</option>";
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

*/
?>
