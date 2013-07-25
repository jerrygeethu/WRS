<?php
	function show()
	{
		require_once('class.mail.php');
		$obj=new mail();
		$hremail=getsettings('hremail');
		
		$emp_power=emp_authority($_SESSION['USERID']);
		
		$query_dateworked="select dateworked from leavecoff where leavecoffid='". $_POST['coffid'] ."'";
		$result_dateworked = $GLOBALS['db']->query($query_dateworked);
		if(isset($result_dateworked) and $result_dateworked->num_rows>0)
		{
			while($row_dateworked = $result_dateworked->fetch_assoc())
			{
				$dateworked=$row_dateworked['dateworked'];
			}
		}
		
		##################################################################################################################################
		##################################################################################################################################
		##################################################################################################################################
		
			if(isset($_POST['btn']) and $_POST['status']=="approved")
			{
				$query_day="select leaveeligibilityid , sum(leavedays) as daysum from leaveeligibility where employeeid='". $_POST['empid'] ."' and leavetypeid='2'";
				$result_day = $GLOBALS['db']->query($query_day);
				if(isset($result_day) and $result_day->num_rows>0)
				{
					while($row_day = $result_day->fetch_assoc())
					{
						$total_day=$row_day['daysum']+$_POST['days'];
						$lvelgbltyid=$row_day['leaveeligibilityid'];
					}
				}
				
				$query_coff="select leavetypeid from leavetype where name='Compensatory Off'";
				$result_coff = $GLOBALS['db']->query($query_coff);
				if(isset($result_coff) and $result_coff->num_rows>0)
				{
					while($row_coff = $result_coff->fetch_assoc())
					{
						$coffid=$row_coff['leavetypeid'];
					}
				}
				
				$query_emp="select employeeid from leaveeligibility where employeeid='". $_POST['empid'] ."'  and leavetypeid='".$coffid."'";
				$result_emp= $GLOBALS['db']->query($query_emp);
				if(isset($result_emp) and $result_emp->num_rows>0)
				{
					$query1 = "UPDATE leaveeligibility SET leavedays='". $total_day."' where employeeid= '" . $_POST['empid'] ."' and leavetypeid = '".$coffid."'";
					$result1 =$GLOBALS['db']->query($query1);
					
				}
				else
				{
					$query1 ="insert into leaveeligibility(leaveeligibilityid, employeeid, leavetypeid, effectivedate, leavedays) values ('','" . $_POST['empid'] . "','" .$coffid."','" .$_POST['dateworked'] ."','".$total_day."')";
					$result1 =$GLOBALS['db']->query($query1);
					
					$lvelgbltyid=$GLOBALS['db']->insert_id;
				}	
					
				$query_lvcoff = "UPDATE leavecoff SET approvedby = '".$_SESSION['USERID']."', status = '" . $_POST['status'] . "', leaveeligibilityid = '". $lvelgbltyid ."' where leavecoffid = '" . $_POST['coffid'] ."'";
				$GLOBALS['db']->query($query_lvcoff);
				
				
				
					$message=" Compensatory Off ".ucfirst($_POST['status']);
					//$type=$_POST['status'];
					
/*
					$data1=$_POST['empid'];//get emp email
					$data['from']="geethusnny@gmail.com";
					$data['to']="geethusnny@gmail.com";
					$data2=emp_authority($_POST['empid']);
					$data['bcc']=array("geethusnny@gmail.com","geethu.primemove@gmail.com");
*/
					
					
					$data1=$_POST['empid'];//get emp email
					$data['from']=$emp_power['emp_email'];
					$data['to']=$_POST['email'];
					$data2=emp_authority($_POST['empid']);
					$data['bcc']=array($data2['dep_hod_email'],$hremail);
					
					
					$data['subject']="Compensatory Off applied for ".$_POST['name']." is ".$_POST['status'].".";	
					$data['message']="\nHi \nThe Compensatory Off applied for  ".$_POST['name']." ( ".ymdtodmy($dateworked)." ) is ".$_POST['status']." by ".$emp_power['emp_name']." on ".date("d/m/Y");
					$value1=$obj->mailsend($data);
					$message.=" <br/> Mail sent to ";
					$message.=" <br/>".$data['to'];
					foreach($data['bcc'] as $tomails)
					{
						$message.="<br/>".$tomails;
					}	
					
			}
			else if(isset($_POST['btn']) and $_POST['status']=="rejected")
			{
				//mail
					$query_lvcoff = "UPDATE leavecoff SET approvedby = '".$_SESSION['USERID']."', status = '" . $_POST['status'] . "', leaveeligibilityid = '". $lvelgbltyid ."' where leavecoffid = '" . $_POST['coffid'] ."'";
					$GLOBALS['db']->query($query_lvcoff);
					$message=" Compensatory Off ".ucfirst($_POST['status']);
					
					$data1=$_POST['empid'];//get emp email
					$data['from']=$emp_power['emp_email'];
					$data['to']=$_POST['email'];
					$data2=emp_authority($_POST['empid']);
					$data['bcc']=array($data2['dep_hod_email'],'hr@primemoveindia.com ');
					
					$data['subject']="Compensatory Off applied for ".$_POST['name']." is ".$_POST['status'].".";	
					$data['message']="\nHi \nThe Compensatory Off applied for  ".$_POST['name']." ( ".ymdtodmy($dateworked)." ) is ".$_POST['status']." by ".$emp_power['emp_name']." on ".date("d/m/Y");
					$value1=$obj->mailsend($data);
					$message.=" <br/> Mail sent to ";
					$message.=" <br/>".$data['to'];
					foreach($data['bcc'] as $tomails)
					{
						$message.="<br/>".$tomails;
					}	
			}
		##################################################################################################################################
		##################################################################################################################################
		##################################################################################################################################
		$query="select 
						emp.employeeid, emp.fullname, emp.email, dept.depname, l.dateworked, DATE_FORMAT(l.createddatetime,'%d/%m/%Y') as createddate, l.remarks, l.days, l.leavecoffid
					from 
						leavecoff l, employee emp, department as dept 
					where
						l.status='pending' and l.employeeid=emp.employeeid and emp.departmentid=dept.departmentid  order by l.createddatetime desc";
		$coff_details="";	
		$result=$GLOBALS['db']->query($query);
		$totoal_count=$result->num_rows;
		if(isset($result) and $result->num_rows>0)
		{
			//$i=$start;
			$i=0;
			$f=$result->num_rows;
			$table = "leavecoff";
			$column = "status";
			while($row=$result->fetch_assoc())
			{
				$i++;
				if(($i%2)<1) 
					$class=" class=\"even\" ";
				else
					$class="class=\"odd\" ";
				$coff_details.="<tr align=\"center\"".$class.">";    
				$coff_details.= "<td>" . $i . "</td>";
				$coff_details.= "<td><div style=\"background-color:#A6FFA6;padding:3px; border:1px solid #464646;\">" . ucwords($row['fullname']) . " <br/>(".$row['depname'].")</div></td>";
				$coff_details.= "<td><div style=\"background-color:#A6FFA6;padding:3px; border:1px solid #464646;\">" . $row['createddate'] . "</div></td>";
				$coff_details.= "<td><div style=\"background-color:#A6FFA6;padding:3px; border:1px solid #464646;\">";
																	if($row['days']==1)
																	{
																		$day="(Fullday)";
																	} 
																	else
																	{
																		$day="(Halfday)";
																	}
				$coff_details.=ymdtodmy($row['dateworked'])."<br/>".$day."</div></td>";
				$coff_details.= "<td><div style=\"background-color:#A6FFA6;padding:3px; border:1px solid #464646;\">" . ucfirst($row['remarks']) . "</div></td>";
				$options = getEnumValues($table,$column);
				$coff_details.="<td>
									<form name=\"approvecoff\" id=\"approvecoff\" action=\"approve_coff.php\" method=\"post\">
										<select id=\"status\" name=\"status\">";
											for($j=0; $j<count($options); $j++) 
											{
												$k=$j+1;
												$coff_details.= "<option value=\"" . $options[$j] . "\"";
												$coff_details.= ">" . $options[$j] . "</option>";
											}
										$coff_details.="</select>
										<input type=\"submit\" name=\"btn\" value=\"Save\"/>
										<input type=\"hidden\" name=\"coffid\" value=\"".$row['leavecoffid']."\"/>
										<input type=\"hidden\" name=\"empid\" value=\"".$row['employeeid']."\"/>
										<input type=\"hidden\" name=\"dateworked\" value=\"".$row['dateworked']."\"/>
										<input type=\"hidden\" name=\"days\" value=\"".$row['days']."\"/>
										<input type=\"hidden\" name=\"email\" value=\"".$row['email']."\"/>
										<input type=\"hidden\" name=\"name\" value=\"".$row['fullname']."\"/>
									</form>
								</td>";
				
			}
		}
		$data['table']=$coff_details;
		$data['last_count']=$i;
		$data['found_rows']=$f;
		$data['total_count']=$totoal_count;
		$data['save']=$_POST['btn'];
		$data['message']=$message;
		return $data;
	}
?>
