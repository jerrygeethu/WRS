<?php
require_once('include.php');
//require_once('include/schedule_functions.php');
require_once('include/class.mail.php');	
	class employee {

		// To save OR update User's records to db tbl
		public function insertemployee($toemployee,$editid,$delid) {
			$pass = '';  // this is employee password
			//$password=md5($_POST['password']);
			//$row["pwd"]=$password; pwd
		if((isset($toemployee['pwd']) )&&($toemployee['pwd']!="")){
			$pass = $toemployee['pwd'];
			$toemployee['pwd'] = md5($pass);
		}

			if(isset($delid) and $delid>0) {
				$query = "DELETE FROM employee where employee.employeeid = '$delid'";
				$val = $GLOBALS['db']->query($query);
			if(isset($val) and $val==1) {
				header('Location: employee.php?del=1');
				exit;
			} else {
				header('Location: employee.php?del=0');
				exit;
			}
			}
			
			if(isset($editid) and $editid > 0 ) {
			   //departmentid 	hod 	depname 	depdescription 
			   //$chkhodquery = "SELECT `hod` FROM `department` WHERE hod='".$editid."'";
			   //$chkhodrst = $GLOBALS['db']->query($chkquery); 
				$emp_power = emp_authority($editid);
			   if($emp_power['is_hod']==1 && $emp_power['ishod_deptid']!=$toemployee['departmentid']) {
				      $test = 3;    
                }
                //else
                //{
			    
				// To updae user record
				$query = "update employee set ";
				foreach( $toemployee as $key => $value){
				
				
				
				
					$query .= "$key = '$value', ";
				}
				$query = rtrim($query, ', ');
				$query .= " where employee.employeeid = '$editid'";
				//echo "q====".$query;
				$val = $GLOBALS['db']->query($query);
				if($toemployee['isadmin']!=1) {
					$query = "DELETE FROM admindepart WHERE admindepart.employeeid = '$editid'";
					$GLOBALS['db']->query($query);
				}
				
				if($val==1 && $test == 3){//Make hod of department null 
						
						$chkhodquery = "UPDATE  FROM `department` SET hod=null WHERE departmentid='".$toemployee['departmentid']."'";
						//header('Location: employee.php?msg=3&d='.$toemployee['departmentid']);
						//exit;
				}
				
				
				/* This will give an error. Note the output
 				* above, which is before the header() call */
				header('Location: viewemployee.php?d='.$toemployee['departmentid']);
				exit;
               		}
			else
			{
				
			$chkquery = "SELECT `employeeid`,`empname` FROM `employee` WHERE empname='".$toemployee['empname']."'";
				$chkrst = $GLOBALS['db']->query($chkquery);
                
                if(isset($chkrst) and $chkrst->num_rows>0) {
				      $test = 2;
                }
                else
                {
                  $query = "insert into employee (";
                    foreach( $toemployee as $key => $value){
                        $query .= "$key, ";
                    }
                    $query = rtrim($query, ', ');
                    $query .= ") values (";
                    foreach( $toemployee as $key => $value){
                        $query .= "'$value', ";
                    }
                    $query = rtrim($query, ', ');
                    $query .= ")";
                    $test = $GLOBALS['db']->query($query);
            }
				if($test == 1)
				{			
						//send mail to employee
						$mailtest = $this->sendMailToEmployee($toemployee,$pass,"new");
						//if($mailtest == 1) 
						{		
								header('Location: employee.php?msg=1&d='.$toemployee['departmentid']);
								exit;
						}						
				}
				else if($test==2)
				{
					header('Location: employee.php?msg=2&d='.$toemployee['departmentid']);
					exit;
				} 
                				    
		}
	}
	
	//function
	
	function sendMailToEmployee($toemployee,$pass,$value='')
	{	
		switch($value)
		{	
		case 'new':
		 		$emp_power = emp_authority($_SESSION['USERID']);
				$data['from']=$emp_power['emp_email'];//$data['from']=$GLOBALS['hr_email'];
				$data['to']=array($toemployee['email']);				
				$data['subject']='New Employee Added to Reporting system ';
				$data['message']="Hi, 
					\n  Login Information for " . $toemployee['fullname'] . " as follows
					\n username : ". $toemployee['empname'] ."
					\n password : ". $pass ."
					\n Use the link http://primemoveindia.com/hr to login
					\n Thanks
					\n HR";
			break;
		}
		//printarray($data);
		//exit;
		$obj=new mail();
		$value=$obj->mailsend($data);
		return $value;
		//$obj->msg;	
	}	
		//To list employees
		public function listemployee($emp_power, $depid)
		{	
		//  printarray($emp_power);
		   $query1 = "SELECT distinct e.employeeid as id,e.empname as en,e.fullname as fs,e.empstatus, department.departmentid as depid,department.depname as dep ,  "
            ." (select count(se.employeeid) from schemployee as se, schedule s "
            ." WHERE s.scheduleid = se.scheduleid and se.employeeid = e.employeeid and s.schstatus != 'completed') as scount ";
        
		if(($emp_power['is_superadmin']==1))
		{	
			       $query1.= " from employee as e ,department   WHERE  e.departmentid=department.departmentid and e.empstatus = 'active' ";
			       $query =  $query1;
		
        } 
				else if($emp_power['is_hr']==1){
					
			       $query1.= " from employee as e ,department   WHERE  e.departmentid=department.departmentid and e.empstatus = 'active' ";
			       $query =  $query1;
		
					
				}
        else if($emp_power['is_admin']==1)
        {
            
             $query1.= " from employee as e ,department "
                            ." WHERE  e.departmentid=department.departmentid and e.empstatus = 'active' ";
                            
             $query = $query1 . " AND department.departmentid IN (".$emp_power['isadm_deptid'].")  ";
            
        }
         else if($emp_power['is_hod']==1)
        {
           
			 $query1.= " from employee as e ,department "
                            ." WHERE  e.departmentid=department.departmentid and e.empstatus = 'active' ";
			  $query = $query1  ." AND department.departmentid IN (".$emp_power['ishod_deptid'].") ";
			
        }
		 else if($emp_power['is_super']==1)
        {
             
			 $query1.= " from employee as e ,department,schemployee "
                            ." WHERE  e.departmentid=department.departmentid and e.empstatus = 'active' ";
			  $query = $query1  ." AND (schemployee.scheduleid IN (".$emp_power['issup_schid'].")) AND (e.employeeid=schemployee.employeeid ) ";
			
        }
		
			if($depid!='' && $depid!=0  )   
			{
			    $query.=" AND e.departmentid =".$depid." ";			    
			 }
           		
			$query.= " AND e.employeeid >1 ";
			$query.=" ORDER BY dep,e.fullname ";
			
			
			$result = $GLOBALS['db']->query($query);
		  	if(isset($result) and $result->num_rows>0) {
        		$i=1;
        		print "<form action='' method='POST'>
						<table  border='0' width='100%'   class=\"main_content_table\" >";
        			
			echo ' <tr align="center" valign="middle" style="background-color:#CDCDCD;">
					<th width="10px" class="main_matter_txt">Sl No</th>
					<th width="125px" class="main_matter_txt">Name</th>
					<th width="80px" class="main_matter_txt">Login Name</th>
					<th width="100px" class="main_matter_txt">Department</th>
					<th width="100px" class="main_matter_txt">Last Report Date</th>
					<th width="100px" class="main_matter_txt">Assign work </th>
      		</tr>';
					
        			while ($row = $result->fetch_assoc())
					{
					//get employee last report date
					$reportQuery="SELECT DISTINCT max(DATE_FORMAT( act.logdate, '%Y-%m-%d' )) AS logdate
					FROM activitylog AS act, schactivity AS sact
					WHERE sact.schactivityid = act.schactivityid
					AND sact.employeeid = '".$row['id']."' ";
					$resultQuery=$GLOBALS['db']->query($reportQuery);	
					$rowQuery=$resultQuery->fetch_assoc();
					
					echo "<tr  align=\"center\" valign=\"middle\" style=\"border:1px black;\" ";
					echo (($i%2)==0)?"bgcolor=\"#d1d1d3\" ":"bgcolor=\"#FFFFFF\" "; 
					
					echo "><td  width=\"10px\">" . $i++ . "</td>";
        			if($emp_power['is_superadmin']=="1" ||  $emp_power['is_admin']=="1" || $emp_power['is_hr']=="1")
					{
        			    echo "<td class=\"Link_text\"   width=\"125px\"><a href=\"employee.php?edit=";
        			    echo $row['id'] . "\">";
        			    echo ucwords($row['fs']) . "</a> </td>";    
        			 }   
        			else
					{
        			    echo "<td   width=\"125\"><label>";
        			    echo ucwords($row['fs']) . "</label> </td>";    
					}
					echo "<td class=\"Link_text\"  width='80px'><label>" . $row['en'] . " ";
					print "</label></td>";
					echo "<td class=\"Link_text\"   width=\"100px\"><label>".ucwords($row['dep']). "</label> </td>";
					if($rowQuery['logdate']) { $lastReportDate=ymdToDmy($rowQuery['logdate']); } else { $lastReportDate="-"; }		
					echo "<td class=\"Link_text\"   width=\"100px\"><label>".$lastReportDate."</label> </td>";
					echo "<td class=\"Link_text\" align=\"left\"  width=\"168px\">";
					
					if(($emp_power['is_superadmin']=="1" )|| ($emp_power['is_admin']=="1") || ($emp_power['is_hr']==1))
					{
					 	print "<input type=\"button\" name=\"editemp\" id=\"editemp\"  onclick=\"javascript:editEmployee(".$row['id'].");\" value=\"Edit\"/>";
				  	}
				 
				 
				 
				 
				 
					if( ($_SESSION['USERID']!=$row['id']) && ($emp_power['is_hod']=="1" || $emp_power['is_super']=="1" ||  $emp_power['is_admin']=="1") &&  ($row['scount']>0) &&($row['empstatus']=="active")) //  employee itself
                    {
                       // print "&nbsp;<label><input type=\"button\" name=\"assign_work\" id=\"assign_work\"  onclick=\"javascript:assignwork('".$row['id']."','".$row['depid']."');\" value=\"Assign Work\"/></label></td>";
					}else{
					       // print "&nbsp;&nbsp;&nbsp;";
					}        
					echo "</tr>";
					$validfrom="";
				}
				//echo "</table></form>";
			}
			else
			{
					echo '<tr><td class="warn" align="center" colspan="5"><strong>No Records Found</strong></td></tr>';
			}
		}
		
		// Created by hmrsqt This function may be used in employeelist.php
		//
		//Modified NR 2010/07/12 : isnull(hod) included.
		public function employeenormallist($departid) {
		
	 $query = "SELECT 
					0 as slno, employee.fullname, employee.employeeid, 
					CONCAT(employee.title,' ' ,employee.fullname) as empname, 
			 		department.depname,
					employee.contactno, 
					employee.email,
					employee.address, department.hod
				FROM 
					employee, department 
				WHERE 
					employee.empstatus != 'inactive'
				AND
					employee.departmentid = department.departmentid 
				AND 
					employee.employeeid > 1 
				AND 
					employee.employeeid = department.hod";
			if(isset($departid) and $departid>0) $query .= " AND employee.departmentid in ($departid)";

			$query .= " UNION
				SELECT 
					1 as slno, employee.fullname, employee.employeeid, 
					CONCAT(employee.title,' ' ,employee.fullname) as empname, 
			 		department.depname,
					employee.contactno, 
					employee.email,
					employee.address, department.hod
				FROM 
					employee, department 
				WHERE
					employee.empstatus != 'inactive'
				AND
					employee.departmentid = department.departmentid 
				AND 
					employee.employeeid > 1 
				AND 
					(employee.employeeid != department.hod OR isnull(department.hod))" ;
			if(isset($departid) and $departid>0) $query .= " AND employee.departmentid in ($departid)";
		 	
			$query .= " order by depname, slno, fullname" ;
			$result = $GLOBALS['db']->query($query);
			if(isset($result) and $result->num_rows>0) {
        			$i=1;
				while ($row = $result->fetch_assoc()) {
					if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
						$records = "<tr valign=\"middle\" ".$class.">
        					<td width=\"3px\" align=\"center\"height=\"40px\" class=\"link_txt\">" . $i++ . "</td>
        					<td nowrap=\"true\" class=\"link_txt\">&nbsp;".$row['empname']."";

						if($row['hod'] == $row['employeeid']){ 
							$records .= "<br /><strong>(HOD)</strong>";
						}

						$records .= "</td>";
						if($departid<=0 || $departid ==''){ $records .= "<td class=\"link_txt\">&nbsp;".$row['depname']."</td>";}
        					echo $records .= "<td class=\"link_txt\">&nbsp;".$row['contactno']. "</td>
						<td class=\"link_txt\">&nbsp;<a href=\"mailto:".$row['email']. "\">".$row['email']. "</a></td>
						<td class=\"link_txt\">&nbsp;".$row['address']. "</td>
      					</tr>";
				}
				
			}
			
		}

		//To show title of employees in a dropdown from field enum 
		// This function using on employee.php file
		public function list_title($id) {
			$table = "employee";
			$column = "title";
			$options = getEnumValues($table,$column);
				for($i=0; $i<count($options); $i++) {
					echo "<option value=\"" . $j=$i+1 . "\"";
					if($options[$i]==$id) echo " selected=\"selected\"";
					echo ">" . $options[$i] . "</option>";
					}
		}
		
		//To show status of employees in a dropdown from field enum 
		// This function using on employee.php file
		public function listemployeestatus($empstatus) {
			$table = "employee";
			$column = "empstatus";
			$options = getEnumValues($table,$column);
				for($i=0; $i<count($options); $i++) {
					echo "<option value=\"" . $j=$i+1 . "\"";
					if($options[$i]==$empstatus) echo " selected=\"selected\"";
					echo ">" . $options[$i] . "</option>";
			}
		}
		
		//To show type of departments in a dropdown from table 
		// This function using on employee.php file
		public function listalldepartment($emp_power,$departmentid)
		{			
			//permission added for hr also
			if(($emp_power['is_superadmin']=="1") || ($emp_power['is_hr']=="1"))
			{
				$query = "SELECT departmentid, depname,depdescription FROM department ORDER BY depname";
       		}
			else if($emp_power['is_admin']=="1")
			{
				$query = "SELECT departmentid, depname,depdescription FROM department WHERE departmentid IN (".$emp_power['isadm_deptid'].") ORDER BY depname";
            }
			else if($emp_power['is_hod'] =='1')
			{
		 		$query = "SELECT 
				departmentid, 
				depname, 
				depdescription 
			  FROM 
				department 
			  WHERE 
				departmentid 
			  IN (".$emp_power['ishod_deptid'].") 
			  ORDER BY depname";		
	   		}
			$result = $GLOBALS['db']->query($query);
			while($row = $result->fetch_assoc())
			{
				echo "<option value=\"" . $row['departmentid'] . "\" title=\"".$row['depdescription']."\" ";
				if($row['departmentid']==$departmentid) echo " selected=\"selected\"";
					echo ">" . ucwords($row['depname']) . "</option>";	
			}			
		}

		// To pick employee data to Edit
		public function getData($id) {
			$query = "select employeeid, empno, departmentid, title, fullname, empname, pwd, dob, contactno, email, "
			. "address, isadmin, starthour, createdby, empstatus,designation from employee where employeeid = '$id'";
			$result = $GLOBALS['db']->query($query);
    			if(isset($result) and $result->num_rows>0) {
		  	return $row = $result->fetch_assoc();
   	 	}
		}
		
// 		// To delete a User
// 		public function deleteemployee($delid) {
// 			$query = "delete from userlogin where employeeid = '$delid'";
//    		$GLOBALS['db']->query($query);
// 		}
		 
		// To show Users records in  row wise
  		public function viewData() {
  		// To COUNT number of Rows (records) in DB_TB for set Sl# no
			$query = "select count(*) from employee";
			$result = $GLOBALS['db']->query($query);
			$rows = $result->fetch_assoc();
			$index = $rows['count(*)'];
			// To call all records from TB
			$query = "select emp.employeeid,emp.firstname,emp.lastname,empname";
			$query .= "emptype from employee emp"; 
			
      $result = $GLOBALS['db']->query($query);
		  if(isset($result) and $result->num_rows>0) {
        $i=1;
		    while ($row = $result->fetch_assoc() and $i <=$index ) {
		    	if($row['emptype']!='1')$color = "#00000";
		    	else $color = "#FFB8B8";
					echo "<tr bgcolor=" . $color . "><td>" . $i++ . "</td>";
		    	//echo "<tr><td>" . $i++ . "</td>";
					echo "<td><a href=\"editemployee.php?edit=";
					echo $row['employeeid'] . "\">";
					echo $row['firstname'] . "." . $row['lastname'] . "</a></td>";
					echo "<td>" . $row['empname'] . "</td>";
					echo "<td> ".$row['emptype'] ."</td>";
					echo "</tr>";
				}
			}
		}
		
		
		// To save admin settings
		public function saveadminsettings($editid,$name,$value) {
			if(isset($editid) and $editid > 0 ) {
				$query = "UPDATE user.settings SET id = '$editid', name = '$name', ";
				$query .= "value = '$value' where settings.id = '$editid'";
				$GLOBALS['db']->query($query);
			}
			else {
				$query = "INSERT INTO user.settings (id,name,value) ";
				$query .= "VALUES ('','$name','$value')";
				$GLOBALS['db']->query($query);
			}
		}
		
			// To show Admin settings
			public function showadminsettings() {
				$query = "SELECT id,name,value FROM settings";
				$result = $GLOBALS['db']->query($query);
		  if(isset($result) and $result->num_rows>0) {
        		$i=1;
		    while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td align=\"center\"><a href='settings.php?id=".$row['id'];
					echo "' title='Click to Edit or Delete'>" . $row['name'] . "</a></td>";
					echo "<td align=\"center\">" . $row['value'] . "</td>";
					echo "</tr>";
				}
			}
		}
		// To pick settings data for edit/delete
		public function pickforedit($id) {
			$query = "SELECT id,name,value FROM settings where id = '$id' ";
			$result = $GLOBALS['db']->query($query);
			return $row = $result->fetch_assoc();
		}
		//To delete Admin Settings
		public function deletesetting($id) {
			$query = "delete from settings where id = '$id'";	
			$GLOBALS['db']->query($query);
		}
		
		//Get department list for filtering employee list in viewemployee.php
		function getDepartmentList($emp_power,$departid) {
           
           //permission added for hr also
            if(($emp_power['is_superadmin']=="1") ||($emp_power['is_hr']=="1"))
               {
                    $query = "SELECT departmentid, depname,depdescription FROM department order by depname";
           }
            else if($emp_power['is_admin']){
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
		//	echo $query;
			$result = $GLOBALS['db']->query($query);
			if($emp_power['is_superadmin']=="1" || $emp_power['is_admin'])
				{
				    echo "<option value=\"0\"  >Select</option>";
                }
             
			while($row = $result->fetch_assoc()) {
				
				echo "<option value=\"" . $row['departmentid'] . "\" title=\"".$row['depdescription']."\" ";
				if($row['departmentid']==$departid) echo " selected=\"selected\"";
					echo ">" . ucwords($row['depname']) . "</option>";	
			}
        }

	//Get department list for filtering employee list in employeelist.php
	function getDepartmentListforemployeelist($departid) {
          	$query = "SELECT departmentid, depname,depdescription FROM department ORDER BY depname";
		$result = $GLOBALS['db']->query($query);
		echo "<option value=\"0\"  > All </option>";
		while($row = $result->fetch_assoc()) {
			echo "<option value=\"" . $row['departmentid'] . "\" title=\"".ucfirst($row['depdescription'])."\" ";
			if($row['departmentid']==$departid) echo " selected=\"selected\"";
			echo ">" . ucwords($row['depname'] ). "</option>";	
		}
       	 }

	}
?>
