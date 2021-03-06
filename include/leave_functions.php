<?php 
require_once('include.php');
$emp_power=emp_authority($_SESSION['USERID']);
$days_to_applyleave=getsettings('applyleavegap'); 
//For cancel leave in View Leave page
if(isset($_REQUEST['levid']))
{
	$leaveid=$_REQUEST['levid'];
	$depid=$_REQUEST['d'];
	$leavequery="select * from leaveapplication where leaveapplicationid='".$leaveid."' ";
	$result=$GLOBALS['db']->query($leavequery);
	if(isset($result) and $result->num_rows>0)
	{
		$row = $result->fetch_assoc();
		$leaveapplicationid=$row['leaveapplicationid'];
		$fromdate1=explode(" ",$row['fromdate']);
		$fromdate=ymdToDmy($fromdate1[0]);
		$todate1=explode(" ",$row['todate']);
		$todate=ymdToDmy($todate1[0]);
		$leavedays=$row['leavedays'];
		$fromoption=$row['fromoption'];
		$tooption=$row['tooption'];
		$employeeremarks=$row['employeeremarks'];
		$leavetypeid=$row['leavetypeid'];
				//get leave type
				$leavetypequery="select name from leavetype where leavetypeid='".$leavetypeid."'";
				$result1=$GLOBALS['db']->query($leavetypequery);
				$row1 = $result1->fetch_assoc();
				$leavetypename=$row1['name'];
		$permissionID=getsettings('permissionid');
												if($permissionID==$leavetypeid)
												{
													$fromtime	=$row['fromtime'];
													$duration	=$row['duration'];
													////
													if($duration==30)
													{ 
														$showPermDuration=" 30 mins ";
													}
													else if($duration==60)
													{ 
														$showPermDuration=" 1 hour ";
													}
													else if(($duration%60)>0)
													{
														$h=floor($duration/60);
														$showPermDuration=$h." hours  30 mins";
													}
													else
													{
														$h=floor($duration/60);
														$showPermDuration=$h." hours ";
													}
													////
													//echo "fromtime=".$fromtime." duDrop=".$duration."  show=".$showPermDuration;
												}
		
		
		if($leavedays>1)
		{
			$dates="From  ".$fromdate." To ".$todate." ( ".$leavedays." Days )";
		}	
		else
		{	
			$dates="On  ".$fromdate;
			if($fromtime!='')
			{
				$dates.="\n From time : ".$fromtime."\n Duration : ".$showPermDuration;
			}
		}
		
		
	}
	
	//get employeeid for which leave is cancelled
	$eid=$row['employeeid'];
	//get employee mail and fullname for which leave is cancelled
	$getEmp=getEmpMail($eid);	
	$empfullname=$getEmp['name'];	
	//get mail ids for who all mail is to send(HOD,HR,...)
	$mails=mailstosend($eid);

	//get HOD
	$cancelBy="cancelled by HOD ".$emp_power['emp_name'];
 	$query="update leaveapplication set cancelled=1,cancelreason='".$cancelBy."' where leaveapplicationid='".$leaveid."' ";
	$result = $GLOBALS['db']->query($query);	
	//$result = $GLOBALS['db']->query($query);
	if($result)
	{
				$message=" Leave has been cancelled";				
				//mail
				require_once('class.mail.php');
				$obj=new mail();	
				//From mail is the person who is login 			
				$canceldata['from']=$emp_power['emp_email'];	
				$canceldata['to']=$mails['mail_add_to_send'];
				$canceldata['bcc']=array('raghu.n@primemoveindia.com');
				$canceldata['subject']="Leave applied for ".$empfullname." is cancelled.";	
				$canceldata['message']="\nHi \nThe leave applied for  ".$empfullname." is cancelled by ".$emp_power['emp_name']."\nCategory : ".$leavetypename."\nReason : ".$employeeremarks."\n".$dates;	
				$value1=$obj->mailsend($canceldata);
				//printarray($canceldata);
				$message.=" <br/> Mail sent to ";
				foreach($mails['mail_add_to_send'] as $tomails)
				{
				$message.=" <br/>".$tomails;
				}								
	}	
	header("Location:viewleave.php?d=".$depid."&msg=".urlencode(trim($message))."");
	exit;
}
//end of Cancel leave for View Leave page
////////////////////////////////////////////////////////////////////////
//Apply leave
if((isset($_GET['aid']))&&($_GET['aid']!="")&&($_GET['aid']!="nil"))
{
	$appid=$_GET['aid'];
	$query ="select  
						a.leaveapplicationid,
						a.employeeid,
						a.fromdate,
						a.todate,
						a.fromoption,
						a.tooption,
						a.leavedays,
						a.leavetypeid,
						a.fromtime,
						a.duration,
						a.leavetypeid,
						a.employeeremarks,
						a.sanctioned,
						a.sanctionedby,
						a.sanctionremarks ,
						a.entrydatetime						
				from 
						leaveapplication as a
				where 
						a.leaveapplicationid='".$appid."' 												
						";
	
	$result = $GLOBALS['db']->query($query);


	if(isset($result) and $result->num_rows>0)
	{
		$leave_details="";
		$i=0;
		while($row = $result->fetch_assoc())
		{
			$leaveapplicationid=$row['leaveapplicationid'];
			$fromdate1=explode(" ",$row['fromdate']);
			$fromdate=ymdToDmy($fromdate1[0]);
			$todate1=explode(" ",$row['todate']);
			$todate=ymdToDmy($todate1[0]);
			$leavedays=$row['leavedays'];
			$fromoption=$row['fromoption'];
			$tooption=$row['tooption'];
			$fromtime=$row['fromtime'];
			$duration=$row['duration'];
			$employeeremarks=$row['employeeremarks'];
			$leavetypeid=$row['leavetypeid'];
			$sanctioned=$row['sanctioned'];
			if($sanctioned>0)
			{
				$query_n = "select  title,fullname  from   employee  where employeeid='".$row['sanctionedby']."' ";
				$result_n = $GLOBALS['db']->query($query_n);
				$row_n = $result_n->fetch_assoc();
				$sanctionedby=$row_n['title']." ".$row_n['fullname'];
			}
			$sanctionremarks=$row['sanctionremarks'];
			$entrydatetime1=explode(" ",$row['entrydatetime']);
			$entrydatetime=ymdToDmy($entrydatetime1[0]);
		}
	}
	else
	{
		$message="No Records Found";
	}
}
else if((isset($_POST['save']))&&($_POST['save']!=""))
{
	$employeeid=$_POST['employeeid'];
	$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
	$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
	$leaveapplicationid	=$_POST['leaveapplicationid'];	
	$enteredby=$_SESSION['USERID']; 
	$ff=$_POST['from_date'];
	
	$tom=mktime(0, 0, 0, date("m")  , date("d")-$days_to_applyleave, date("Y"));
  	$day=date("d/m/Y", $tom); 
  

	$date_diffFrom=dateDiff($day,$ff,'/');
	if($date_diffFrom>=0)
	{
		$fromdate=dmyToymd($ff);
		$fromoption=$_POST['from_date_options'];     
		if($_POST['to_date']!="")
		{
			$tt=$_POST['to_date'];
			$date_diffTo=dateDiff( $ff,$tt,'/');
			$todate	=dmyToymd($tt);
			$tooption=$_POST['to_date_options'];
			$leavedays =$_POST['days_count'];
			if($leavedays=="")
			{
				$leavedays=$date_diffTo;
			}
		}
		else
		{
			$todate	="";
			$toption="";
			if($fromoption=="full")
			{
				//$showfromoption="(full day)";
				$leavedays=1;
			}
			else
			{
				//$showfromoption="(".$fromoption." half day )";
				$leavedays=0.5;
			}
		}
		$leavetypeid1=$_POST['leave_type'];
		$arr=explode("~",$leavetypeid1);
		$leavetypeid=$arr[0];
		$permissionID	=$_POST['permissionID'];
		if($permissionID==$leavetypeid)
		{
			//$showfromoption="";
			$fromtime	=$_POST['duration'];
			$duration	=$_POST['durationDrop'];
			////
			if($duration==30)
			{ 
				$showPermDuration=" 30 mins ";
			}
			else if($duration==60)
			{ 
				$showPermDuration=" 1 hour ";
			}
			else if(($duration%60)>0)
			{
				$h=floor($duration/60);
				$showPermDuration=$h." hours  30 mins";
			}
			else
			{
				$h=floor($duration/60);
				$showPermDuration=$h." hours ";
			}
			////
			//echo "fromtime=".$fromtime." duDrop=".$duration."  show=".$showPermDuration;
		}
		else
		{
			$fromtime	="";
			$duration	="";
		}
		if(($permissionID==$leavetypeid)&&(($fromtime=="")||($duration==0)))
		{
			$permissionoke=0;
		}
		else
		{
			$permissionoke=1;
		}
		$employeeremarks =$_POST['reason'];
		$entrydatetime=$today;	
		if(($_POST['to_date']!="")&&($date_diffTo<0.5))
		{
			$message=" Please check dates";
		}
		else if($permissionoke==0)
		{
			$message=" Please Enter time / duration";
		}
		else if((($_POST['to_date']=="")||($date_diffTo>=0.5))&&($permissionoke==1))
		{ 
			
			$mails=mailstosend($employeeid); 
			$sanctioned=$mails['sanctioned'];
			$enteredby=$mails['enteredby'];
			$sanctionedby=$mails['sanctionedby']; 
			
			
			if($leaveapplicationid	=="nil")
			{
			 
				$leaveapplicationid	="NULL";
				$data['queryx']=" INSERT INTO leaveapplication ( leaveapplicationid ,employeeid,fromdate,todate,fromoption,tooption,leavedays,	leavetypeid,fromtime,duration,employeeremarks,enteredby,sanctioned,sanctionedby,entrydatetime) "
				." VALUES ( ".$leaveapplicationid." , '".$employeeid."' , '".$fromdate."' , '".$todate."' ,'".$fromoption."' ,'".$tooption."' , '".$leavedays."' , '".$leavetypeid."'  , '".$fromtime."'  , '".$duration."' , '".$employeeremarks."' , '".$enteredby."' , '".$sanctioned."' , '".$sanctionedby."' , '".$entrydatetime."' ) ";
			}
			else
			{
 				$data['queryx']=" UPDATE leaveapplication  SET  fromdate = '".$fromdate."',   todate='".$todate."',  fromoption='".$fromoption."',  tooption='".$tooption."',  leavedays='".$leavedays."', leavetypeid = '".$leavetypeid."' ,  fromtime = '".$fromtime."' , duration = '".$duration."' ,  employeeremarks = '".$employeeremarks."', enteredby = '".$enteredby."', sanctioned = '".$sanctioned."', sanctionedby = '".$sanctionedby."',  entrydatetime = '".$entrydatetime."'  WHERE   leaveapplicationid =".$leaveapplicationid;
			} 
############################################
			$sub= check_submission($fromdate." , ".$todate,$fromoption."".$tooption."".$employeeremarks."".$fromtime."".$duration,$leavetypeid."".$leavedays);
############################################ 
//         print $data['queryx'];
			if($sub==true)
			{ 
				$result_actionx = $GLOBALS['db']->query($data['queryx']); 
				if($result_actionx==TRUE)
				{ 
					$message=" Leave Marked";
					require_once('class.mail.php');
					$obj=new mail();
				//	$data=getMail();//get hod email
					$data['emp']=getEmpMail($employeeid);//get emp email
					$type=getLeaveType($leavetypeid);
/*
					if($data['hod']==$_SESSION['USERID']){
						
					$data['mail']=getsettings('hremail'); 
					}
*/
					$data['from']=$data['emp']['mail'];
					$data['to']=$mails['mail_add_to_send'];
					$data['bcc']=array('raghu.n@primemoveindia.com');
					if(isset($ff) && isset($tt))//if($leavedays>1)//if($leavedays!="")       
					{
						$dates=" from  ".$ff."(".$fromoption." section ) to ".$tt."(".$tooption." section) ( ".$leavedays;
						$dates.=($leavedays>1)?' Days )':' Day )';
					}	
					else if($permissionID==$leavetypeid)
					{	
						$dates=" on  ".$ff;						
						$dates.="\n From time : ".$fromtime."\n Duration : ".$showPermDuration;						
					}
					else
					{            					
						$dates=" on  ".$ff."(".$fromoption." section) ( ".$leavedays;
						$dates.=($leavedays>1)?' Days )':' Day )';
						
					}
if($mails['user']['emp_id']==$mails['apply']['emp_id']){
$data['subject']="Leave Applied by ".$mails['user']['emp_name']."  ".$dates." ";
$data['message']="\n\n\n Hi, \n ".$data['emp']['name']." has applied for  leave ".$dates."\n Category : ".$type['name']." ( ".$type['code']." ) \n Reason :  '".$employeeremarks."'\n  \n  \n  Thanks \n Primemove Reporting system.\n  \n  \n  \n  \n  \n  ";
	}
else{ 
	$sanction="";
	if($sanctioned==1){
	$sanction="is sanctioned by ".$mails['apply']['emp_name']." ";
	} 
$data['subject']="Leave Applied for ".$mails['user']['emp_name']."  by ".$mails['apply']['emp_name']." dates:".$dates." ".$sanction; 
					$data['message']="\nHi, \n".$mails['apply']['emp_name']." have applied leave for ".$mails['user']['emp_name']." for ".$dates."\nCategory : ".$type['name']." ( ".$type['code']." )\n".$sanction."\nReason :  '".$employeeremarks."'\n\n\nThanks \nPrimemove Reporting system.\n  \n  \n  \n  \n  \n  "; 
				} 
				$data['message'] .="\n\n\n\n\nUser info as follows:-\n ";
				$usrinfo=userinfo(); 
				$data['message'] .=$usrinfo['message']; 
				$data['ishtml']=false;
				$value=$obj->mailsend($data);
				//printarray($data);
				$message.=" <br/> Mail sent to ";
				foreach($mails['mail_add_to_send'] as $tomails){
				$message.=" <br/>".$tomails;
				}
				}
				else
				{
					$message=" Error ! Please Try again";
				}
			}
			else
			{
				$message=" Leave Already Marked";
			}
		}
	}
	else
	{
		$message="You can apply leave only from ".$day;
	}
	$leavetypeid=0;
	$leaveapplicationid="nil";
	$fromdate="";
	$todate="";
	$fromoption="";
	$tooption="";
	$leavedays="";
	$fromtime="";
	$duration="";
	$sanctioned="";
	$sanctionedby="";
	$sanctionremarks="";
	$entrydatetime="";
	$employeeremarks="";
}
//Cancel leave
else if((isset($_POST['cancelBtn']))&&($_POST['cancelBtn']!=""))
{	
	$leaveapplicationid=$_POST['leaveapplicationid'];
	$leavequery="select * from leaveapplication where leaveapplicationid='".$leaveapplicationid."' ";
	$result=$GLOBALS['db']->query($leavequery);
	if(isset($result) and $result->num_rows>0)
	{
		$row = $result->fetch_assoc();
		$leaveapplicationid=$row['leaveapplicationid'];
		$fromdate1=explode(" ",$row['fromdate']);		
		$fromdate=ymdToDmy($fromdate1[0]);
		$todate1=explode(" ",$row['todate']);
		$todate=ymdToDmy($todate1[0]);
		$leavedays=$row['leavedays'];
		$fromoption=$row['fromoption'];
		$tooption=$row['tooption'];
		$employeeremarks=$row['employeeremarks'];
		$leavetypeid=$row['leavetypeid'];
				//get leave type
				$leavetypequery="select name from leavetype where leavetypeid='".$leavetypeid."'";
				$result1=$GLOBALS['db']->query($leavetypequery);
				$row1 = $result1->fetch_assoc();
				$leavetypename=$row1['name'];
		$permissionID=getsettings('permissionid');
												if($permissionID==$leavetypeid)
												{
													$fromtime	=$row['fromtime'];
													$duration	=$row['duration'];
													////
													if($duration==30)
													{ 
														$showPermDuration=" 30 mins ";
													}
													else if($duration==60)
													{ 
														$showPermDuration=" 1 hour ";
													}
													else if(($duration%60)>0)
													{
														$h=floor($duration/60);
														$showPermDuration=$h." hours  30 mins";
													}
													else
													{
														$h=floor($duration/60);
														$showPermDuration=$h." hours ";
													}
													////
													//echo "fromtime=".$fromtime." duDrop=".$duration."  show=".$showPermDuration;
												}
		
		

		
		if(isset($fromdate) && $todate!='00/00/0000')
		{
			$dates="From  ".$fromdate."(".$fromoption." section) To ".$todate." ( ".$tooption." section)  (".$leavedays;
			$dates.=($leavedays>1)?' Days)':' Day)';
		}
		else if($permissionID==$leavetypeid)
		{
			$dates=" on  ".$fromdate;						
			$dates.="\n From time : ".$fromtime."\n Duration : ".$showPermDuration;			
		}
		else
		{
			$dates=" on  ".$fromdate."(".$fromoption." section) ( ".$leavedays;
			$dates.=($leavedays>1)?' Days )':' Day )';
		}
	}
	//get employeeid for which leave is cancelled
	$eid=$_POST['eid'];
	//get employee mail and fullname for which leave is cancelled
	$getEmp=getEmpMail($eid);	
	$empfullname=$getEmp['name'];	
	//get mail ids for who all mail is to send(HOD,HR,...)
	$mails=mailstosend($eid);
	
	$cancelBy="cancelled by ".$emp_power['emp_name'];	
	$query="UPDATE leaveapplication SET cancelled=1,cancelreason='".$cancelBy."' 
				WHERE  leaveapplicationid='".$leaveapplicationid."'
				";
	$result_action1 = $GLOBALS['db']->query($query);
	if($result_action1)
	{
				$message=" Leave has been cancelled";
				
				//mail
				require_once('class.mail.php');
				$obj=new mail();	
				//From mail is the person who is login 			
				$canceldata['from']=$emp_power['emp_email'];	
				$canceldata['to']=$mails['mail_add_to_send'];	
				$canceldata['bcc']=array('raghu.n@primemoveindia.com');
				$canceldata['subject']="Leave applied for ".$empfullname." is cancelled.";	
				$canceldata['message']="\nHi \nThe leave applied for  ".$empfullname." is cancelled by ".$emp_power['emp_name']."\nCategory : ".$leavetypename."\nReason : ".$employeeremarks."\n".$dates;	
				$value1=$obj->mailsend($canceldata);
				//printarray($canceldata);
				$message.=" <br/> Mail sent to ";
				foreach($mails['mail_add_to_send'] as $tomails)
				{
				$message.=" <br/>".$tomails;
				}
								
	}
}
else
{
	$message="";
	$leavetypeid=0;
	$leaveapplicationid="nil";
	$fromdate="";
	$todate="";
	$fromoption="";
	$tooption="";
	$leavedays="";
	$fromtime="";
	$duration="";
	$sanctioned="";
	$sanctionedby="";
	$sanctionremarks="";
	$entrydatetime="";
	$employeeremarks="";
}
 
