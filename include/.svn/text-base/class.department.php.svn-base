<?php
require_once('include.php');
class department {
	// To save OR update departments record to DB Table
	// This function using in editdepartment.php
	public function insertdepartment($depname,$depdescription,$superviser,$editid,$delid,$hod) {
		if(isset($delid) and $delid>0) {
			$query = "DELETE FROM department WHERE department.departmentid = '$delid'";
			$val = $GLOBALS['db']->query($query);
			if(isset($val) and $val==1) {
				header('Location: department.php?del=1');
				exit;
			} else {
			header('Location: department.php?del=0');
			exit;
			}
		}
		else if(isset($editid) and $editid>0) {
			$query = "UPDATE department SET depname = '$depname',hod = '$hod', depdescription = '$depdescription'";
			$query.="where departmentid = '$editid'";
			$GLOBALS['db']->query($query);
			header('Location: department.php');
			exit;
			
 
// // // // // // // // // // $query = "SELECT employeeid FROM employee WHERE departmentid = '$editid' AND emptype = 'supervisor'";
// // // // // // // // // // //echo $query = "select supervisor.supervisorid from supervisor,employee where supervisor.departmentid = '$editid' and  supervisor.employeeid = employee.employeeid";
// // // // // // // // // // $result = $GLOBALS['db']->query($query);
// // // // // // // // // // //$oldarray = $result->fetch_assoc();
// // // // // // // // // // $i=0;
// // // // // // // // // // $oldarray = array();
// // // // // // // // // //  while ($row = $result->fetch_assoc()) {
// // // // // // // // // // 	
// // // // // // // // // // 	$oldarray[$i] = $row['employeeid'];
// // // // // // // // // // 	//$oldarray .= array($i => $row['employeeid'][$i]);
// // // // // // // // // // 	//$oldarray.= $row['employeeid'][$i];
// // // // // // // // // // 	echo "<br>";
// // // // // // // // // // echo $oldarray[$i];
// // // // // // // // // // 		$i++;
// // // // // // // // // // }
// // // // // // // // // // 
// // // // // // // // // // $newarray = $superviser;
// // // // // // // // // // $arrayintersect = array_intersect($oldarray, $newarray);
// // // // // // // // // // echo "<br>";
// // // // // // // // // // echo "old".count($oldarray);
// // // // // // // // // // echo "<br>";
// // // // // // // // // // 
// // // // // // // // // // for($i=0; $i<count($oldarray); $i++) {
// // // // // // // // // // 	echo $oldarray[$i];
// // // // // // // // // // 	echo "<br>";
// // // // // // // // // // }
// // // // // // // // // // 
// // // // // // // // // // echo "new";
// // // // // // // // // // echo "<br>";
// // // // // // // // // // for($i=0; $i<count($newarray); $i++) {
// // // // // // // // // // 	echo $newarray[$i];
// // // // // // // // // // 	echo "<br>";
// // // // // // // // // // }
// // // // // // // // // // 
// // // // // // // // // // echo"intersect";
// // // // // // // // // // echo "<br>";
// // // // // // // // // // for($i=0; $i<count($arrayintersect); $i++) {
// // // // // // // // // // 	echo $arrayintersect[$i];
// // // // // // // // // // 	echo "<br>";
// // // // // // // // // // }
//echo count($oldarray);
//echo"new";
//echo count($newarray);
//echo "<br>";
//echo count($newarray);
		/*   if(isset($val) and $val == 1) {
			$arrcount = count($superviser);
				if(isset($arrcount) and $arrcount>0) {
					for($i=0; $i<count($superviser); $i++) {
					$superviser[$i];
						$query ="INSERT INTO supervisor (supervisorid, employeeid, departmentid) VALUES ('', '$superviser[$i]', '$editid')";
						$GLOBALS['db']->query($query);
					}
					 //This will give an error. Note the output
 					// above, which is before the header() call 
					//header('Location: department.php');
					//exit;
				}
			} */

		}
		else if(isset($depname) and $depname!='') {
			$query ="insert into department (departmentid, depname, depdescription) values ('', '$depname', '$depdescription')";
			$GLOBALS['db']->query($query);
			$deprid = $GLOBALS['db']->insert_id;
			if(isset($deprid) and $deprid!='') {
			for($i=0; $i<count($superviser); $i++) {
			$query ="INSERT INTO supervisor (supervisorid, employeeid, departmentid) VALUES ('', '$superviser[$i]', '$deprid')";
			$GLOBALS['db']->query($query);
			}
			/* This will give an error. Note the output
 			* above, which is before the header() call */
			header('Location: department.php');
			exit;
			}
			
		}
		
	}
	
