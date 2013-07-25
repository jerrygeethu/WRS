<?php

class schactivity
{

function saveSchData($schid,$suprid,$des,$schfromdate,$schtodate,$schstatus,$schcomment,$schdepart,$schempls)
{
     /*  echo " ".$schid;
       echo " ".$suprid;
       echo " ".$des;
       echo " ".$schfromdate;
       echo " ".$schtodate;
       echo " ".$schstatus;
       echo " ".$schcomment;
       echo " ".$schdepart;*/
      /* echo "sch emp = ".$schempls;
	   echo "<br/>";
	 
	   exit;*/
           /* print_r($schempls);
	   echo "<br/>emp=";
	 	print_r($empreqs);
		echo "<br/>";
		
		print_r($newArrSchEmp);*/
		//$newArrSchEmp=array_merge($schempls,$empreqs);
		  
	if(isset($schid) and $schid>0)
	{
		$updSql = "UPDATE  `schedule` SET `departmentid` = '$schdepart', supervisorid='$suprid',`description` = '$des',
		schfromdate='$schfromdate',schtodate='$schtodate',schstatus='$schstatus',`schcomment` = '$schcomment' "; 
		$updSql.= "WHERE `schedule`.`scheduleid`='$schid'";
	
		$val = $GLOBALS['db']->query($updSql);
		if(isset($val) and $val==1)
		{	
			$this->insertUpdateSchEmp($schid,$schempls);	//$this->insertUpdateSchEmp($schid,$schempls);	
			header('Location:assignschwork.php?ins=2&schid='.$schid);
			exit;
		}
		else
		{
			header('Location:assignschwork.php?ins=3&schid='.$schid);
			exit;
		}
	}
	else
	{	
		 $insSql= " INSERT INTO `schedule` (`scheduleid`,`departmentid`, `supervisorid`, `description`, `schfromdate`, `schtodate`, `schstatus`, `schcomment`) 		VALUES
	('','$schdepart', '$suprid', '$des', '$schfromdate', '$schtodate', '$schstatus', '$schcomment')";						
	 
		$val = $GLOBALS['db']->query($insSql);
		$id=$GLOBALS['db']->insert_id;
		if($val==1)
		{	
			$this->insertUpdateSchEmp($id,$schempls);			
			header('Location: assignschwork.php?ins=1&dep='.$schdepart);
		}
		else
		{
			header('Location: assignschwork.php?ins=0&dep='.$schdepart);
		}
	}     
}

//insert/update query for scheduleEmployees
function insertUpdateSchEmp($schid,$schempls)
{    
   //echo "insertUpdateSchEmp=".$schid;
   //print_r ("adas".$schempid);
   if($schid!='')
   {    
		$schempDel = "delete from schemployee where  scheduleid='".$schid."'";
		$val = $GLOBALS['db']->query($schempDel);
		
 	$schempSql = " select * from schemployee where  scheduleid='".$schid."'";
		
		$rstschemp = $GLOBALS['db']->query($schempSql);
		if(isset($rstschemp) and $rstschemp->num_rows>0)
		{
			while($rowschemp = $rstschemp->fetch_assoc())
			{
				foreach($schempls as $schempid)
				{
                	if($rowschemp['employeeid']!=$schempid)
					{     						           
					 	$insSql= "INSERT INTO `schemployee` (`schemployeeid`, `scheduleid`, `employeeid`) VALUES ('', '$schid', '$schempid')";				
						$val = $GLOBALS['db']->query($insSql);                
            		}                    
           		 }
        	}
   		}
		else
		{		
    		if(count($schempls)>0)
			{   
     			foreach($schempls as $schempid)
           		{                                
               		$insSql= "INSERT INTO `schemployee` (`schemployeeid`, `scheduleid`, `employeeid`) VALUES ('', '$schid', '$schempid')";										
      		  		$val = $GLOBALS['db']->query($insSql);
           		}
       		 }                    
    	 }  
	}    
}

function deleteSchData($schid)
{
	if(isset($schid) and $schid>0)
	{	 							
					$query="select sact.scheduleid
								from
									schactivity sact,
									activitylog act
								where 
									sact.schactivityid=act.schactivityid
								and
									sact.scheduleid='  ".$schid."'								
								";
					$result=$GLOBALS['db']->query($query);
					if(isset($result) and $result->num_rows>0)
					{
						//echo "cannot be deleted";
						header('Location: assignschwork.php?error=del');
						exit;
					}
					else
					{
						$query1 = "DELETE FROM schemployee WHERE schemployee.scheduleid = '$schid'";
						$val1 = $GLOBALS['db']->query($query1);
						$query = "DELETE FROM schedule WHERE schedule.scheduleid = '$schid'";
						$val = $GLOBALS['db']->query($query);		
						$query2 = "DELETE FROM emprequest WHERE emprequest.scheduleid = '$schid'";
						$val2 = $GLOBALS['db']->query($query2);						
						if(isset($val) and $val==1)
						{
							header('Location: assignschwork.php');
							exit;
						}
						else
						{
							header('Location: assignschwork.php?error=del');
							exit;
						}
					}
					
		//old code			
		/*$query = "DELETE FROM schedule WHERE schedule.scheduleid = '$schid'";
		$val = $GLOBALS['db']->query($query);
		if(isset($val) and $val==1)
		{
			header('Location: assignschwork.php');
			exit;
		}
		else
		{
			header('Location: assignschwork.php?error=del');
			exit;
		}*/
	}
}
function get_empreq($schid)
{
	 $empQuery="SELECT se . * , e.employeeid,e.fullname
				FROM `schemployee` AS se, employee AS e, schedule AS s
				WHERE se.scheduleid = s.scheduleid
				AND s.departmentid != e.departmentid
				AND e.employeeid = se.employeeid
				AND se.scheduleid ='".$schid."'
				";
	$empresult = $GLOBALS['db']->query($empQuery);
	$view="";
	if(isset($empresult) and $empresult->num_rows>0) 
	{
		$view.="
				<td  colspan=\"2\" align=\"left\"  class=\"Form_txt\">
				<select name=\"empreq[]\"  id=\"empreq\" size=\"55\" multiple=\"multiple\" style=\"width:175px;height:150px;\">	
				<optgroup label=\"Other departments\">					
				";	
							//$empreq=$schactivity->get_empreq($schid);
							//print $empreq;										

		while($row=$empresult->fetch_assoc())
		{
			$view.="<option value=\"".$row['employeeid']."\">".$row['fullname']."</option>";	
			
		}
		$view.="</optgroup>
					</select>						
					</td>";	
	}	
	return $view;	
}
function get_employees($super_id){ 
	$query = "select s.employeeid,e.fullname "
	." from empsupervisor as s, employee as e "
	." where s.supervisorid=".$super_id." and s.isactive='1' and e.employeeid=s.employeeid";
	$result = $GLOBALS['db']->query($query);
	return $query;
	
}


function get_report_form($userid){ 
/*/ To get the roles of the current user
  $query = "select userroles.rolesid as rolesid,rolename from userroles,roles where userroles.userid=\"$userid\" and userroles.rolesid=roles.rolesid";
	$result = $GLOBALS['db']->query($query);
				echo "<option value=\"0\">Select a Role</option>";
		if(isset($result) and $result->num_rows>0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value=\"" . $row['rolesid']."\"";
			if($row['rolesid']==$id) echo " selected=\"selected\">";
			echo  $row['rolename'] . "</option>";
			}
		} */
}




//get all the schedules from the supervisor for schactivity
function get_schedule($emp_power,$supervisorid,$scheduleid){

    $schedules="";
  
 if( $emp_power['is_super']==1)
 {
  
    $query = " select scheduleid,description,";
    $query .=" CONCAT(DATE_FORMAT(schfromdate,'%d/%m/%Y'),' - ',DATE_FORMAT(schtodate,'%d/%m/%Y')) AS time,";
    $query .=" schcomment from schedule ";
    $query .=" WHERE supervisorid =".$supervisorid." AND schstatus!='completed' ";
 } 
 else if( $emp_power['is_admin']==1)
 {
  
    $query1 = " SELECT scheduleid,description,";
    $query1 .=" CONCAT(DATE_FORMAT(schfromdate,'%d/%m/%Y'),' - ',DATE_FORMAT(schtodate,'%d/%m/%Y')) AS time,";
    $query1 .=" schcomment from schedule ";
    $query   = $query1 ." WHERE supervisorid =".$supervisorid." AND schstatus!='completed' ";
    $query  = $query. " UNION ";
    $query  = $query1." ".$query;
    $query .=" WHERE departmentid IN (".$emp_power['isadm_deptid'].") AND schstatus!='completed' ";
 } 
  
    $result = $GLOBALS['db']->query($query);
        
   // $schedules.="<select name='scheduleid' id='scheduleid' title='Schedule Type'  style='width:150px;'>";

    if(isset($result) and $result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
        $schedules.="<option value=".$row['scheduleid']." ";
 	if($row['scheduleid']==$scheduleid)  
	$schedules.= "selected=\"selected\" ";
	 $schedules.=" title=\"".$row['schcomment'].", From-To =".$row['time']."\">".$row['description']."</option>";
        }
    }
    //$schedules.="</select>";
    return $schedules;
}

