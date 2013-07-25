<?php
require_once('include.php');
$em_table="";
$resu_hod_assign="";
if((isset($_POST['deid']))&&($_POST['deid']!="")){
	$dpid=$_POST['deid'];
	if($_POST['emp']==""){$emp=0;}else{$emp=$_POST['emp'];}
	$hod_assign=" UPDATE department "
								." SET "
											." hod = '".$emp."' "
									." WHERE "
											." departmentid ='".$dpid."' ";
											
											
	 $sub=check_submission($emp,$dpid,1);
   if($sub==true){
	$res_hod_assign = $GLOBALS['db']->query($hod_assign);
	if($res_hod_assign){
		$resu_hod_assign=" HOD Assigned Successfully ";
	}
}
}




	if((isset($_POST['d']))&&($_POST['d']!="")){
	$deptid=$_POST['d'];
	$hodid=$_POST['h'];
	$depname=$_POST['n'];
	$depname=htmlspecialchars($depname);
	
	$query_em = "select "
	  								." title,fullname, employeeid "
	  					."from "
	  					      ." employee "
	  					." where "
	  					      ." departmentid='".$deptid."' order by fullname asc ";
	$result_em = $GLOBALS['db']->query($query_em);
	$em_table.="
		<form method=\"POST\" action=\"assignhoddep.php\">
		<div class=\"table_heading\">Assign HOD For ".$depname."</div>
		<table border=\"0\"  class=\"main_content_table\">
		                
		                
		                <tr >
		                    <th>
		                    Sl No:
		                    </th>
		                    <th>
		                    Name
		                    </th>
		                    <th>
		                    Select
		                    </th>
		                </tr>";
	if(isset($result_em) and $result_em->num_rows>0) {
		
		
		                $x=0;
	while($row_n = $result_em->fetch_assoc()){
		$x++;
		if(($x%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
		$em_table.="<tr ".$class.">
		<td>
		<label for=\"emp\" title=\" Click To Assign ".$row_n['fullname']." As Hod To ".$depname."\" >".$x."</label>
		</td>
		<td   >
		".$row_n['title'].". ".$row_n['fullname']." 
		</td>
		<td>
		
		<input type=\"radio\" value=\"".$row_n['employeeid']."\" name=\"emp\" id=\"emp\" title=\" Click To Assign ".$row_n['fullname']." As Hod To ".$depname."\"  ";
		
		if($row_n['employeeid']==$hodid){$em_table.=" checked=\"true\" ";}
		$em_table.=" />
		</td>
		</tr>";
		
	}
	$em_table.="<tr >
	<th colspan=\"3\">
	
	<input type=\"hidden\" value=\"".$deptid."\" name=\"deid\" id=\"deid\" />
	<input type=\"submit\" class=\"s_bt\"  value=\"Update\" title=\"Click To Update\"/>
	<input type=\"Reset\" class=\"s_bt\"  value=\"Cancel\" title=\"Click To Reset \"/>
	</form>
	</th>
	</tr>
	<tr ><th colspan=\"3\">***</th></tr> ";
	}
	else{
		$em_table.="<tr ><td colspan=\"3\" nowrap>No Employees Assigned To ".ucwords($depname)."</td ></tr><tr ><th colspan=\"3\">***</th></tr>";
	}
	
	
	$em_table.="</table></form>";
	}
	
	
	
function get_hod(){
	$pow_array=emp_authority($_SESSION['USERID']);
	//added hr login aslo	
	$query_hod_list="select departmentid,	hod, 	depname from department order by depname asc";
	
		$result_hod_list = $GLOBALS['db']->query($query_hod_list); 
		$result_hod_list1 = $GLOBALS['db']->query($query_hod_list); 
		if(($pow_array['is_hr']==1) && ($pow_array['is_adminemp']==1)){
		$dddd="";		
		while($row1 = $result_hod_list1->fetch_assoc()) {
		$dddd.=($dddd!="")?",":"";
		$dddd.=$row1['departmentid'];
		}
		$dept=explode(',',$dddd);
		$length_dep=count($dept); 
		}else if(($pow_array['is_admin']==1) ){   //if($pow_array['is_admin']==1){
		$dept=explode(',',$pow_array['isadm_deptid']);
		$length_dep=count($dept);
	} 
	if(isset($result_hod_list) and $result_hod_list->num_rows>0) {
			$i=0;
			$hod_list="<table border=\"0\" id=\"adm_list\" name=\"adm_list\"  class=\"main_content_table\" >";
			$hod_list.="<tr >
			
									<th nowrap>Sl No</th><th nowrap>Department</th><th>HOD</th><th>&nbsp;</th></tr>";
			while($row = $result_hod_list->fetch_assoc()) {
			 
				$i++;
				if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
				$hod_list.="<tr ".$class.">";
				$hod_list.="<td>";
				$hod_list.=$i;
				$hod_list.="</td>";
				$hod_list.="<td nowrap>";
				$hod_list.=ucwords($row['depname']);
				$hod_list.="</td>";
				$hod_list.="<td>";
				if($row['hod']==0){$hod_list.="Not Assigned";}
				else{
					$qu="select title,fullname from employee where employeeid='".$row['hod']."'";
					$res = $GLOBALS['db']->query($qu);
					$ro = $res->fetch_assoc();
					$hod_list.=ucwords($ro['title']).". ".ucwords($ro['fullname']);
					}
				$hod_list.="</td>";
				
				
				$hod_list.="<td align=\"center\" valign=\"middle\">";
			//print_r($dept);	
for($j=0;$j<=$length_dep;$j++){
	if($row['departmentid']==$dept[$j]){
		// to take care an logged in user has the privilage to set the HOD for that particular dept
		$hod_list.="<form method=\"POST\" action=\"assignhoddep.php\">";
		$hod_list.="<input type=\"submit\" class=\"s_bt\"  value=\"";
			if($row['hod']==0){
				$hod_list.=" Assign \"";
			}
			else{
				$hod_list.="Change\"";
			}
				$hod_list.="  title=\"Click To Assign / Change HOD of ".$row['depname']."\"/>";
				$hod_list.="<input type=\"hidden\" value=\"".htmlentities($row['depname'])."\" name=\"n\" id=\"n\" />";
				$hod_list.="<input type=\"hidden\" value=\"".$row['departmentid']."\" name=\"d\" id=\"d\" />";
				$hod_list.="<input type=\"hidden\" value=\"".$row['hod']."\" name=\"h\" id=\"h\" />";
				$hod_list.="</form>";
	}// if loop

}

				$hod_list.="</td>";
				
				
			
				$hod_list.="</tr>";
	
}
}
$hod_list.="<tr bgcolor=\"#ffffff\" align=\"center\"><th colspan=\"4\">****</th></tr></table>";
	return $hod_list;
}


	if(isset($_POST['tot_dep'])){
		$tot_dept=$_POST['tot_dep'];
		for($q=1;$q<=$tot_dept;$q++){
				$departmentid=$_POST[$q."_no"];
				$admin_dept_id=$_POST[$q."_admindepartid"];
				$employeeid=$_POST["employeeid"];
				$dept_chek=$_POST[$q."_dept"];
				$query_edit="";
					if($admin_dept_id!=""){
						if($dept_chek==on){
							//update
							$query_edit=" UPDATE admindepart "
								." SET "
											." employeeid = '".$employeeid."' ,"
											." departmentid='".$departmentid."' "
									." WHERE "
											." admindepartid ='".$admin_dept_id."' ";
							}
							else if($dept_chek!=on){
								// delete 
								$query_edit=" delete from  admindepart "
									." WHERE "
											." admindepartid ='".$admin_dept_id."' ";
							}
					}
					else{
						if($dept_chek==on){
						// insert new
						$query_edit="INSERT INTO admindepart( "
						." admindepartid , employeeid ,departmentid) "
						." VALUES (NULL , '".$employeeid."', '".$departmentid."') ";
					}
					else{
						// ignore_user_abort
						}
						
					}
					
					
					 $sub=check_submission($departmentid,$query_edit,$dept_chek);
        if($sub==true){
        	if($query_edit!=""){
					// execute queary here
					$result_edit = $GLOBALS['db']->query($query_edit);
					$res="  Departments Assigned Successfully  ";
				}
			}
			else{
				$res="   Data Already Entered ";
			}
				//	print $query_edit." == ";
					
		} // for loop
	}// function ends


function get_dep_list($e,$name){
	 	
	 	
	 	
	$query_a = "select "
	  								." departmentid, "
	  								." depname, "
	  								." depdescription "
	  					."from "
	  					      ." department order by depname asc";
	  					      
	$result_a = $GLOBALS['db']->query($query_a);
	if(isset($result_a) and $result_a->num_rows>0) {
			$t=0;
			$dep_result="<tr align=\"center\"><th nowrap>Sl No</th><th nowrap>Dept Name</th><th>Assign</th></tr>";
			while($row = $result_a->fetch_assoc()) {
				$t++;
				
				$query_d = "select "
	  											." admindepartid "
										." from "
													." admindepart "
										." where "
													." employeeid=\"".$e."\" "
													." and departmentid=\"".$row['departmentid']."\" ";
	  					      
	$result_d = $GLOBALS['db']->query($query_d);
if(isset($result_d) and $result_d->num_rows>0){
	$check=" checked=\"true\" ";
	$row_d = $result_d->fetch_assoc();
	$admindepartid=$row_d['admindepartid'];
	}
	else{
		$admindepartid="";
		$check="";
		}
				if(($t%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
				$dep_result.="<tr ".$class.">";
				$dep_result.="<td>";
				$dep_result.=$t;
				$dep_result.="</td>";
				$dep_result.="<td  title=\"Click Here To Assign ".$row['depname']." Department to ".$name."\" > ";
				$dep_result.=ucwords($row['depname']);
				$dep_result.="</td>";
				$dep_result.="<td >";
				$dep_result.="<input type=\"hidden\" value=".$admindepartid." name='".$t."_admindepartid' id='".$t."_admindepartid'/>";
				$dep_result.="<input type=\"hidden\" value=".$row['departmentid']." name='".$t."_no' id='".$t."_no'/>";
				$dep_result.="<input type=\"checkbox\" ".$check." name='".$t."_dept' id='".$t."_dept' title=\"Click Here To Assign ".$row['depname']." Department To ".$name."\" />";
				$dep_result.="</td>";
				$dep_result.="</tr>";
	}
	
	}
		else{
			$dep_result.=" <tr><th colspan=\"4\">No Departments Found</th></tr>";
		}
	
	
	
	return array($dep_result,$t);
}

function get_adm_list(){
	
	 $query = "select "
	  								." e.employeeid, "
	  								." e.title, "
	  								." e.fullname, "
	  								." e.contactno, d.depname, "
	  								." e.designation "
	  					."from "
	  					      ." employee as e , department as d"
	  					." where "
	  								." e.isadmin=\"1\" and d.departmentid=e.departmentid"
	  								." and e.empstatus='active' order by e.fullname asc";
	$result_q = $GLOBALS['db']->query($query);
		if(isset($result_q) and $result_q->num_rows>0) {
			$i=0;
			$result="<tr  ><th nowrap>Sl No</th><th nowrap>Name</th><th nowrap>Department</th><th nowrap >Designation</th><th >Contact No:</th><th >&nbsp;</th></tr>";
			while($row = $result_q->fetch_assoc()) {
				$i++;
				if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
				$result.="<tr valign=\"middle\" ".$class.">";
				$result.="<td>";
				$result.=$i;
				$result.="</td>";
				$result.="<td >";
				$result.=ucwords($row['title']).". ".ucwords($row['fullname']);
				$result.="</td>";
				$result.="<td >";
				$result.=ucwords($row['depname']);
				$result.="</td>";
				$result.="<td   >";
				$result.=ucwords($row['designation']);
				$result.="</td>";
				$result.="<td>";
				$result.=ucwords($row['contactno']);
				$result.="</td>";
				$result.="<td >";
				$result.="<form action=\"assignadmdept.php\" method=\"get\" >";
				$result.="<input type=\"hidden\" name=\"emp_id\" id=\"emp_id\" value=\"".$row['employeeid']."\" />";
				$result.="<input type=\"submit\" value=\"Select\" class=\"s_bt\" title=\" Click Here To Select ".$row['fullname']." To Assign Departments \" />";
				$result.="</form>";
				$result.="</td>";
				$result.="</tr>";
		}
		}
		else{
			$result=" <tr><td colspan=\"6\">No Admins to Assign</td></tr>";
		}
	return $result;
}

if(isset($_GET['emp_id']) && ($_GET['emp_id']!='')){
	 $e=$_GET['emp_id'];
	 $query_n = "select "
	  								." fullname "
	  					."from "
	  					      ." employee "
	  					." where "
	  								." employeeid='".$e."' ";
	$result_n = $GLOBALS['db']->query($query_n);
	$row_n = $result_n->fetch_assoc();
	$name=$row_n['fullname'];
} 
?>