	public function getsupervisors($depid) {
		$supid=null;			
		if(isset($depid) and $deptid!='') {
			 $query1 = "select supervisorid  from supervisor where departmentid = '$depid'";
			$result1 = $GLOBALS['db']->query($query1);
		}
		$i=0;
		while($rowsup = $result1->fetch_assoc()){
			$supid[$i] = $rowsup['supervisorid'];
			$i++;
		}
		$supid;
		return $supid;
	}
	// To list all employees in a select control
	//This function using in department.php created by (hmrsqt@gmail.com)
	public function listallemployees($depid) {
				

			
			if(isset($depid) and $depid>0) {
				$query = "SELECT 
														e.employeeid, 
														e.fullname 
									FROM 
														employee AS e 
								 WHERE  
												 		e.departmentid = ".$depid." order by e.fullname ";
			}
			
$query_get_hod=" select hod from department where departmentid=\"".$depid."\" ";
	$result_get_hod = $GLOBALS['db']->query($query_get_hod);
	$row_hod = $result_get_hod->fetch_assoc();
	$hod=$row_hod['hod'];
		//$query = "SELECT employee.employeeid, employee.firstname, employee.lastname FROM employee,supervisor WHERE ";
		//echo $query = "supervisor.employeeid != employee.employeeid and supervisor.departmentid = '$deptid'";
		
		$result = $GLOBALS['db']->query($query);$l="";
$l.= "<option value=\"0\">Select Employee</option>";
		if(isset($result) and $result->num_rows>0) {
			
			while($row = $result->fetch_assoc()) {
						
					$l.= "<option value=\"".$row['employeeid']."\"";
						if($row['employeeid']==$hod) $l.= " selected=\"selected\" ";
					$l.= ">" . $row['fullname'] . "</option>";	
		
			
		}
	}
	return $l;
}

	// This function using in view
	// To list department list
	public function showdepartments($emp_power){
		
		if(($emp_power['is_superadmin']==1) || (($emp_power['is_adminemp'] ==1)||($emp_power['is_hr'] ==1)))
		{
		    $query = "select departmentid, depname, depdescription from department order by depname";
		
		$result = $GLOBALS['db']->query($query);
		if(isset($result) and $result->num_rows>0) {
		$i=0;
			while ($row = $result->fetch_assoc()) {
					$i++;
					if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
				echo "<tr ".$class.">";
					echo "<td  >" . $i . "</td>";
					echo "<td  >" . ucwords($row['depname']) . "</td>";
					echo "<td   >" . ucfirst( $row['depdescription']) . "</td>";
					//echo "<td style=\"border-bottom:solid 1px;\" align=\"center\"><a href=\"editdepartment.php?id=";
					
					//echo $row['departmentid'] . "title='Click to Edit or Delete'>Edit...</a></td>";

					echo "<td align=\"center\">";
					echo "<input title=\"Click to Edit or Delete\" type=\"button\" class=\"s_bt\" value=\"Edit\" ";
			echo " onClick=\"javascript:document.location.href='editdepartment.php?id=".$row['departmentid']."'\" ";
					echo " /></td>";
				echo "</tr>";
			}
		 }
        }			
	}
	
	public function getdepartment($deptid) {
			$query = "select departmentid,depname,depdescription from department where departmentid = '$deptid'";
			$result = $GLOBALS['db']->query($query);
			if(isset($result) and $result->num_rows>0) {
					$row = $result->fetch_assoc();
			}
			$query2 = "select supervisor.supervisorid,CONCAT(employee.firstname,' ',employee.lastname) AS name";
			$query2 .= " from supervisor,employee where supervisor.departmentid = '$deptid' ";
			$query2 .= "and  supervisor.employeeid = employee.employeeid";
			$result2 = $GLOBALS['db']->query($query2);
		if(isset($result2) and $result2->num_rows>0)
   		{
   			while($row2 = $result2->fetch_assoc())
   			{
   				for($i=0;$i<count($row2);$i++){
					$supr[$row2['supervisorid']]= $row2['name'];
				}
			}
		}
		$rows[0]=$row;
   		$rows[1]=$supr;
   		return $rows;
	}
}
?>