//
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


function get_activity($id,$actid){
		$activity="";
		$query = " select activitytypeid,activityname,activitydesc from activitytype WHERE isschedule='1' ORDER BY activityname ";
		$result = $GLOBALS['db']->query($query);
			
		$activity.="<select name=".$id." id=".$id." title='activity type'  style='width:150px;'>";
		$activity.="<option value=\"0\">Select Activity Type</option> ";
		
		if(isset($result) and $result->num_rows>0) {
			while($row = $result->fetch_assoc()) {
			    $activity.="<option value=\"".$row['activitytypeid']."\" ";
			if($row['activitytypeid'] == $actid){$activity.=" selected=\"selected\"";}
			    $activity.=" title=\"".$row['activitydesc']."\">".$row['activityname']."</option>";
			}
}
		return $activity;
}


function get_depemployee($supid,$deptid,$schid){
		$nemps =gne($emp_power); 
   $employee="";
   if($schid!='')
   {
           $query = " select schemployee.employeeid,fullname AS name,empname from employee,schemployee where employee.employeeid=schemployee.employeeid AND "
               ."  schemployee.`scheduleid`='".$schid."' AND employee.departmentid='".$deptid."' AND  employee.empstatus='active'  AND employeeid in (".$nemps .") ORDER BY name ";
   } else {
       
      $query = " select employeeid,fullname AS name,empname from employee,department
               where employeeid > 1 AND  department.`departmentid`='".$deptid."' "
			   ." AND employee.departmentid=department.departmentid  AND  employee.empstatus='active'  AND employeeid in (".$nemps .")  ORDER BY name ";
			   
   }
  
   $result = $GLOBALS['db']->query($query);

	
      $employee.="<select name='employeeid' id='employeeid'  title='Select Employee ' onChange='javascript:changeEmployee(this);'  style='width:150px;'>";
      //$employee.="<option value=\"\" >--Select--</option> ";
      if(isset($result) and $result->num_rows>0) {
      	while($row = $result->fetch_assoc()) {
      	$employee.= " <option value=\"".$row['employeeid']."\"";
      	if($row['employeeid'] == $supid){ 
      	$employee.= " selected=\"selected \"";
        }  
        $employee.= " title=\"".$row['empname']."\">".$row['name']."";
      	$employee.= " </option>";
      	
      	}
      }
      $employee.="</select>";
      return $employee;
}

