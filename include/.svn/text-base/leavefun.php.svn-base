<?php
	function editleave($arr,$empid,$lvdate,$editid)
	{
		if(isset($editid) and $editid>0 )
		{
			$emp_power=emp_authority($_SESSION['USERID']);
			if((($emp_power['is_hod'] ==1) or ($emp_power['is_hr'] ==1) or (!empty($emp_power['is_repto']))) and ($emp_power['is_admin'] !=1  or $emp_power['is_superadmin'] !=1) )
			{					
				$query = "UPDATE leavecoff SET dateworked = '".$lvdate."' , remarks='".$arr['remarks']."' ,days = '" . $arr['days'] . "' , status = 'pending' where leavecoffid = '" . $editid ."'";
				$GLOBALS['db']->query($query);
			}
			$msg['flag']=2;
			return $msg;
		}	
	}
	function delleave($arr,$lvdate,$delid)
	{
		$emp_power=emp_authority($_SESSION['USERID']);
		if(isset($delid) and $delid>0)//if(isset($delid) and $delid>0 )
		{
				$query = "delete from leavecoff where leavecoffid = '" . $delid ."'";
				$val = $GLOBALS['db']->query($query);
				if(isset($val) and $val==1) 
				{
					$msg['flag']=3;
					return $msg;	
				}
		}
	}
	
	function insertleave($arr,$empid,$lvdate)
	{
		if($_SESSION['EDIT']==1)
		{
			$emp_power=emp_authority($_SESSION['USERID']);
			$current_date=date("Y-m-d H-m-s");
			$query_day="select leaveeligibilityid , sum(leavedays) as daysum from leaveeligibility where employeeid='". $arr['employeeid'] ."' and leavetypeid='2'";
			$result_day = $GLOBALS['db']->query($query_day);
			if(isset($result_day) and $result_day->num_rows>0)
			{
				while($row_day = $result_day->fetch_assoc())
				{
					$total_day=$row_day['daysum']+$arr['days'];
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
			if((($emp_power['is_hod'] ==1) or ($emp_power['is_hr'] ==1) or (!empty($emp_power['is_repto']))) and ($emp_power['is_admin'] !=1  or $emp_power['is_superadmin'] !=1) )
			{
				$query_hod="select employeeid from employee where employeeid='".$empid."'";
				$result_hod = $GLOBALS['db']->query($query_hod);
				if(isset($result_hod) and $result_hod->num_rows>0)
				{
					$row_hod = $result_hod->fetch_assoc();
					$query ="insert into leavecoff(leavecoffid, employeeid, dateworked, remarks, allottedby, createddatetime, days)
					values ('','" . $arr['employeeid'] . "','" . $lvdate ."','".$arr['remarks']. "', '".$empid."', '". $current_date ."','".$arr['days']."')";
					$result =$GLOBALS['db']->query($query);
				}
			}
			else if(($emp_power['is_superadmin'] ==1)  || ($emp_power['is_admin'] ==1))
			{
				$query_hod="select employeeid from employee where employeeid='". $empid."'";
				$result_hod = $GLOBALS['db']->query($query_hod);
				if(isset($result_hod) and $result_hod->num_rows>0)
				{
					$row_hod = $result_hod->fetch_assoc();
					$allottedby=$row_hod['employeeid'];
					$approvedby=$row_hod['employeeid'];
									
					$query_emp="select employeeid from leaveeligibility where employeeid='". $arr['employeeid'] ."'  and leavetypeid='2'";
					$result_emp= $GLOBALS['db']->query($query_emp);
					if(isset($result_emp) and $result_emp->num_rows>0)
					{
					
						$query1 = "UPDATE leaveeligibility SET employeeid = '".$arr['employeeid']."',  leavetypeid = '". $coffid ."' , leavedays='". $total_day."' where employeeid= '" . $arr['employeeid'] ."' and leavetypeid = '". $coffid ."'";
						$result1 =$GLOBALS['db']->query($query1);
						
					}
					else
					{
						
						$query1 ="insert into leaveeligibility(leaveeligibilityid, employeeid, leavetypeid, effectivedate, leavedays) values ('','" . $arr['employeeid'] . "','" .$coffid."','" .$lvdate ."','".$total_day."')";
						$result1 =$GLOBALS['db']->query($query1);
					}
					$query_eligible="select leaveeligibilityid from leaveeligibility where employeeid='". $arr['employeeid'] ."' and leavetypeid='2'";
					$result_eligible = $GLOBALS['db']->query($query_eligible);
					if(isset($result_eligible) and $result_eligible->num_rows>0)
					{
						while($row_eligible = $result_eligible->fetch_assoc())
						{
							$eligible=$row_eligible['leaveeligibilityid'];
						}
					}
						
					$query ="insert into leavecoff(leavecoffid, employeeid, dateworked, remarks, allottedby,  approvedby, createddatetime, days, leaveeligibilityid,status)
							values ('','" . $arr['employeeid'] . "','" . $lvdate ."','".$arr['remarks']. "', '".$allottedby."','".$approvedby."','". $current_date ."','".$arr['days']."','". $eligible ."','approved')";
					$result =$GLOBALS['db']->query($query);
						
					$id=$GLOBALS['db']->insert_id;
					
					
					//mail
					$message=" Compensatory Off Approved";
					require_once('class.mail.php');
					$obj=new mail();
					$hremail=getsettings('hremail');
						
					$data1=getEmpMail($arr['employeeid']);//get emp email
					$data['from']=$emp_power['emp_email'];
					$data['to']=$data1['mail'];
					$data2=emp_authority($arr['employeeid']);
					$data['bcc']=array($data2['dep_hod_email'],$hremail);
					
					$data['subject']="Compensatory Off applied for ".$data['fullname']." is Approved.";	
				  $data['message']="\nHi \nThe Compensatory Off applied for  ".$data1['fullname']." is Approved by ".$emp_power['emp_name'];
					$value1=$obj->mailsend($data);
					$message.=" <br/> Mail sent to ";
					$message.=" <br/>".$data['to'];
					foreach($data['bcc'] as $tomails)
					{
						$message.="<br/>".$tomails;
					}		
				}
			}
			$msg['message']=$message;
			$msg['flag']=1;
			return $msg;
		}
	}
	
	
	function getDepartmentList1($emp_power,$departid,$editDepid="")
	{
		if($departid=="")
		{
			$departid=$emp_power['emp_deptid'];
		}
		

		
		
		$result=get_new_dept_list($emp_power['emp_id'],$emp_power) ;
		
		$view="";	
		if(($emp_power['is_hod']!="1")or($emp_power['is_superadmin']==1))
		{	
			$view.= " <option value=\"0\" selected=\"selected\">Select Department</option>";	 	
		} 		//print_r($result->fetch_assoc());
		
		while($row = $result->fetch_assoc())
		{	
			$view.="
			
			<option value=\"".$row['departmentid']."\" 
			";
			if(($row['departmentid']==$departid)||($row['departmentid']==$editDepid))
			{
				$view.="selected=\"selected\"";
			}
			$view.=">".$row['depname']."</option>
			";
				
		}
		return $view;
	}
	
	function getemployeelist1($emp_power,$departSelected,$emp_id,$editempid="")
	{

					
				$result = get_new_employee_list($departSelected,$emp_power);

				$view="";
				
					if(isset($result) and $result->num_rows>0)
					{
						$view.= " <option value=\"0\" selected=\"selected\">Select Employee</option>";
						while($row = $result->fetch_assoc())
						{
							if(($emp_power['is_hr']== 0) and ($emp_power['is_superadmin']==0) and ($emp_power['is_admin']==0) and ($emp_power['is_hod']==0))
							{
								if($row['employeeid']!=$_SESSION['USERID'])
								{
									$view.= " <option value=\"".$row['employeeid']."\" ";
									if(($row['employeeid']==$emp_id)||($row['employeeid']==$editempid))
									{
										$view.="selected=\"selected\" ";
									}	
									$view.=">".$row['fullname']."</option>";
								}
							}
							else if($emp_power['is_hr']== 1) 
							{
								if($row['employeeid']!=$_SESSION['USERID'])
								{
									$view.= " <option value=\"".$row['employeeid']."\" ";
									if(($row['employeeid']==$emp_id)||($row['employeeid']==$editempid))
									{
										$view.="selected=\"selected\" ";
									}	
									$view.=">".$row['fullname']."</option>";
								}
							}
							else
							{
								$view.= " <option value=\"".$row['employeeid']."\" ";
								if(($row['employeeid']==$emp_id)||($row['employeeid']==$editempid))
								{
									$view.="selected=\"selected\" ";
								}	
								$view.=">".$row['fullname']."</option>";
							}
						}
				 }
				  return $view;
	}
	
	function showfiles($emp_power,$arr,$departSelected,$emp_id,$start,$limit,$dep_id,$emd,$emp)
	{
		if(($emp_power['is_hod']=='1') || ($emp_power['is_superadmin']=='1') || ($emp_power['is_hr']=='1'))
		{
			$query_dept_emp="select emp.employeeid from employee emp where emp.departmentid in (".$departSelected.")";
			$result_dept_emp = $GLOBALS['db']->query($query_dept_emp);
			if(isset($result_dept_emp) and $result_dept_emp->num_rows>0) 
			{
				$emp_dept="";
				while($row_dept_emp = $result_dept_emp->fetch_assoc()) 
				{
					if($emp_power['is_hr']== 1) 
					{
						if($row_dept_emp['employeeid']!=$_SESSION['USERID'])
						{
							$dept_emp=$row_dept_emp['employeeid'];
						}
					}
					else
					{
						$dept_emp=$row_dept_emp['employeeid'];
					}
					if($emp_dept!="")
					{
						$emp_dept.=",";
					}
					$emp_dept.=$dept_emp;					
				}
			}
			
			$query="select dept.departmentid, dept.depname, emp.employeeid, emp.fullname, l.leavecoffid, l.dateworked, l.allottedby, l.approvedby, l.remarks, l.days, l.status from department as dept ,employee as emp, leavecoff as l ";
			
					if($emp_power['is_hr']==1)
					{
						$query.="WHERE  emp.departmentid=dept.departmentid  AND emp.empstatus='active'
									";										
					}				
					else if($emp_power['is_admin']==1)
					{
						$query.="WHERE emp.departmentid=dept.departmentid  AND emp.empstatus='active' ";
						if(intval($departSelected) < 1 )
						$query.=" AND dept.departmentid in ( ".$emp_power['isadm_deptid']." )";
					}
					else if($emp_power['is_hod']==1)
					{
						$query.="WHERE emp.departmentid=dept.departmentid  AND emp.empstatus='active'  ";
						if(intval($departSelected) < 1 )
						{
							$query.="  AND dept.departmentid in (".$emp_power['ishod_deptid'].") OR emp.employeeid in (".$emp_power['from_rep'].")";
						}
						if(($emp_id==0) || ($emp_id==1) || (($emd!=$emp_id) && ($dep_id!=$departSelected)) && ($emp!=$emp_id))
						{
							$query .= "	and	l.employeeid in (".$emp_dept.")";
						} 
						else
						{
							$query .= "	and	l.employeeid = '".$emp_id."' ";
						}
					}
					else 
					{
						$query.="WHERE emp.departmentid=dept.departmentid  AND emp.empstatus='active'  ";
						$query.="  AND emp.employeeid=".$_SESSION['USERID']." 	";
					}	
						
					$query.= " AND emp.employeeid >1 "; 
					
					
						if(intval($departSelected) > 0)
						{
							$query.= " and   emp.departmentid ='".$departSelected."' ";
							if(($emp_id==0) || ($emp_id==1) || (($emd!=$emp_id) && ($dep_id!=$departSelected)) && ($emp!=$emp_id))
							{
								$query .= "	and	l.employeeid in (".$emp_dept.")";
							} 
							else
							{
								$query .= "	and	l.employeeid = '".$emp_id."' ";
							}
						}
					
					 if($emp_power['is_hr']== 0){
					
					$query.="  AND ( ";
					
					if($emp_power['isadm_deptid']!="")
					 $query.=" dept.departmentid in ( ".$emp_power['isadm_deptid']." ) ";
					
					if(($emp_power['isadm_deptid']!="") && ($emp_power['ishod_deptid']!=""))
						$query.="  and  ";
					
					if($emp_power['ishod_deptid']!="")
					$query.="   dept.departmentid in (".$emp_power['ishod_deptid'].")  ";
					
					
					if($emp_power['is_superadmin']==0)
					{
						$query.="  or  emp.employeeid in (".$emp_power['from_rep'].")  ";
					}
					
					
					$query.="   )  ";
					
				}
			$query .= "and l.employeeid=emp.employeeid order by l.dateworked desc";	
			//echo "<br/><br/><br/>". $query;
		}
		
		else
		{
			$addq="";
			$emp_power= empty($emp_power)? emp_authority($emp_id) :  $emp_power;
			
			$select=" SELECT dept.departmentid, dept.depname, e.employeeid, e.fullname, l.leavecoffid, l.dateworked, l.approvedby, l.remarks, l.days, l.status  ";
			
			if((intval($emp_power['from_rep']) >0 ) and (empty($emp_id)))
			{
				$addq= " e.employeeid in (".$emp_power['from_rep'].") ";
				//$addq.= " or e.employeeid ='".intval($emp_power['emp_id'])."' " ;
			}
			else
			{
				$addq .= "	l.employeeid = '".$emp_id."' ";
			}

			
						
			if((	$emp_power['is_superadmin'] == 1) || $emp_power['is_hr'] == 1)
				$addq=" employeeid > 1 ";
			$query=$select." from employee as e, department as dept, leavecoff as l where e.departmentid=dept.departmentid and e.departmentid = '".intval($departSelected)."' and ( ".$addq." )  and e.employeeid > 1 and e.empstatus='active' and l.employeeid=e.employeeid order by l.dateworked desc";
			
		}
		
		//echo "<br/><br/><br/>". $query;
		$result1 = $GLOBALS['db']->query($query);
		$totoal_count=$result1->num_rows;
		
		$query .= " limit  ".$start." , ".$limit;
		$s=$start;

		//echo "<br/>".$emp_id;
		$leave_detail="";	
		$result = $GLOBALS['db']->query($query);
		if(isset($result) and $result->num_rows>0) 
		{

			$i=$start;
			$f=$result->num_rows;

			//$i=0;	
			while($row = $result->fetch_assoc()) 
			{
				$query_empname="select l.leavecoffid, emp.fullname as name, emp.title from employee emp, leavecoff l where emp.employeeid=l.approvedby and leavecoffid=".$row['leavecoffid'];
				$result_empname = $GLOBALS['db']->query($query_empname);
				if(isset($result_empname) and $result_empname->num_rows>0)
				{
					while($row_empname = $result_empname->fetch_assoc())
					{
						
						$emp_name=$row_empname['name'];
						$title=$row_empname['title'];
					}
				}
				$query_alotname="select l.leavecoffid, emp.fullname as name, emp.title from employee emp, leavecoff l where emp.employeeid=l.allottedby and l.leavecoffid=".$row['leavecoffid'];
				$result_alotname = $GLOBALS['db']->query($query_alotname);
				if(isset($result_alotname) and $result_alotname->num_rows>0)
				{
					while($row_alotname = $result_alotname->fetch_assoc())
					{
						$alot_name=$row_alotname['name'];
						$title1=$row_alotname['title'];
					}
				}
				$dateworked=ymdtodmy($row['dateworked']);

					$i++;
					if($row['status']=="approved") 
					{
						$class="style=\"background-color:#A6FFA6;\"";
						//$class=" class=\"even\" ";
					}
					else if($row['status']=="pending") 
					{
						$class="style=\"background-color:#EFE876;\"";
						//$class=" class=\"odd\" ";
					}						
					else if($row['status']=="rejected")
					{
						$class="style=\"background-color:#FF9266;\"";
					}
					
					$leave_detail.="<tr align=\"center\"".$class.">";
					$leave_detail.= "<td height='30' style=\"font-weight:normal;\" >" . $i . "</td>";
					$leave_detail.= "<td style=\"font-weight:normal;\" >" . ($row['depname']) . "</td>";
					$leave_detail.= "<td style=\"font-weight:normal;\" >" . ($row['fullname']) . "</td>";
					$leave_detail.= "<td style=\"font-weight:normal;\" >" . $dateworked . "</td>";
					$leave_detail.= "<td style=\"font-weight:normal;\" >" . ucfirst($row['remarks']) . "</td>";
					$leave_detail.= "<td style=\"font-weight:normal;\" >" . ($row['days']) . "</td>";
					$leave_detail.= "<td align=\"center\" style=\"font-weight:normal;\" >";
						$leave_detail.="<form name=\"coff\" id=\"coff\" action=\"coff.php\" method=\"post\">";			
							if($row['status']=="approved")
							{
								$leave_detail.=ucfirst($row['status'])." By: <br/>".$title.".".$emp_name;
							}
							else if($row['status']=="pending") 
							{
								//$leave_detail.=ucfirst($row['status'])."<br/>";
								$leave_detail.="Pending<br/>";
								if($emp_power['is_superadmin']!=1)
								{
									$leave_detail.= "<input type=\"submit\" id=\"edit\" name=\"edit\" title=\"Click here to edit/delete the data\" style=\"width:75px;background-color:#EFE876;border:0;color:blue \" value=\"Edit\"/>";
									$leave_detail.= "<input type=\"hidden\" id=\"edit_id\" name=\"edit_id\" value=\"".$row['leavecoffid']."\"/>";
									$leave_detail.= "<input type=\"hidden\" id=\"status1\" name=\"status1\" value=\"".$row['status']."\"/>";
								}
							}
							else if($row['status']=="rejected")
							{
									$leave_detail.= ucfirst($row['status'])." By: <br/>".$title.".".$emp_name;
							}
						$leave_detail.="</form>";
					$leave_detail.="</td>";
					$leave_detail.= "<td style=\"font-weight:normal;\" >" . $title1.".".$alot_name . "</td>";

			}	
		}
			$data['tables']=$leave_detail;
			$data['last_count']=$i;
			$data['found_rows']=$f;
			$data['total_count']=$totoal_count;
			return $data;
	
	}
	function getData($id)
	{
		$query="select dept.departmentid, dept.depname, emp.employeeid, emp.fullname, l.leavecoffid, l.dateworked, l.remarks, l.days, l.status from department as dept, employee as emp, leavecoff as l where   dept.departmentid=emp.departmentid and emp.employeeid=l.employeeid and l.leavecoffid='".$id."'";
		$result = $GLOBALS['db']->query($query);
		if(isset($result) and $result->num_rows>0) 
		{
			return $row = $result->fetch_assoc();
		}
	}
	function getEmpMail($emp_id)
	{
		$empQuery=" select emp.employeeid, emp.email, emp.fullname from employee emp where  emp.employeeid='".$emp_id."' ";
		$resultEmpQuery = $GLOBALS['db']->query($empQuery);
		if(isset($resultEmpQuery) and $resultEmpQuery->num_rows>0) 
		{
			$row = $resultEmpQuery->fetch_assoc();
				$fullname=$row['fullname'];
				$mail=$row['email'];	
		}
		$data['fullname']=$fullname;
		$data['mail']=$mail;
		return 	$data;
	}
	function edit_check()
	{	
		$days_to_edit_report=getsettings('applycoffgap');
		$get_date=$_SESSION['REP_DATE'];
		$date=explode('/',$get_date);
		$date_format=$date[2]."-".$date[1]."-".$date[0];
		$a = localtime( );
		$a[4] += 1;
		$a[5] += 1900;
		$epoch_2 = mktime(00,00,01,$date[1],$date[0],$date[2]);
		// 4:29:11 am on November 20, 1962
		$epoch_1 =  mktime(00,00,01,$a[4],$a[3],$a[5]);
		$diff_seconds  = $epoch_1 - $epoch_2;
		$diff_days     = floor($diff_seconds/86400);
		if($diff_days<=$days_to_edit_report)
		{
			$_SESSION['EDIT']=1;
			// allows edit
		}
		else
		{
			$_SESSION['EDIT']=0;
		}
	}
?>
