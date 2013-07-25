<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="MAP";
require_once('include/parameters.php');
require_once('include/meeting_functions.php');


																	


if(isset($_POST['count']))
{
	$i=$_POST['count'];
	$status=$_POST[$i.'status'];
	$mid=$_POST[$i.'mid'];
	$fromemp=$_POST[$i.'fromemp'];	
	$notific=$_POST[$i.'comments'];	
	if($status==1) { $upstatus="allow"; $msgstatus="approved";} else if($status==2) {$upstatus="deny"; $msgstatus="rejected";} else if($status==3) {$upstatus="cancel";$msgstatus="cancelled";}
	$query="update meeting set status='".$upstatus."',notification='".$notific."' where meetingid='".$mid."'";
	$result = $GLOBALS['db']->query($query);
	if($result) {$message="Meeting has been ".$msgstatus;} else {$message="";}
	
	
	//mail sending
	if($status==1) 
	{
				$querymeeting="select * from meeting where meetingid='".$mid."'";
				$resultmet = $GLOBALS['db']->query($querymeeting);
				$rowmeeting = $resultmet->fetch_assoc();
				$duration=$rowmeeting['duration'];
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
								
					
									$emps=(!empty($rowmeeting['people']))?$rowmeeting['people']:"";
									$getrow=unserialize($emps);
									$select_emps="";$viewemp="";
									$deparr=array();
									if(!empty($getrow)){									
										foreach($getrow as $dep=>$value)
										{
												$deparr[]=$dep;												
												foreach($value as $k)	
												{
													$select_emps[]=$k;													
												}																			
										}
											
								  }
	
	
	$arr_unique_depid=array_unique($deparr);
	$arr_empid=array_unique($select_emps);
	
	
										/*========get email_id of HODs========*/										
										$j=0;
										foreach($arr_unique_depid as $id)
										{
											$query="select e.fullname,e.email from employee e,department d where d.hod=e.employeeid and d.departmentid='".$id."' ";
											$result = $GLOBALS['db']->query($query);
											$row = $result->fetch_assoc();
											$hod_emails[$j]=$row['email'];
											$j++;											
										}
										/*=======get email_id of Employees========*/	
											$k=0;					
											foreach($arr_empid as $emp)
											{
											$query="select fullname,email from employee  where employeeid='".$emp."' ";
											$result = $GLOBALS['db']->query($query);
											$row = $result->fetch_assoc();
											$emp_emails[$k]=$row['email'];
											$k++;	
											}
											/*==============================*/
											$hod_emails1=(!empty($hod_emails))?$hod_emails:"";
											$all_emails=array_unique(array_merge($hod_emails1,$emp_emails));
																						
											require_once('include/class.mail.php');
											$obj=new mail();
											$meeting_mail=getsettings('meeting_mail');
											
											$query_id="select email from employee where employeeid in (".$meeting_mail.")";											
											$result_id = $GLOBALS['db']->query($query_id);
											if(isset($result_id) and $result_id->num_rows>0)
											{
												$email="";
												while($row_id = $result_id->fetch_assoc())
												{
													$emailid=$row_id['email'];
													if($email!="")
													{
														$email.=",";
													}
													$email.=$emailid;	
												}
											}
											
											$query_admin="select email from employee where employeeid ='1'";											
											$result_admin = $GLOBALS['db']->query($query_admin);
											if(isset($result_admin) and $result_admin->num_rows>0)
											{
												while($row_admin = $result_admin->fetch_assoc())
												{
													$admin_id=$row_admin['email'];
												}
											}
											
											$queryfromemp="select e.fullname,e.email,d.depname from employee e,department d where e.employeeid='".$fromemp."' and e.departmentid=d.departmentid";
											$resultfromemp = $GLOBALS['db']->query($queryfromemp);
											$row_from_email = $resultfromemp->fetch_assoc();
											$data['from']=$row_from_email['email'];	
											$data['to']=$all_emails;
											$data['bcc']=array('raghu.n@primemoveindia.com',$email,$admin_id);
											$data['subject']="WRS::Meeting::".trunc($rowmeeting['title'],0,15);	
											$data['message']="Hi, \n Meeting invitation from ".$row_from_email['fullname']." [ ".$row_from_email['depname']." ]
											\nSubject: ".$rowmeeting['title']."\nAgenda: ".$rowmeeting['descr']."\nDate: ".$rowmeeting['schdate']."\nTime: ".$rowmeeting['schtime']."\nDuration: ".$showDuration."";	
											$value1=$obj->mailsend($data);
											//printarray($data);
											$message.=" <br/> Mail has been sent successfully ";
	}
	
	
	
}

$data=approvemeetings();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Home </title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/calendar.css" rel="StyleSheet">
<link href="css/style.css" rel="StyleSheet">

<style  type="text/css">
.lev{
<!--border:1px solid #464646;-->
padding:3px;
}
</style>
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/effects.js"></script>
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
      <?php 
      $menu=show_menu();
      print $menu;
      ?>
      
     
      
      </td>
      <td width="100%" height="30px" valign="top"  class="head_with_back_button"><?php print get_table_link("Approve meeting","approve_lvicon.gif");?>
      </td>
    </tr>
    <tr>
      <td height="580" valign="top" class="back_td"   class="leave_table" > 
      <div  class="leave_table"  valign="top">
      <table border="1" width="100%">
          <tr>
              <td>
                <!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
      <table border="1"  class="approve_table">
      <tr>
      <th colspan="7">
      Meeting Details
      </th>
      </tr>     <?php 
              if(  $data['table'] != ""){
              ?>
      <tr>
              <td colspan="7" id="validate" name="validate"><?php 
              print $message;
              ?></td>
              </tr>			  
			  <?php 
		  }
          ?>
          
              <?php //		Date
              if(  $data['table'] != ""){
              ?>
          <tr>
              <th>
              Sl no:
              </th>
              <th>
							From 
              </th>
							 <th>
              Title
              </th>   
							 <th>
              Description
              </th>   
              <th>
              Date
              </th>
              <th>
              People
              </th>
              <th>
              Comments
              </th>
                        
          </tr>
          <?php 
          print $data['table'];}
          else{
			  ?>
			  <tr><td>No Records Found</td></tr>
			  
			  <?php 
		  }
          ?>
          
      </table>          
      
      <!--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
              </td>
              <!-- 888888888888888888888888888888888888888888888888888
              <td>
              <table>
                  <tr>
                      <td>
                      </td>
                  </tr>
              </table>
              </td> 
              888888888888888888888888888888888888888888888888888 -->
          </tr>
      </table>
    
      </div>
  </td>
    </tr>
     <tr>
      <td height="30px" colspan="4" align="center" valign="middle"  class="Footer_txt"><?php footer();?></td>
    </tr>
  </table>
</div>
</body>
</center>