function get_leave_details($start, $limit, $aid, $dept, $emp, $departSelected, $emp_id) {
	$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
	$today=strftime("%Y-%m-%d 00:00:00", strtotime($timestamp)); 
	$days_to_applyleave=getsettings('applyleavegap'); 
	$tom=mktime(0, 0, 0, date("m")  , date("d")-$days_to_applyleave, date("Y"));
  $day=date("Y-m-d", $tom); 
												 $query = "select  
																										a.leaveapplicationid,
																										a.employeeid,
																										e.departmentid,
																										e.fullname,
																										a.fromdate,
																										a.todate,
																										a.leavedays,
																										a.leavetypeid,
																										a.fromtime,
																										a.duration,
																										a.employeeremarks,
																										a.sanctioned,
																										a.sanctionedby,
																										a.sanctionremarks ,
																										a.entrydatetime,
																										t.leavetypeid,
																										t.name,
																										t.shortname,
																										t.daysperyear,
																										t.weeklyoffexempted,
																										t.holidayexempted,
																										t.carryforward,
																										t.carryforwardmaxdays,
																										t.payablepercentage,
																										t.maxincredit,
																										t.halfdayallowed
																										from 
																															leaveapplication as a,
																															leavetype as t,
																															employee as e 
																										 where 
																																a.leavetypeid=t.leavetypeid ";
																																/*and 
																																a.fromdate >='".$day ."'*/
																															 $query .= "	and
																																a.cancelled=0 ";
																																if($emp_id==""){
																														$query .= "	and	a.employeeid in (".$emp.")";
																													}else{
																														$query .= "	and	a.employeeid = '".$emp_id."' ";
																													}
																														
																													 $query .= "			and
																																e.departmentid in (".$dept.")
																																and 
																																a.employeeid=e.employeeid
																										 order by a.fromdate desc "; 
	$result1 = $GLOBALS['db']->query($query);
	$totoal_count=$result1->num_rows;
																		$query .= "				limit  ".$start." , ".$limit." ";
																		$s=$start;
																//	echo	$query;
	$result = $GLOBALS['db']->query($query);
	$leave_details="";

if(isset($result) and $result->num_rows>0) {
	$i=$start;
	$f=$result->num_rows;
while($row = $result->fetch_assoc()) {
	$i++;
	$query_n = "select  title,fullname  from   employee  where employeeid='".$row['sanctionedby']."' ";
	$result_n = $GLOBALS['db']->query($query_n);
	$row_n = $result_n->fetch_assoc();
	$name=$row_n['title']." ".$row_n['fullname'];
	$edit="<form method=\"get\" action=\"applyleave.php\">
	<input type=\"hidden\" name=\"s\" id=\"s\" value=\"".$s."\" />
	<input type=\"hidden\" name=\"d\" id=\"d\" value=\"".$row['departmentid']."\" />
	<input type=\"hidden\" name=\"emp\" id=\"emp\" value=\"".$row['employeeid']."\" />
	<input type=\"hidden\" name=\"aid\" id=\"aid\" value=\"".$row['leaveapplicationid']."\" />
	";
	
	if($row['sanctioned']==1){
	$class=" class=\"sanctioned\" title=\"Leave Sanctioned\" ";
	if($aid==$row['leaveapplicationid'])$str=" value=\"VIEWING\" disable=\"true\" ";else $str=" value=\"VIEW\" ";
	
	$edit.="<input type=\"submit\" name=\"button\" id=\"button\" ".$str." /> ";								
	}
	else if($row['sanctioned']==2){
	$class=" class=\"rejected\" title=\"Leave Rejected\" ";
	if($aid==$row['leaveapplicationid'])$str=" value=\"UPDATING\" disable=\"true\" ";else $str=" value=\"UPDATE\" ";
	$edit.="<input type=\"submit\" name=\"button\" id=\"button\"  ".$str." /> ";														
	}
	else{
	$class=" class=\"notsanctioned\" title=\"Leave Not Sanctioned\" ";
	if($aid==$row['leaveapplicationid'])$str=" value=\"EDITING\" disable=\"true\" ";else $str=" value=\"EDIT\" ";
	$edit.="<input type=\"submit\" name=\"button\" id=\"button\"  ".$str." /> 			 
			  ";			
	}
		$edit.="</form>";
									$leave_details.="
									<tr align=\"center\" ".$class.">
									<td>
									".$i."
									</td>
									<td nowrap align=\"center\" >";
									$date=explode(" ",$row['fromdate']);
										if(($row['todate']!="")&&($row['todate']!="0000-00-00 00:00:00")){
											$leave_details.="From:  ".ymdtodmy($date[0])." <br/>";
									$date1=explode(" ",$row['todate']);
										$leave_details.="To   :  ".ymdtodmy($date1[0])." <br/>";
										$leave_details.="( ".$row['leavedays']." Days )";
									}
									else{
										$leave_details.="On:  ".ymdtodmy($date[0])." <br/>";
									}
									$leave_details.="	</td align=\"center\" >
									<td style=\"padding:5px;\" align=\"left\"> ".$row['name']."
									</td>
									<td style=\"padding:5px;\" align=\"left\"> ".$row['fullname']."
									</td>
									<td style=\"padding:5px;\" align=\"left\"> ".$row['employeeremarks']."
									</td>
									<td align=\"center\" >";
									if($row['sanctioned']=="1"){
											$leave_details.=" Sanctioned<br/>";
											$leave_details.="By : <label>".$name."</label><br/>";
										}
									else if($row['sanctioned']=="2"){
											$leave_details.=" Rejected<br/>";
											$leave_details.="By : <label>".$name."</label><br/>";
										}
								$leave_details.=$edit;
								$leave_details.="</td>
									</tr>
									
									";
									
}// while loop
}// if loop

$data['table']=$leave_details;
$data['last_count']=$i;
$data['found_rows']=$f;
$data['total_count']=$totoal_count;
return $data;
}


