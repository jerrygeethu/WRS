<?php
require_once('include.php');
$emp_power=emp_authority($_SESSION['USERID']);
if((isset($_POST['count']))&&($_POST['count']!="")){
require_once('class.mail.php');
//$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
//$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
$i=$_POST['count'];
$sanctioned=$_POST[$i.'sanctioned'];
$empid=$_POST[$i.'empid'];
$sanctionedby=$_SESSION['USERID'];
$sanctionremarks=$_POST[$i.'sanctionremarks'];
$leaveType=$_POST[$i.'leavetype'];
$leaveapplicationid=$_POST[$i.'leaveapplicationid'];
$emp_name=$_POST[$i.'emp_name'];
 $reason=$_POST[$i.'reason'];
$date=$_POST[$i.'date'];
$dd=trim($_POST[$i.'dd']);
$empEmail=$_POST[$i.'email'];
$message ="Leave Updated for  ".$emp_name." for ".$date;
							if($sanctioned=='3')
							{
								$cancelBy="cancelled by HOD ".$emp_power['$emp_name'];
								$query=" UPDATE 
														leaveapplication  
												SET 
														sanctioned = '".$sanctioned."', 
														sanctionedby='".$sanctionedby."', 
														sanctionremarks='".$sanctionremarks."',
														cancelled=1,	
														cancelreason='".$cancelBy."'
												WHERE 
														leaveapplicationid =".$leaveapplicationid;
							}
							else
							{
								$query=" UPDATE 
														leaveapplication  
											SET 
														sanctioned = '".$sanctioned."', 
														sanctionedby='".$sanctionedby."', 
														sanctionremarks='".$sanctionremarks."'
											WHERE 
														leaveapplicationid =".$leaveapplicationid;
							}																		

	$result = $GLOBALS['db']->query($query);
if($result ){
	if($sanctioned==2)$status= " Rejected ";else if($sanctioned==1)$status= " Approved ";else if($sanctioned==3)$status= " Cancelled ";
	$obj=new mail();
	
	$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
	$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
	$hremail=getsettings('hremail');
	$approoving=getMail();
	$data['from']=$approoving['mail'];
$data['to']=array($hremail,$empEmail);

 
$employee_power=emp_authority($empid);
					if( $employee_power['is_repto'] != ""){			 								
					$repto=explode(",",$employee_power['is_repto']);
					foreach($repto as $em){
					$data['to'][]=get_empid_email($em);
					}
					$data['to']= array_unique($data['to']);  
					}
						
						 

$data['bcc']=array('raghu.n@primemoveindia.com');
$data['subject']="Leave Application of ".$emp_name." is ".$status."[ ".$dd." ]";
$data['message']=" Hi, \n Leave Application of ".$emp_name." is ".$status."[ ".$dd." ]";
$data['message'].="\n Category :".$leaveType."\n Reason : ".$reason;  
		if($sanctionremarks!="") {$data['message'].="\n Remarks :".$sanctionremarks ;}
$data['message'].="\n ".$status." by ".$approoving['name']." on ".$today." \n  \n  \n 
Thanks \n  
Primemove Reporting system.\n  \n  \n  \n  \n  \n  
";

$data['ishtml']=false ;
//printarray($data);
$value=$obj->mailsend($data);

		//$message .="<br/>Email sent to ".$emp_name."";
		$message.=" <br/> Mail sent to ";
		foreach($data['to'] as $tomails)
		{
		$message.=" <br/>".$tomails;
		}
}
}
else
{
	$emp_name="";
	$date="";
	$message="";	
}