function saveActvityData($actid,$actname,$actdesc,$actissch,$depid)
{
     //activitytypeid 	activityname 	activitydesc 	isschedule 	departmentid
         
      if(isset($actid) and $actid>0) {
		  $updActSql = "UPDATE  `activitytype` SET  activityname='$actname',`activitydesc` = '$actdesc', "
                     ." isschedule='$actissch',departmentid='$depid' "; 
    	     $updActSql.= " WHERE activitytypeid ='$actid' ";
			
			$val = $GLOBALS['db']->query($updActSql);
			if(isset($val) and $val==1) {
			   	    
			    header('Location: activity.php?ins=2&dep='.$depid);
				exit;
			} else {
   			header('Location: activity.php?ins=3&actid='.$actid.'&dep='.$depid);
   			exit;
   			}
   		}
   		else  {
			
              $insActSql= "INSERT INTO `activitytype` (`activitytypeid`,`activityname`, `activitydesc`, `isschedule`, `departmentid`) VALUES
      ('','$actname', '$actdesc','$actissch', '$depid')";					
      			
     			$val = $GLOBALS['db']->query($insActSql);
     			if($val==1){
     			   
     			    header('Location: activity.php?ins=1&dep='.$depid);
                }
     			else {
     			    header('Location: activity.php?ins=0&dep='.$depid);
                }
      }
      
     
      
      
}