//function ($leave=0,$leavesEligible,$emp_id){
function leave_type($leavetypeid1,$emp_id,$today)
{

	if($emp_id=="")
	{
	$emp_id=$_SESSION['USERID'];
	}

	$leave_types="";
	$leave_types.="<option value=\"0\" >Select Leave Type</option>";
	$query = "select '".$emp_id."' as employeeid, t.leavetypeid, t.name, (select max(effectivedate) from leaveeligibility where leavetypeid = t.leavetypeid and effectivedate <= '".$today."' and employeeid = '".$emp_id."') as effectivedate, 0 as eligibledays, 0 as leavestaken 
from leavetype t";

	$result = $GLOBALS['db']->query($query);
	while($row=$result->fetch_assoc())
	{
		$employeeid=$row['employeeid'];  $leavetypeid=$row['leavetypeid'];  $effectivedate=$row['effectivedate']; $leavetypename=$row['name'];
		//get permission id from settings table
		$permission_id=getsettings('permissionid');
		$maxPermission=getsettings('maxpermissionspermonth');
		$a = localtime();
		$a[4] += 1;
		$a[5] += 1900;
		$monthstart=$a[5]."-".$a[4]."-01";;
		if($leavetypeid==$permission_id)
		{
			//Get leaves taken for permission 
			$leavetakenQuery="SELECT count(leavedays) as leavestaken FROM `leaveapplication` WHERE 
									employeeid = '".$employeeid."' 
									and leavetypeid = '".$leavetypeid."'
									and cancelled = 0 and sanctioned = 1
									and fromdate >= '".$monthstart."' ";
			$leavetakenResult=$GLOBALS['db']->query($leavetakenQuery);
			$leavetakenRow=$leavetakenResult->fetch_assoc();
			$leavetaken=$leavetakenRow['leavestaken'];		
			$leaveBal=$maxPermission-$leavetaken;
			$leave_types.="<option value=\"".$leavetypeid."~".$leaveBal."\"  title=\" You are eligible to take ".$leaveBal." more days under  ".$leavetypename."\"  ";
			if($leavetypeid1==$leavetypeid) {$leave_types.="selected=\"selected\" ";}
			$leave_types.=">".$leavetypename."</option>";
		}
		else
		{
			//Get eligibledays
			$eligibleQuery="SELECT leavedays as eligibledays
								FROM leaveeligibility
								WHERE employeeid = '".$employeeid."'
								AND leavetypeid = '".$leavetypeid."'
								AND effectivedate = '".$effectivedate."' ";
			$eligibleResult=$GLOBALS['db']->query($eligibleQuery);
			$eligibleRow=$eligibleResult->fetch_assoc();
			$eligibledays=$eligibleRow['eligibledays'];				
			
			//Get leaves taken
			$leavetakenQuery="SELECT sum(leavedays) as leavestaken FROM `leaveapplication` WHERE 
									employeeid = '".$employeeid."' 
									and leavetypeid = '".$leavetypeid."'
									and cancelled = 0 and sanctioned = 1
									and fromdate >= '".$effectivedate."' ";
			$leavetakenResult=$GLOBALS['db']->query($leavetakenQuery);
			$leavetakenRow=$leavetakenResult->fetch_assoc();
			$leavetaken=$leavetakenRow['leavestaken'];		
			$leaveBal=$eligibledays-$leavetaken;
			if($leaveBal<0)
			{
			$leave_types.="<option value=\"".$leavetypeid."~".$leaveBal."\" 
			title=\"You have exceeded ".-($leaveBal)." days from allowed under  ".$leavetypename." \" ";
			if($leavetypeid1==$leavetypeid) {$leave_types.="selected=\"selected\" ";}
			$leave_types.=">".$leavetypename."</option>";			
			}
			else
			{
			$leave_types.="<option value=\"".$leavetypeid."~".$leaveBal."\" \" title=\" You are eligible to take ".$leaveBal." more days under  ".$leavetypename."\" ";
			if($leavetypeid1==$leavetypeid) {$leave_types.="selected=\"selected\" ";}
			$leave_types.=">".$leavetypename."</option>";
			}			
		}		
	}//while ends	
	return ucwords($leave_types);
}
function dateDiff($fromDate, $endDate,$dformat='/'){
$from=explode($dformat,$fromDate);
$to=explode($dformat,$endDate);
$from_Date = mktime(00,00,01,$from[1],$from[0],$from[2]);
$to_Date = mktime(00,00,01,$to[1],$to[0],$to[2]);
$diff_seconds  = $to_Date - $from_Date;
$diff_days     = floor($diff_seconds/86400);
	return $diff_days ;
} 