function getMail(){
	$empQuery=" select email,fullname from employee where  employeeid='".$_SESSION['USERID']."' ";
	$resultEmpQuery = $GLOBALS['db']->query($empQuery);
		if(isset($resultEmpQuery) and $resultEmpQuery->num_rows>0) {
			while($row = $resultEmpQuery->fetch_assoc()) {
				$data['mail']=$row['email'];
				$data['name']=$row['fullname'];
			}
		}
		return 	$data;
}
//Get leaves for approval
function get_leave_list(){
	$emp_power = emp_authority($_SESSION['USERID']);  
	//if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')){
		$dept_list="";
		
		if(($emp_power['is_superadmin']=="1")||($emp_power['is_admin']=="1")){
			$dept_list.=$emp_power['isadm_deptid'];
		}
		
		if($emp_power['is_hod']=="1"){ 
			$dept_list.=($dept_list!="")?",":"";
			$dept_list.=$emp_power['ishod_deptid'];
		}
$days_to_applyleave=getsettings('applyleave');
$tom=mktime(0, 0, 0, date("m")  , date("d")+$days_to_applyleave, date("Y"));
$day=date("Y-m-d", $tom); 
																
																
					$nemps="";											
			foreach(emp_list_after_reporting_to($_SESSION['USERID'],$emp_power) as $em){
				$nemps .=($nemps=="")? $em : ",".$em;
				}
				
				$dept_list1 = "";
			 $result11=get_new_dept_list($_SESSION['USERID'],$emp_power) ;
	while($row = $result11->fetch_assoc())
	{	
		$dept_list1 .= ($dept_list1=="")? $row['departmentid']: ",".$row['departmentid'];
	}
			
																																					
$query = "select 
																		app.leaveapplicationid,
																		app.employeeid,
																		DATE_FORMAT(app.fromdate,'%Y-%m-%d') as fromdate,
																		DATE_FORMAT(app.todate,'%Y-%m-%d') as todate,																	
																		app.fromoption,
																		app.tooption,
																		app.leavedays 	,
																		app.leavetypeid 	,
																		app.fromtime 	,
																		app.duration 	,
																		app.employeeremarks 	,
																		app.sanctioned 	,
																		app.sanctionedby 	,
																		app.sanctionremarks 	,
																		DATE_FORMAT(app.entrydatetime,'%d-%m-%Y') as entrydatetime,
																		e.fullname,
																		e.employeeid,
																		e.email,
																		t.name,
																		t.shortname 
												from 
																		leaveapplication as app,
																		employee as e,
																		leavetype as t 
												 where ";
											$query .= "	(	e.departmentid in(".$dept_list1.") or 	e.employeeid in (".$nemps.")	) and ";
											
											
										 $query .= "					e.employeeid=app.employeeid
												 and 
																e.employeeid != '".$_SESSION['USERID']."'																																	 	
												 and 
																(app.sanctioned=0 or app.sanctioned=2)
												 and 
																app.cancelled=0
												and
																t.leavetypeid=app.leavetypeid 
												and DATE_FORMAT(fromdate,'%Y-%m-%d') >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
												 order by  e.fullname, app.fromdate ";																																								
																																							
		$result = $GLOBALS['db']->query($query);
	$data['table']="";
		if(isset($result) and $result->num_rows>0) {
	$leave_details="";
	$i=0;
while($row = $result->fetch_assoc()) { 
	$i++;
	if($row['sanctioned']==3){$cancelled=" selected=\"selected\" ";}else $cancelled="";
	if($row['sanctioned']==2){$rejected=" selected=\"selected\" ";}else $rejected="";
	if($row['sanctioned']==0){$accepted=" selected=\"selected\" ";}else $accepted="";
	
	
	$leaveapplicationid=$row['leaveapplicationid'];
	$data['table'].="<tr>
																		<td>
																	".	$i."
																		</td>
																		<td><div class=\"permission\">
																		".ucfirst($row['fullname'])."<br/>Applied on:".$row['entrydatetime']."</div>
																		</td>
																		<td nowrap><div class=\"permission\">";
							$permissionID=getsettings('permissionid');
							if($permissionID!=$row['leavetypeid']){
														$dd['date']="				Date ".ymdToDmy($row['fromdate'])." ( ".$row['fromoption'];
																$dd['date'].= ($row['fromoption']=="full")?' Day )':' Section )';
																		 if(($row['todate']!="")&&($row['todate']!="0000-00-00")){
																			$dd['date'].= " to ";
																			$dd['date'].=ymdToDmy($row['todate'])." ( ".$row['tooption'];
																			$dd['date'].=($row['tooption']=="full")?' Day )':' Section )';
					}	
					}
					else{
							$hh=$row['duration'];
						if($hh==30)$hrs=$hh." Mins";
						else{
						$hhs=$hh/60;
						$hrs=$hhs." Hours";
						}
							$dd['date']=" Date ".ymdToDmy($row['fromdate'])."  from  ".$row['fromtime']." ( ".$hrs." )";
					}
						
									$data['table'].=ucfirst($dd['date'])."<hr></hr>
									
																		<label>Type</label>".$row['name']."  ( ".$row['shortname']." )</div >
																		</td>
																		<td width=\"150px\"><div class=\"permission\">
																		<label>Reason:</label>".ucfirst($row['employeeremarks'])."</div>
																		</td>
																		<td align=\"center\">
																		<form action=\"approveleave.php\" method=\"post\">
																		<input type=\"hidden\" value=\"".$dd['date']."\" id=\"".$i."dd\" name=\"".$i."dd\" />
																		
																		<input type=\"hidden\" value=\"".$row['name']."\" id=\"".$i."leavetype\" name=\"".$i."leavetype\" />
																		<input type=\"hidden\" value=\"".$row['employeeremarks']."\" id=\"".$i."reason\" name=\"".$i."reason\" />
																		<input type=\"hidden\" value=\"".$row['leaveapplicationid']."\" id=\"".$i."leaveapplicationid\" name=\"".$i."leaveapplicationid\" />
																		<input type=\"hidden\" value=\"".$row['fullname']."\" id=\"".$i."emp_name\" name=\"".$i."emp_name\" />
																		<input type=\"hidden\" value=\"".$i."\" id=\"count\" name=\"count\" />
																		<input type=\"hidden\" value=\"".ymdToDmy($row['fromdate'])." - ".ymdToDmy($row['todate'])."\" id=\"".$i."date\" name=\"".$i."date\" />
																		<input type=\"hidden\" value=\"".$row['email']."\"     id=\"".$i."email\"  name=\"".$i."email\"  />
																		
																		<textarea id=\"".$i."sanctionremarks\" name=\"".$i."sanctionremarks\" class=\"sup_remark_approveText\" >".ucfirst($row['sanctionremarks'])."</textarea>
																		<br/>
																		<select   class=\"leave_select\" id=\"".$i."sanctioned\" name=\"".$i."sanctioned\"  >
																		<option value=\"1\" ".$accepted.">Approve</option>
																		<option value=\"2\"  ".$rejected." >Reject</option>
																		<option value=\"3\"  ".$cancelled.">Cancel</option>
																		</select>
																		<input type=\"submit\" value=\"Save\"       />
																		<input type=\"hidden\" value=\"".$row['employeeid']."\"    id=\"".$i."empid\"  name=\"".$i."empid\"     />
																		</form>
																		</td>
																		</tr>																		
																		";		
}// while loop
}// if loop
return $data; 
}// function close
?>