// To pick User data to Edit
 function getData($schid) {
			$query = "select * from schedule where scheduleid = '$schid'";
			$result = $GLOBALS['db']->query($query);
    			if(isset($result) and $result->num_rows>0) {
		  	return $row = $result->fetch_assoc();
   	 	}
		}


// To list schedules  -  arg:Currentemplid,emp power,departmentid selected 
		 function viewschedules($suprid,$emp_power,$departid) {
			//echo $departid;
			
			if($emp_power['is_superadmin']==1 )
			{
			      $viewquery = "SELECT `scheduleid`,`supervisorid`,employee.fullname AS supervisor,`description`,`schfromdate`,`schtodate`,`schstatus`,`department`.`depname` AS dep "
			    ." FROM `schedule`,`employee`,`department` "
		    			 ." WHERE  department.departmentid=schedule.departmentid AND schedule.`supervisorid`= employee.`employeeid`  ";
                    
                  if($departid=='' || $departid=="0")
                     $viewquery .=" AND schedule.`departmentid` IN (".$emp_power['isadm_deptid'].")  ";  
                  else
                    $viewquery .=" AND schedule.`departmentid` = '".$departid."' ";  
           
            }
			
			else if($emp_power['is_admin']==1  )
			{
			      $viewquery = "SELECT `scheduleid`,`supervisorid`,employee.fullname AS supervisor,`description`,`schfromdate`,`schtodate`,`schstatus`,`department`.`depname` AS dep "
			    ." FROM `schedule`,`employee`,`department` "
		    			 ." WHERE  department.departmentid=schedule.departmentid AND schedule.`supervisorid`= employee.`employeeid` AND schedule.`departmentid` IN (".$emp_power['isadm_deptid'].")  ";
           
                 if($departid=='' || $departid=="0")
                     $viewquery .=" AND schedule.`departmentid` IN (".$emp_power['isadm_deptid'].")  ";  
                  else
                    $viewquery .=" AND schedule.`departmentid` = '".$departid."' "; 
           
            }
            else if($emp_power['is_hod'])
            {
                $viewquery = "SELECT `scheduleid`,`supervisorid`,fullname AS supervisor,`description`,`schfromdate`,`schtodate`,`schstatus`,`department`.`depname` AS dep  FROM `schedule`,`employee`,`department`   "
		    			 ."WHERE department.departmentid=schedule.departmentid AND department.departmentid='".$emp_power['ishod_deptid']."'  AND  schedule.`supervisorid`= employee.`employeeid` ";
            }
            else{ 
			
			  $viewquery = "SELECT `scheduleid`,`supervisorid`,fullname AS supervisor,`description`,`schfromdate`,`schtodate`,`schstatus`,`department`.`depname` AS dep  FROM `schedule`,`employee`,`department`   "
		    			 ."WHERE department.departmentid=schedule.departmentid AND `supervisorid`='".$suprid."' AND  schedule.`supervisorid`= employee.`employeeid`  ";
                }
			
			$viewquery .= " ORDER BY supervisor ";
			//echo $viewquery;
			
			$viewresult = $GLOBALS['db']->query($viewquery);
		  	if(isset($viewresult) and $viewresult->num_rows>0) {
        		$i=0;
        		
        		
				while ($viewrow = $viewresult->fetch_assoc()) {
					$i++;
					if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
					echo "<tr ".$class.">";
					echo "<td class=\"main_matter_txt\" width=\"50px\">" . $i . "</td>";
        	echo "<td ><a title=\"Click to Edit or Delete Schedule\" href=\"assignschwork.php?schid=";
					echo $viewrow['scheduleid'] . "\">";
					echo $viewrow['supervisor']  . "</a> </td>";
					echo "<td>".ucfirst( $viewrow['description']) . "</td>";
					//print "<input type='hidden' name='es_id' id='es_id' value='".$row['esid']."'/>";
					echo "<td >" . ymdToDmy($viewrow['schfromdate']) . "-". ymdToDmy($viewrow['schtodate']) ."</td>";
					echo "<td >" . ucwords($viewrow['dep']) . " </td>";
					echo "<td >" . $viewrow['schstatus'] . " </td>";					
					echo "</tr>";
					
				}
				
			}
			else
			{
			    echo "<tr width=\"100%\"  align=\"center\" valign=\"middle\" style='border:1px  black;'>";
				echo "<td  colspan=\"6\" width='100%'><span class=\"warn\" > No Schedules Found </span> </td></tr>";
            }
		}