function getMail(){
	$empQuery=" select e.email,e.fullname,d.hod from employee as e,department as d where d.hod=e.employeeid and d.departmentid='".$_SESSION['DEPART']."' 	";
	$resultEmpQuery = $GLOBALS['db']->query($empQuery);
		if(isset($resultEmpQuery) and $resultEmpQuery->num_rows>0) {
			while($row = $resultEmpQuery->fetch_assoc()) {
				$data['mail']=$row['email'];
				$data['name']=$row['fullname'];
				$data['hod']=$row['hod'];//hod employee id
			}
		}
		return 	$data;
}
function getEmpMail($employeeid){
	//$empQuery=" select email,fullname from employee where  employeeid='".$_SESSION['USERID']."' ";
	$empQuery=" select email,fullname from employee where  employeeid='".$employeeid."' ";
	$resultEmpQuery = $GLOBALS['db']->query($empQuery);
		if(isset($resultEmpQuery) and $resultEmpQuery->num_rows>0) {
			while($row = $resultEmpQuery->fetch_assoc()) {
				$data['mail']=$row['email'];
				$data['name']=$row['fullname'];
			}
		}
		return 	$data;
}
  
function getLeaveType($typeid){
	$empQuery=" select name ,	shortname from leavetype where  leavetypeid='".$typeid."' ";
	$resultEmpQuery = $GLOBALS['db']->query($empQuery);
		if(isset($resultEmpQuery) and $resultEmpQuery->num_rows>0) {
			while($row = $resultEmpQuery->fetch_assoc()) {
				$data['name']=$row['name'];
				$data['code']=$row['shortname'];
			}
		}
		return 	$data;
}

function getPermissionDrop($sel=0){	
 $permissionMax=getsettings('permissionMaxTime');
 $data="";
for($x=30; $x <= $permissionMax; $x += 30){
	if($x==30){ $show=" 30 mins ";}
	else if($x==60){ $show=" 1 hour ";}
	else if(($x%60)>0){
		$h=floor($x/60);
		$show=$h." hours  30 mins";
		}else{
			$h=floor($x/60);
				$show=$h." hours ";
		}
							$data .="<option value=\"".$x."\" " ;
							if($x==$sel) { $data.="	selected=\"selected\" ";	}
							$data.="	>".$show."</option>";
							}
							return $data;
							}
//get Leave Details for View Leave
function viewleave($depmentid)
{
$permissionID=getsettings('permissionid');
$emp_power=emp_authority($_SESSION['USERID']);
$from=$_SESSION['from'];
$to=$_SESSION['to'];


$query="select 
				l.leaveapplicationid,l.employeeid,l.leavetypeid,l.fromtime,l.duration,DATE_FORMAT(l.fromdate,'%d-%m-%Y') as fromdate,DATE_FORMAT(l.todate,'%d-%m-%Y') as todate,l.sanctioned,l.employeeremarks,l.leavedays,l.cancelled,t.name,e.fullname
			from 
				leaveapplication as  l,
				employee as e,
				department as d,
				leavetype as t 
			where 
				l.employeeid=e.employeeid
				and
				l.leavetypeid=t.leavetypeid
				and
				e.departmentid = d.departmentid				
				and
				l.fromdate  between '".$from."' and '".$to."' 
				";
/*
				if(isset($depmentid) and $depmentid>0)
				{
*/
					$nemps="";											
			foreach(emp_list_after_reporting_to($_SESSION['USERID'],$emp_power) as $em){
				$nemps .=($nemps=="")? $em : ",".$em;
				}
			$query.="	and	e.departmentid ='".$depmentid."' and e.employeeid in (".$nemps.") order by e.fullname ";
/*
				}
*/
			$result = $GLOBALS['db']->query($query);
		//	print $result->num_rows;
			if(isset($result) and $result->num_rows>0) {
        			$i=1;
				while ($row1 = $result->fetch_assoc())
				 {
				 		//Checking whether leavetype is permission
				 		$leavetypeId=$row1['leavetypeid'];	
						if($leavetypeId==$permissionID)	
						{
							$fromDate=$row1['fromdate'];								
										$fromtime=$row1['fromtime'];
										$duration=$row1['duration'];
										//calculation of duration
										if($duration==30)
										{ 
											$showDuration=" 30 mins ";
										}
										else if($duration==60)
										{ 
											$showDuration=" 1 hour ";
										}
										else if(($duration%60)>0)
										{
											$h=floor($duration/60);
											$showDuration=$h." hours  30 mins";
										}
										else
										{
											$h=floor($duration/60);
											$showDuration=$h." hours ";
										}
										//
							$toDate="From time: ".$fromtime."<br/>Duration: ".$showDuration;
							$leavedays="-";
						}	
						else
						{
							$fromDate=$row1['fromdate'];
							$toDate=$row1['todate'];
							if($toDate=='00-00-0000')
							{ $toDate="-"; } 
							$leavedays=$row1['leavedays'];
						}
							
						
						if($row1['sanctioned']==3)//cancellled
						{ 
							$status="Cancelled"; $cancelBtn="<input type=\"button\" name=\"cancel\" id=\"cancel\" value=\"Cancel\" disabled=\"disabled\" />";
						}						
						else if($row1['sanctioned']==2)//Rejected
						{ 
							$status="Rejected";  $cancelBtn="<input type=\"button\" name=\"cancel\" id=\"cancel\" value=\"Cancel\" disabled=\"disabled\" />"; 
						}
						else if($row1['sanctioned']==1)//Approved
						{ 		
							if($row1['cancelled']==1)
							{
								$status="Cancelled";$cancelBtn="<input type=\"button\" name=\"cancel\" id=\"cancel\" value=\"Cancel\" disabled=\"disabled\" />"; 
							}
							else
							{					
							$status="Approved";	$cancelBtn="<input type=\"button\"  name=\"cancel\" id=\"cancel\" value=\"Cancel\" onclick=\"javascript:cancelLeave(".$row1['leaveapplicationid'].",'".$depmentid."');\" />";	
							}						
						}						
						else if($row1['sanctioned']==0)//pending
						{
						
							if($row1['cancelled']==1)
							{
								$status="Cancelled";$cancelBtn="<input type=\"button\" name=\"cancel\" id=\"cancel\" value=\"Cancel\" disabled=\"disabled\" />"; 
							}
							else
							{
								$status="Pending"; $cancelBtn="<input type=\"button\" name=\"cancel\" id=\"cancel\" value=\"Cancel\" disabled=\"disabled\" />"; 
							}	
						}	
					if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
						$records .= "<tr valign=\"middle\" ".$class.">
        					<td width=\"3px\" align=\"center\"height=\"40px\" class=\"link_txt\">" . $i++ . "</td>
        					<td nowrap=\"true\" class=\"link_txt\">&nbsp;".$row1['fullname']."";

						
							$records .= "</td>";						
        					$records .= "<td class=\"link_txt\">&nbsp;".$row1['name']. "</td>
						<td class=\"link_txt\">&nbsp;".$fromDate. "</td>
						<td class=\"link_txt\">&nbsp;".$toDate. "</a></td>
						<td class=\"link_txt\">&nbsp;".$leavedays. "</a></td>
						<td class=\"link_txt\">&nbsp;".$row1['employeeremarks']. "</a></td>						
						<td class=\"link_txt\">&nbsp;".$status. "</td>";	
						//cancel button not shown for HR
						if(($emp_power['is_admin']==1) || ($emp_power['is_hod']==1) || ($emp_power['is_adminemp']==1)){
						
						 $records .="<td class=\"link_txt\">&nbsp;".$cancelBtn."</td>";
												
						}
					 	$records .="<input type=\"hidden\" value=\"".$row1['leaveapplicationid']."\" id=\"leaveidd\" name=\"leaveidd\" />							
      					</tr>						
						";
						
					}
			}
			return $records;
}
//get dep
function getDepartmentList($emp_power,$departid)
{  
	 
/*
	$select = "SELECT distinct(d.departmentid), d.depname, d.depdescription FROM department as d , employee as e ";
	$filter = " WHERE ( d.departmentid in (".$emp_power['emp_deptid'].") or e.employeeid in (".$emp_power['from_rep'].") ) and d.departmentid=e.departmentid and e.empstatus='active' ";
	$order = " ORDER BY depname ";
	
	
	if($departid=="")
	{
		$departid=$emp_power['emp_deptid'];
	}
	if($emp_power['is_hr']=="1")
	{
		$filter = " WHERE 1=1";
   	}
	else 
	{
		$dept = $emp_power['emp_deptid'];
		
		if($emp_power['is_hod']== 1)
		 	$dept .= "," . $emp_power['ishod_deptid'] ;
		 
		 if($emp_power['is_admin']==1 and $emp_power['isadm_deptid'] != "") 
		 	$dept .= "," . $emp_power['isadm_deptid'];
			
		 $filter = " WHERE departmentid in (".$dept.")";
	}		
	
	 $query = $select . $filter . $order ;
	$result = $GLOBALS['db']->query($query);
*/  
 
	 $data['list']="";
	 $data['dept_option']="";
$result=get_new_dept_list($emp_power['emp_id'],$emp_power) ;
	while($row = $result->fetch_assoc())
	{		
		$data['list'] .= ($data['list']!="")?",":"";
		$data['list'] .=$row['departmentid'];
		$data['dept_option'] .= "<option value=\"" . $row['departmentid'] . "\" title=\"".$row['depdescription']."\" ";
		if($row['departmentid']==$departid) {$data['dept_option'] .= " selected=\"selected\""; } 
		$data['dept_option'] .= ">".ucwords($row['depname'])."</option>";	
	}
	return $data;
}
//to get employee for hr and hod/admin:
function employeelist($emp_power,$depid,$emp_id)
{ 
/*
				$query="SELECT distinct e.employeeid,
									    e.fullname,
									    e.departmentid,
									    isadmin
							FROM employee e,
									 department d	
							WHERE e.departmentid=d.departmentid  AND e.empstatus='active' AND e.employeeid > 1 AND e.departmentid =".$depid." ";
				// if not HR/HoD/Admin, select single employee only :			
				if(($emp_power['is_superadmin'] != 1) and ($emp_power['is_admin'] !=1) and ($emp_power['is_hod'] !=1) and ($emp_power['is_hr'] !=1) )
					$query .= " AND e.employeeid=".$_SESSION['USERID'] . "" ;

				// if Not HoD and Not Admin of the department, select only single employee :	
				if ($depid != $emp_power['ishod_deptid']) {
					if(($emp_power['is_admin'] ==1) and (in_array($depid, explode(",", $emp_power['isadm_deptid'])) != TRUE))
						$query .= " AND e.employeeid=".$_SESSION['USERID'] . "" ;
				}
				$query.=" ORDER BY e.fullname ";
				$result = $GLOBALS['db']->query($query);
			
*/
$result = get_new_employee_list($depid,$emp_power);
			  	if(isset($result) and $result->num_rows>0)
				{
					$employee['options']="";
					$employee['list']="";
					$employee['selected']="";
						if($emp_id==""){
				 		$emp_id="";
					 	$employee['options'].= " <option value=\"0\">Select Employee</option>";
					 	
					 	} 
					while($row = $result->fetch_assoc())
					{ 
						$employee['list'] .= ($employee['list']!="")?",":"";
						$employee['list'] .=$row['employeeid'];
						$employee['options'].= " <option value=\"".$row['employeeid']."\"";
						if($row['employeeid'] == $emp_id)
						{ 
							$employee['options'].= " selected=\"selected \"";
							$employee['selected']=ucwords($row['fullname']);
						}  
						$employee['options'].= " title=\"".$row['fullname']."\">".$row['fullname']."";
						$employee['options'].= " </option>";					
					} 
			  }			   
			 $employee['employeeid']= $emp_id;			  
			 return $employee;
}
 
					function mailstosend($employeeid)
					{
						//  to find to whom the mail is to be send
						$apply_power=emp_authority($_SESSION['USERID']);
						$user_power=emp_authority($employeeid);
						$data['user']=$user_power;
						$data['apply']=$apply_power;
						$hr_email=getsettings('hremail'); 
						$data['approve_leave']=0;
						$data['enteredby']=$employeeid;
						$data['sanctioned']=0;
						$data['sanctionedby']=0;
						$data['mail_add_to_send']=array($user_power['dep_hod_email'],$user_power['emp_email'],$hr_email); 
						
						
						
 						if($apply_power['emp_id']!=$user_power['emp_id'])
						{  
							
							
							
							
							
							
							
						if($apply_power['is_hr']==1)
						{ 
						// if applying for hod
						if(($user_power['is_hod']==1)||($user_power['is_admin']==1)){
						$data['mail_add_to_send']=array($user_power['dep_admin_email'],$user_power['emp_email'],$hr_email); 
						}
						else	if($user_power['is_hr']==1){
						// if an hr applying leave for another hr employee
						$admin_email=get_hr_admin_email();
						$data['mail_add_to_send']=array($user_power[dep_hod_email],$admin_email,$user_power['emp_email']);													
						}
						else{
						//for normal employee 
						$data['mail_add_to_send']=array($user_power['dep_hod_email'],$user_power['emp_email'],$hr_email); 
						}
						
						
						}
						elseif($apply_power['is_hod']==1)
						{    
							$data['sanctioned']=1;
							$data['sanctionedby']=$apply_power['emp_id']; 																				
						}
						elseif($apply_power['is_super']==1)
						{
						}  
						//$data['approve_leave']=1;
						$data['enteredby']=$apply_power['emp_id'];
						//printarray($data);
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						}
						else
						{
													$data['enteredby']=$employeeid;
													if($apply_power['is_hod']==1)
													{
													$data['mail_add_to_send']=array($user_power['dep_admin_email'],$user_power['emp_email'],$hr_email); 												
													}
													else if($apply_power['is_hr']==1)
													{
													$admin_email=get_hr_admin_email();
													$mailsto=array($user_power[dep_hod_email],$hr_email,$user_power['emp_email']);
													}
													else
													{	
													
													}
						}
						
						
						
						
					if( $user_power['is_repto'] != ""){			 								
					$repto=explode(",",$user_power['is_repto']);
					foreach($repto as $em){
					$data['mail_add_to_send'][]=get_empid_email($em);
					}
					$data['mail_add_to_send']= array_unique($data['mail_add_to_send']);  
					}
						
						
						
						
						
						return $data;
					}
					 
					function get_hr_admin_email()
					{
					$hridList=getsettings('hrid');
		$query="SELECT email FROM employee where employeeid in (".$hridList.") and isadmin=1 ";
  $result = $GLOBALS['db']->query($query); 
	$i=100;
  while($row = $result->fetch_assoc()){
		$i++;
		$data[$i]=$row['email'];
	}
   return $data;
				}
				