//17/03/2009
function get_nonschemployee($deptid,$schid){
	 
		 	$nemps = gne($emp_power); 
				
				
   $employee="";
   $query = " select employeeid, fullname, empname  from employee where departmentid='$deptid' AND employeeid in (".$nemps .") AND empstatus ='active' " ;
  if($schid!='') 
   $query .=" AND employeeid NOT IN (select employeeid from schemployee  where  schemployee.scheduleid = '$schid') ";
    $query .=" order by fullname ";
   //if($deptid!='')
    //    echo $query .= " where departmentid = ".$deptid;
//  echo $query;
   $result = $GLOBALS['db']->query($query);
 // $employee.="<select name='employeeid' id='employeeid' title='Select Employee ' onChange='javascript:changeEmployee(this);'  style='width:150px;'>";
     // $employee.="<option value=\"0\" >--Select--</option> ";
      if(isset($result) and $result->num_rows>0) {
      	while($row = $result->fetch_assoc()) {
      	$employee.= " <option value=\"".$row['employeeid']."\"";
      	if($row['employeeid'] == $emp_id){ 
      	$employee.= " selected=\"selected \"";
        }  
        $employee.= " >".$row['fullname']."";
      	$employee.= " </option>";
      	
      	}
      }
      else{
      	$employee.= "<option>No Employees</option>";
			}
      return $employee;
} 
function get_schemployee($deptid,$schid=''){
				$nemps =gne($emp_power); 
   $employee="";
   
   $query = " select schemp.employeeid AS employeeid, fullname ,empname  from employee emp,schemployee schemp ";
   if($deptid!='')
         $query .= " where departmentid = ".$deptid;
         $query .= " AND schemp.scheduleid = ".intval($schid);
     $query .= " AND schemp.employeeid = emp.employeeid and emp.employeeid in (".$nemps .") order by fullname ";
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
function getDepartmentForSch($emp_power,$departid)
{
    //echo $departid;
    $depList="";
   
/*
    if($emp_power['is_superadmin']==1){
     
        $quearyDep="select * from department  ";
        
    }
    else if($emp_power['is_admin']==1){
          
          $quearyDep="select * from department WHERE departmentid IN (".$emp_power['isadm_deptid'].") ";
    }
   
    else if($emp_power['is_hod']==1){
        $quearyDep="select * from department WHERE departmentid IN (".$emp_power['ishod_deptid'].") ";
    }
    
    //if($departid!='')
    //        $quearyDep.=" AND  departmentid = '".$departid."' ";
    
           $quearyDep.= " order by depname ";
           
           
    $resultDep = $GLOBALS['db']->query($quearyDep);
    
           
           
*/
           
$resultDep=get_new_dept_list($emp_power['emp_id'],$emp_power) ;
         if(isset($resultDep) and $resultDep->num_rows>0) {
      	    $depList.= " <select id=\"departmentid\" name=\"departmentid\" style=\"width:150px\" onChange=\"ChangeDepart();\">";    
      	    
      	   // if($emp_power['is_superadmin']==1 || $emp_power['is_admin']==1){
                             $depList.= " <option value=\"0\" title=\"View All Department Schedules\">Select</option>  ";
                 //        }
      	    
      	    while($rowDep = $resultDep->fetch_assoc()) {
                                      
             $depList.= " <option  value=\"".$rowDep['departmentid']."\"";
                        if($departid!='' && $departid==$rowDep['departmentid']){
                            $depList.=" selected=\"selected\" ";
                        }
                        $depList.= " title=\"".$rowDep['depname']."\">".$rowDep['depname']."";
                        $depList.= " </option>";
                      
                     
            }
            $depList.= " </select>";
     
	 }
     else
     {
         echo "No Department"; 
     }
   
   
 return $depList;
}
//activity type page functions
function getDepForActivity($emp_power,$departid)
{
   $depList="";
   
    if($emp_power['is_superadmin']==1){
        $quearyDep=" select * from department where departmentid order by depname ";
    }
    else {
          
          $quearyDep=" select * from department where departmentid IN (";
         
        
        if ($emp_power['is_admin']==1) {
                $quearyDep .=  $emp_power['isadm_deptid'] . ",";
            }
        else{
             $quearyDep .=  "-1, "; // no department for admin.
         }
        if ($emp_power['is_hod']==1) {  $quearyDep .=  $emp_power['ishod_deptid'] ;
        }else{
            $quearyDep .=  "-1";    // no dept for HOD.
        }
         $quearyDep .=  ") order by depname";
          
    }
    

    
    $resultDep = $GLOBALS['db']->query($quearyDep);
    
         if(isset($resultDep) and $resultDep->num_rows>0) {
      	    $depList.= " <select id=\"departmentid\" name=\"departmentid\" style=\"width:180px\" onChange=\"ChangeDepart();\">";    
      	    
      	     if($emp_power['is_superadmin']==1 ){
                             $depList.= " <option value=\"all\" title=\"View All Department Schedules\">All</option>  ";
                             $depList.= " <option value=\"0\" ";
                             if($departid=="0"){
                                  $depList.=" selected=\"selected\" ";
                              }
                             $depList.= " title=\"Non Departmentwise Activities\">Non Department</option>  ";
                         }
      	    
      	    while($rowDep = $resultDep->fetch_assoc()) {
                                      
                        $depList.= " <option value=\"".$rowDep['departmentid']."\"";
                        if($departid==$rowDep['departmentid'] && $rowDep['departmentid']!='0'){
                            $depList.=" selected=\"selected\" ";
                        } 
                        $depList.= " title=\"".$rowDep['depdescription']."\">".ucwords($rowDep['depname'])."";
                        $depList.= " </option>";
                      
                     
            }
            $depList.= " </select>";
     }
     else
     {
         echo "No Department"; 
     }
   
   
 return $depList;
   
   
   /* $depList="";
   
    if($emp_power['is_superadmin']==1){
        $quearyDep=" select * from department where departmentid ";
    }
    else if($emp_power['is_admin']==1){
          
          $quearyDep=" select * from department where departmentid IN (".$emp_power['isadm_deptid'].") ";
    }
   
   
    
    $resultDep = $GLOBALS['db']->query($quearyDep);
    
         if(isset($resultDep) and $resultDep->num_rows>0) {
      	    $depList.= " <select id=\"departmentid\" name=\"departmentid\" style=\"width:180px\" onChange=\"ChangeDepart();\">";    
      	    
      	     if($emp_power['is_superadmin']==1 || $emp_power['is_admin']==1){
                             $depList.= " <option value=\"0\" title=\"View All Department Schedules\">All</option>  ";
                             $depList.= " <option value=\"null\" title=\"Non Departmentwise Schedules\">None</option>  ";
                         }
      	    
      	    while($rowDep = $resultDep->fetch_assoc()) {
                                      
                        $depList.= " <option value=\"".$rowDep['departmentid']."\"";
                        if($departid==$rowDep['departmentid']){
                            $depList.=" selected=\"selected\" ";
                        }
                        $depList.= " title=\"".$rowDep['depdescription']."\">".$rowDep['depname']."";
                        $depList.= " </option>";
                      
                     
            }
            $depList.= " </select>";
     }
     else
     {
         echo "No Department"; 
     }
   
   
 return $depList;
 */



}

function viewActivityList($departid,$emp_power){
  //  print_r($emp_power);
    //$depid_list=$emp_power['emp_deptid'].",".$emp_power['isadm_deptid'].",".$emp_power['ishod_deptid'];
    if($emp_power['is_superadmin']==1  )
   // if($emp_power['is_superadmin']==1)
			{
			        
              $viewquery = "SELECT a.activitytypeid,a.activityname,a.activitydesc,a.isschedule sch,d.depname AS dep "
			                             ." FROM activitytype as a , department as d"
			                             ." WHERE ( d.departmentid = a.departmentid )";
			          if($departid !='' && $departid !="0" && $departid !="all")
                            {        
                                $viewquery .=" AND a.departmentid ='".$departid."' ";                      
                            }
                            else{
                                  if($departid =="0")
                                  {
                                       $viewquery ="  SELECT a.activitytypeid,a.activityname,a.activitydesc,a.isschedule,'Nil' AS dep "   
                                   ." FROM activitytype as a "
                                   ." WHERE ( a.departmentid =0  ) ";
                                  }else
                                   { 
                                   $viewquery .=" UNION SELECT a.activitytypeid,a.activityname,a.activitydesc,a.isschedule,'Nil' AS dep "   
                                   ." FROM activitytype as a "
                                   ." WHERE ( a.departmentid =0  ) ";
                                   }
                               }
                
            }
            else if($emp_power['is_admin'] =='1' ){
            	$viewquery = "SELECT a.activitytypeid,a.activityname,a.activitydesc,a.isschedule sch,d.depname AS dep "
			                             ." FROM activitytype as a , department as d"
			                             ." WHERE  d.departmentid = a.departmentid 
			                             and a.departmentid in (".$emp_power['isadm_deptid'].")   ";
            	
					}
					else if($emp_power['is_hod'] =='1' ){
            	$viewquery = "SELECT a.activitytypeid,a.activityname,a.activitydesc,a.isschedule sch,d.depname AS dep "
			                             ." FROM activitytype as a , department as d"
			                             ." WHERE  d.departmentid = a.departmentid 
			                             and a.departmentid in (".$emp_power['ishod_deptid'].")   ";
            	
					}
			
	//echo $viewquery;
			$viewresult = $GLOBALS['db']->query($viewquery);
			 //echo $viewquery1;
			//print  ">>>".$viewresult_test."<<<";
			 //   if($viewresult_test) print "succcessfull";else print " not  successful";
			 //$viewresult = $GLOBALS['db']->query($quearyDep);
		  	
		  	//echo "asdas=".$viewresult;
		  	//echo $viewquery;
		  	
			
			
			if(isset($viewresult)&&( $viewresult->num_rows>0)){
        		$i=0;
        	    while ($viewrow = $viewresult->fetch_assoc()) {
        	    	$i++;
        	    	if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
					echo "<tr ".$class.">";
					echo "<td >" . $i . "</td>";
        			echo "<td ><a title=\"Click to Edit or Delete Activity \" href=\"activity.php?actid=";
					echo $viewrow['activitytypeid'] . "\">";
					echo $viewrow['activityname']  . "</a> </td>";
					echo "<td >";
					     echo  empty($viewrow['activitydesc'])?"&nbsp;":$viewrow['activitydesc'] . " </td>";
								
					echo "<td >";
					if($viewrow['sch']==0)
					        echo "No";
					else
					    echo "yes";
					
					echo "</td><td>"; 
					          echo empty($viewrow['dep'])?"Nil":$viewrow['dep']. " </td>";
					echo "</tr>";
					
				}
				
			}
			else
			{
			    echo "<tr width=\"100%\" align=\"center\" valign=\"middle\" style='border:1px  black;'>";
				echo "<td colspan=\"5\" class=\"warn\" > No Activity Found  </td></tr>";
            }

}
// To pick User data to Edit
 function getActivity($actvid) {
			$query = "select * from activitytype where activitytypeid = '$actvid'";
			$result = $GLOBALS['db']->query($query);
    			if(isset($result) and $result->num_rows>0) {
		  	return $row = $result->fetch_assoc();
   	 	}
}
//delete activity
function deleteActData($actid)
{
    if(isset($actid) and $actid>0) {
			$query = "DELETE FROM activitytype WHERE activitytype.activitytypeid = '$actid'";
			$val = $GLOBALS['db']->query($query);
			if(isset($val) and $val==1) {
				header('Location: activity.php');
				exit;
			} else {
			header('Location: activity.php?error=del');
			exit;
			}
}
}
//**********************************************************************
//// RAFEEK/////////////////////////////////////////////////////////////
	
	
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
		// To save OR update assignactivity's records to db tbl
		public function insertassignactivity($toassignactivity,$tablename,$editid){
			if(isset($editid) and $editid > 0 ) {
				// To updae user record
				$query = "update $tablename set ";
				foreach( $toassignactivity as $key => $value){
					$query .= "$key = '$value', ";
				}
				$query = rtrim($query, ', ');
				$query .= " where $tablename.schactivityid = '$editid'";
				$GLOBALS['db']->query($query);
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
				$GLOBALS['db']->query($query);
			}
		}
		
		// To list assigned activity in a list from table
		// this function is using in assignactivity.php
		public function listschactivity($supid,$emp_id) {
			$query = "select schactivity.schactivityid,CONCAT(employee.firstname,' ',employee.lastname) AS name, activitytype.activityname, schactivity.activitydesc, ";
			$query .= " schactivity.activityfromdate,schactivity.activitytodate, schactivity.activitystatus ";
			$query .= " from employee, activitytype, schactivity,schedule ";
			$query .= " where schactivity.employeeid = employee.employeeid AND schactivity.activitytypeid = activitytype.activitytypeid";
			$query .= " AND schedule.scheduleid= schactivity.scheduleid ";
			$query .= " AND schedule.supervisorid=".$supid."  ";
		
		if(isset($emp_id) AND $emp_id > 0){
			$query .= " AND employee.employeeid =".$emp_id." ";
			}
			
			$result = $GLOBALS['db']->query($query);
			
			echo "<tr>
                  <td colspan=\"6\" align=\"center\" class=\"subhead\" >List of Assigned Works</td>
            </tr>";
			
			if(isset($result) and $result->num_rows>0) {
			
			$i=1;
				while ($row = $result->fetch_assoc()) {
					echo "<tr align=\"center\" bgcolor=\"#9ABCFF\" valign=\"middle\"  >";
        				echo "<td width=\"50px\">" . $i++ . "</td>";
        				echo "<td width=\"200px\" ><a href=\"assignactivity.php?empid=".$emp_id."&id=".$row['schactivityid']." \">" . $row['name'] . "</a></td>";
        				echo "<td width=\"200px\" >" . $row['activityname'] . "</td>";
        				echo "<td width=\"100px\" >" . $row['activitydesc']
        				
        				 . "</td>";
					echo "<td width=\"100px\" >" . ymdToDmy($row['activityfromdate']) ." to ". ymdToDmy($row['activitytodate']) . "</td>";
					echo "<td width=\"100px\" >" . $row['activitystatus'] . "</td>";
     					echo "</tr>";
				
				}
			}
		}
function getschactivity($schactivityid){
	$query = "select * from schactivity where schactivityid = '$schactivityid'";
			$result = $GLOBALS['db']->query($query);
    			if(isset($result) and $result->num_rows>0) {
		  	return $row = $result->fetch_assoc();		
		}
}	
}
?>