//fro view page				
function getDepartmentList1($emp_power,$departid)
{  
	/*$emp_power = emp_authority($_SESSION['USERID']); 

	if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
	{
		$dept_list="";	
		
		if(($emp_power['is_superadmin']=="1")||($emp_power['is_admin']=="1"))
		{
			$dept_list.=$emp_power['isadm_deptid'];
		}		
		if($emp_power['is_hod']=="1")
		{ 
			$dept_list.=($dept_list!="")?",":"";
			$dept_list.=$emp_power['ishod_deptid'];
		}
		
	}
	$query = "SELECT departmentid, depname,depdescription FROM department";
	$query .=" WHERE departmentid in(".$dept_list.") order by depname";*/	
	if($departid=="")
	{
		$departid=$emp_power['emp_deptid'];
	}
	if($emp_power['is_hr']=="1")
	{
		$query = "SELECT departmentid, depname,depdescription FROM department order by depname";
   	}
	 else if($emp_power['is_adminemp']=="1")
	{
		 $query = "SELECT departmentid, depname,depdescription FROM department  ";
		 $query .=" WHERE departmentid in(".$emp_power['isadm_deptid'].") order by depname";
	}	
	 else if($emp_power['is_hod']=="1")
	{
		 $query = "SELECT departmentid, depname,depdescription FROM department  ";
		 $query .=" WHERE departmentid in(".$emp_power['ishod_deptid'].") order by depname";
	}	
	
	else
	{
		 $query = "SELECT departmentid, depname,depdescription FROM department";
		 $query .=" WHERE departmentid in(".$emp_power['emp_deptid'].") order by depname";
	}
	//echo $query;
	
	$result = $GLOBALS['db']->query($query);
	$data['list']="";
	$data['dept_option']="";
	
	
	
	while($row = $result->fetch_assoc())
	{		
		$data['list'] .= ($data['list']!="")?",":"";
		$data['list'] .=$row['departmentid'];
		$data['dept_option'] .= "<option value=\"" . $row['departmentid'] . "\" title=\"".$row['depdescription']."\" ";
		if($row['departmentid']==$departid) { $data['dept_option'] .= " selected=\"selected\""; } 
		$data['dept_option'] .= ">" . ucwords($row['depname']) . "</option>";	
	}
	return $data;
}
?>
